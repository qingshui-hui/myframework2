<?php

namespace App\Middleware;
use App\Models\User;

class Authenticate
{
  public function default()
  {
    return $this->RedirectIfNotLogin();
  }

  private function RedirectIfNotLogin() :bool
  {
    if (!User::isLogin()) {
      session_start();
      $_SESSION["stored_url"] = $_SERVER['REQUEST_URI'];
      session_write_close();
      header('Location: /login');
      return false;

    } else {
      return true;
    }
  }
}