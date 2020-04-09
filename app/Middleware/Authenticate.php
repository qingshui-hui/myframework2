<?php

namespace App\Middleware;
use App\Models\User;
use Libs\Http\Session;

class Authenticate
{
  // ルーティングの設定により、default が呼び出される
  // 通過が許可されたときにtrue, そうでないとき必要な処理を行うようなメソッドにする
  public function default() :bool
  {
    return $this->RedirectIfNotLogin();
  }

  private function RedirectIfNotLogin() :bool
  {
    if (User::isLogin()) {
      return true;
    } else {
      Session::put("stored_url", $_SERVER['REQUEST_URI']);
      header('Location: /login');
      return false;
    }
  }
}