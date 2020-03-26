<?php
// 直後のsessionにだけ、エラーと、入力値を保存して、前のページへリダイレクトするのがlaravel

namespace Libs\Http;

class Request
{
  protected $request;
  protected $files;

  public function __construct()
  {
    $this->request = $_REQUEST;
    $this->files = $_FILES;
    $this->session = new Session();
  }

  public function all()
  {
    return $this->request;
  }

  public function get($key)
  {
    if (isset($this->request[$key])) {
      return $this->request[$key];
    } else {
      return null;
    }
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
    session_start([
      'read_and_close' => true
    ]);
    if (isset($_SESSION['request'])) {
      $oldRequest = $_SESSION['request'];
      return $oldRequest->get($key);
    }
  }

  public static function session()
  {
    return new Session();
  }
}