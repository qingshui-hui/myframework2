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

  public function __construct()
  {
    parent::__construct();
  }

  public static function authenticateUser($params) :bool
  {
    $db = Database::getInstance();
    $query = "SELECT * FROM users WHERE email = :email LIMIT 1;";
    $userData = $db->query($query, ['email' => $params['email']])[0];
    if ($params['password'] == $userData['password']) {
      Session::push('user', $userData);
      return true;
    }
    else {
      return false;
    }
  }

  public static function isLogin()
  {
    if (Session::get('user')) {
      return true;
    }
    else {
      return false;
    }
  }

}