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
    'min' => 'checkMin',
    'nullable' => 'nullable',
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

  private function exist($value) :bool
  {
    if (!isset($value)) {
      return false;
    } else if (is_string($value)) {
      $value = trim($value);
      if ($value === "") {
        return false;
      }
    }
    return true;
  }

  private function checkExistence($key) :bool
  {
    if (!$this->exist($this->input[$key])) {
      $this->errors->put("{$key}.required", "{$key}が入力されていません");
      return false;
    } else {
      $this->validatedInput[$key] = $this->input[$key];
      return true;
    }
  }

  private function checkUniqueness($key, $dataTable) :bool
  {
    $db = Database::getInstance();
    if (isset($this->input['id'])) {
      // id が渡されたときは、そのidのレコードについては唯一性のチェックから外すように修正
      $id = intval($this->input['id']);
      $query = "SELECT * FROM {$dataTable} WHERE {$key} = :{$key} AND NOT id = :id;";
      $params = [$key => $this->input[$key], 'id' => $id];
    } else {
      $query = "SELECT * FROM {$dataTable} WHERE {$key} = :{$key};";
      $params = [$key => $this->input[$key]];
    }
    $data = $db->query($query, $params);

    if (count($data) > 0) {
      $this->errors->put("{$key}.unique", "この{$key}はすでに使用されています");
      return false;
    } else {
      $this->validatedInput[$key] = $this->input[$key];
      return true;
    }
  }

  private function checkMax($key, $intMax) :bool
  {
    if (!$this->exist($this->input[$key])) {
      return true;
    }
    if (mb_strlen($this->input[$key]) > $intMax) {
      $this->errors->put("{$key}.max", "{$key}の最大文字数は{$intMax}です");
      return false;
    } else {
      $this->validatedInput[$key] = $this->input[$key];
      return true;
    }
  }

  private function checkMin($key, $intMin) :bool
  {
    if (!$this->exist($this->input[$key])) {
      return true;
    }
    if (mb_strlen($this->input[$key]) < $intMin) {
      $this->errors->put("{$key}.min", "{$key}の最小文字数は{$intMin}です");
      return false;
    } else {
      $this->validatedInput[$key] = $this->input[$key];
      return true;
    }
  }

  private function nullable($key) :bool
  {
    if (isset($this->input[$key] )) {
      $this->validatedInput[$key] = $this->input[$key];
    }
    return true;
  }
}