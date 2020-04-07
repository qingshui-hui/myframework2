<?php

namespace Libs\Http;

use Libs\Support\ArrayUtil;

class Errors
{
  private $data = [];

  public function get($keySet) :Array
  {
    return ArrayUtil::get_deep($this->data, $keySet, []);
  }

  public function put($keySet, $value)
  {
    $this->data = ArrayUtil::put_deep($this->data, $keySet, $value);
  }

  public function changeMessage($tag, $message)
  {
    // $tag = 'email.required' のというような文字列のみを想定
    // エラーの構造は、$this->data = ['email => ['required' => 'error message', 'max' => 'error message']]
    if (substr_count($tag, '.') != 1) {
      return;
    } else {
      $this->put($tag, $message);
    }
  }

}