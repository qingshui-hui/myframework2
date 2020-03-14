<?php

namespace App\Middleware;
use App\Models\User;

class Authenticate
{
  public function default()
  {
    $this->RedirectIfNotLogin();
  }

  private function RedirectIfNotLogin()
  {
    if (!User::isLogin()) {
      session_start();
      $_SESSION["stored_url"] = $_SERVER['REQUEST_URI'];
      header('Location: /login');
    }
  }
}