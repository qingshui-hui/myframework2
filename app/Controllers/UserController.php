<?php

namespace App\Controllers;

use App\Models\User;
use Libs\Http\Session;
use Libs\Http\Request;

class UserController
{
  public function showLoginForm()
  {
    return view('users/login_form.php')->setLayout('layout/app.php');
  }

  public function login()
  {
    if (User::authenticateUser(new Request())) {
      // if (isset($_SESSION['stored_url'])) {
      //   $next = Session::get('stored_url');
      //   Session::put('stored_url', null);
      //   header("Location: ".$next);
      // } else {
        header("Location: /");
      // }
      exit();
    } else {
      echo 'ログインに失敗しました';
    }
  }

  public function logout()
  {
    Session::destroy();
    header("Location: /");
    exit();
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
    exit();
  }

  public function show()
  {
    $isLogin = User::isLogin();
    $user = Session::get('user');
    return view('users/show.php', ['isLogin' => $isLogin, 'user' => $user])->setLayout('layout/todo.php');
  }
}