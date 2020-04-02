<?php

namespace App\Middleware;
use App\Models\User;
use Libs\Http\Session;

class Authenticate
{
  // ルーティングの設定により、default が呼び出される
  public function default() :bool
  {
    return $this->RedirectIfNotLogin();
  }

  private function RedirectIfNotLogin() :bool
  {
    if (!User::isLogin()) {
      Session::push("stored_url", $_SERVER['REQUEST_URI']);
      header('Location: /login');
      return false;
    } else {
      return true;
    }
  }
}