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
  private static $instance = null;
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
    
    foreach($validations as $inputKey => $validation) {
      $checkList = preg_split("#\|#", $validation);
      $checkListB = array_map(function($a){return preg_split("#:#", $a);}, $checkList);
      foreach($checkListB as $pair) {
        // $pair[0] is validation tag, $pair[1] is param.
        if (isset($pair[1])) {
          $args = explode(',', $pair[1]);
        } else {
          $args = [];
        }
        self::$instance->execute($inputKey, $pair[0], $args);
      }
    }
    return self::$instance;
  }

  public function execute($inputKey, $validationName, array $args)
  {
    $method = new \ReflectionMethod('Libs\Http\Validator', self::validationList[$validationName]);
    $method->setAccessible(true);
    $args = array_merge([$inputKey], $args);
    if (!$method->invokeArgs($this, $args)) {
      $this->isValid = false;
    };
    return $this;
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

  private function emptyInput($value) :bool
  {
    if (!isset($value)) {
      return true;
    } else if (is_string($value)) {
      $value = trim($value);
      if ($value === "") {
        return true;
      }
    }
    return false;
  }

  private function checkExistence($key) :bool
  {
    if ($this->emptyInput($this->input[$key])) {
      $this->errors->put("{$key}.required", "{$key}が入力されていません");
      return false;
    } else {
      $this->validatedInput[$key] = $this->input[$key];
      return true;
    }
  }

  private function checkUniqueness($key, $dataTable, $exceptionalKey=null, $exceptionalVal=null) :bool
  {
    $db = Database::getInstance();
    $query = "SELECT * FROM {$dataTable} WHERE {$key} = :{$key}";
    $params = [$key => $this->input[$key]];
    if (isset($exceptionalKey) && isset($exceptionalVal)) {
      $query .= " AND NOT {$exceptionalKey} = :{$exceptionalKey}";
      $params[$exceptionalKey] = $exceptionalVal;
    } else if (isset($this->input['id'])) {
      // id が渡されたときは、そのidのレコードについては唯一性のチェックから外すように修正
      $id = intval($this->input['id']);
      $query .= " AND id <> :id";
      $params['id'] = $id;
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
    if ($this->emptyInput($this->input[$key])) {
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
    if ($this->emptyInput($this->input[$key])) {
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