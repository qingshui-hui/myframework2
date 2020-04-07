<?php
// 直後のsessionにだけ、エラーと、入力値を保存して、前のページへリダイレクトするのがlaravel

namespace Libs\Http;

use Libs\Support\ArrayUtil;

class Request
{
  protected $data;
  protected $files;

  public function __construct()
  {
    $this->data = $_REQUEST;
    $this->files = $_FILES;
    $this->session = new Session();
  }

  public function all()
  {
    return $this->data;
  }

  public function get($key)
  {
    return ArrayUtil::get_deep($this->data, $key);
  }

  public function files()
  {
    return $this->files;
  }

  public function file($name)
  {
    if (isset($_FILES[$name])) {
      return $this->files[$name];
    } else {
      return null;
    }
  }

  public static function old($key)
  {
    Session::get('request');
  }

  public static function session()
  {
    return new Session();
  }
}