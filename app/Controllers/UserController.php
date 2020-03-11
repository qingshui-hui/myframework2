<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
  public function showLoginForm()
  {
    require_once 'views/users/login_form.php';
  }

  public function login()
  {
    session_start();
    if (User::authenticateUser($_POST)) {
      print_r($_SESSION['user']);
      echo 'ログインしました';
      header("Location: /");
    }
    else {
      echo 'ログインに失敗しました';
    }
  }

  public function logout()
  {
    session_start();
    $_SESSION = array();
    // session_destory();
    header("Location: /");
  }

  public function showRegisterForm()
  {
    require_once 'views/users/register_form.php';
  }

  public function register()
  {
    $user = new User();
    $user->create($_POST);
    header("Location: /");
  }
}