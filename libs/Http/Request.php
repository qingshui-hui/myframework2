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

  public function isset($key)
  {
    // ["", null] はセットされていないとみなす。
    if ($this->get($key) === null) {
      return false;
    } else {
      if ($this->get($key) === "") {
        return false;
      }
    }
    return true;
  }

  public function get($key, $default = null)
  {
    return ArrayUtil::get_deep($this->data, $key, $default);
  }

  public function put($key, $val)
  {
    $this->data = ArrayUtil::put_deep($this->data, $key, $val);
  }

  public function forget($key)
  {
    return ArrayUtil::unset_deep($this->data, $key);
  }

  public function setData(array $data)
  {
    $this->data = $data;
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