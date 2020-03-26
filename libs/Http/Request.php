<?php
// 次はvalidateメソッドを作る
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
  }

  public function all()
  {
    return $this->request;
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
}