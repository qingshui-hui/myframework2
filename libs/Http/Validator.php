<?php

namespace Libs\Http;

use Libs\Http\Errors;
use Libs\Database\Database;

class Validator
{
  const validationList = [
    'required' => 'checkExistence',
    'unique' => 'checkUniqueness',
    'max' => 'checkMax',
    'nullable' => 'nullable'
  ];
  private  static $instance = null;
  private $input = null;
  private $validatedInput = [];
  private $errors;
  // 一つでも有効でなければ、$isValidはfalseに上書きされる
  private $isValid = true;

  private static function init()
  {
    self::$instance = new Validator();
    self::$instance->errors = new Errors();
  }

  public static function make(Array $input, Array $validations)
  {
    // $thisの代わりに、self::$instanceを使うという感じ
    self::init();
    self::$instance->input = $input;
    // self::$instance->errors = Errors::makeEmptyErrors(array_keys($input));
    foreach($validations as $key => $validation) {
      $checkList = preg_split("#\|#", $validation);
      $checkListB = array_map(function($a){return preg_split("#:#", $a);}, $checkList);
      foreach($checkListB as $pair) {
        // $pair[0] is validation tag, $pair[1] is param.
        $method = new \ReflectionMethod('Libs\Http\Validator', self::validationList[$pair[0]]);
        $method->setAccessible(true);
        if (isset($pair[1])) {
          if (!$method->invoke(self::$instance, $key, $pair[1])) {
            self::$instance->isValid = false;
          };
        } else {
          if (!$method->invoke(self::$instance, $key)) {
            self::$instance->isValid = false;
          };
        }
      }
    }
    return self::$instance;
  }

  public function fails()
  {
    if ($this->isValid) {
      return false;
    } else {
      return true;
    }
  }

  public function getErrors()
  {
    return $this->errors;
  }

  public function getValidated()
  {
    return $this->validatedInput;
  }

  public function getInput()
  {
    return $this->input;
  }

  // ---- private methods -------

  private function checkExistence($key) :bool
  {
    if (empty($this->input[$key])) {
      $this->errors->add($key, "{$key}が入力されていません");
      return false;
    } else {
      $this->validatedInput[$key] = $this->input[$key];
      return true;
    }
  }

  private function checkUniqueness($key, $dataTable) :bool
  {
    $db = Database::getInstance();
    $query = "SELECT * FROM {$dataTable} WHERE {$key} = :{$key};";
    $params = [$key => $this->input[$key]];
    $data = $db->query($query, $params);

    if (!empty($data)) {
      $this->errors->add($key, "この{$key}はすでに使用されています");
      return false;
    } else {
      $this->validatedInput[$key] = $this->input[$key];
      return true;
    }
  }

  private function checkMax($key, $intMax) :bool
  {
    if (empty($this->input[$key])) {
      return true;
    }
    if (strlen($this->input[$key]) > $intMax) {
      $this->errors->add($key, "{$key}の最大文字数は{$intMax}です");
      return false;
    } else {
      $this->validatedInput[$key] = $this->input[$key];
      return true;
    }
  }

  private function nullable($key) :bool
  {
    if (isset($this->input[$key])) {
      $this->validatedInput[$key] = $this->input[$key];
    }
    return true;
  }
}