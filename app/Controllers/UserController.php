<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
  public function showLoginForm()
  {
    return view('users/login_form.php')->setLayout('layout/app.php');
  }

  public function login()
  {
    // session_start();
    if (User::authenticateUser($_POST)) {
      // echo $_SESSION['stored_url'];
      if (!isset($_SESSION['stored_url'])) {
        header("Location: /");
      } else {
        // https://ja.stackoverflow.com/questions/5453/php-%E3%81%AE-headers-already-sent-%E3%82%A8%E3%83%A9%E3%83%BC%E3%81%AF%E3%81%A9%E3%81%86%E7%9B%B4%E3%81%97%E3%81%9F%E3%82%89%E3%81%84%E3%81%84%E3%81%A7%E3%81%99%E3%81%8B
        $next = $_SESSION['stored_url'];
        unset($_SESSION['stored_url']);
        header("Location: ".$next);
      }
    } else {
      echo 'ログインに失敗しました';
    }
  }

  public function logout()
  {
    session_start();
    unset($_SESSION['user']);
    // session_destory();
    header("Location: /");
  }

  public function showRegisterForm()
  {
    return view('users/register_form.php')->setLayout('layout/app.php');
  }

  public function register()
  {
    $user = new User();
    $user->create($_POST);
    header("Location: /");
  }
}