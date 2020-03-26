<?php

namespace Libs\Http;

class Errors
{
  private static $errors;

  public static function makeEmptyErrors(Array $keyList)
  {
    self::$errors = new Errors();
    foreach($keyList as $key) {
      self::$errors->$key = [];
    }
    return self::$errors;
  }

  public function add($key, $message)
  {
    if (empty($this->$key)) {
      $this->$key = [$message];
    } else {
      array_push($this->$key, $message);  
    }
  }

  public function get($key) :Array
  {
    if (isset($this->$key)) {
      return $this->$key;
    } else {
      return [];
    }
  }
}