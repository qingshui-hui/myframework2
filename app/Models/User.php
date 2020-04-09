<?php

namespace App\Models;

use Libs\Database\Model;
use Libs\Database\Database;
use Libs\Http\Session;

class User extends Model
{
  protected static $table = "users";
  protected $primaryKey = ['id'];
  protected $properties = ['id', 'name', 'email', 'password', 'created_at', 'updated_at'];

  public static function authenticateUser($request) :bool
  {
    $db = Database::getInstance();
    $query = "SELECT * FROM users WHERE email = :email LIMIT 1;";
    $userData = $db->query($query, ['email' => $request->get('email')])[0];
    if (!isset($userData)) {
      return false;
    }
    if ($request->get('password') == $userData['password']) {
      // ログインの度にsession id が変わる
      // セッションハイジャック対策
      session_regenerate_id(true);
      Session::put('user', User::arrayToObject($userData));
      Session::put('login', true);
      return true;
    }
    else {
      return false;
    }
  }

  public static function isLogin()
  {
    if (Session::get('login')) {
      return true;
    }
    else {
      return false;
    }
  }

}