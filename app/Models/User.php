<?php

namespace App\Models;
use Libs\Database;

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
      session_start();
      $_SESSION['user'] = $userData;
      return true;
    }
    else {
      return false;
    }
  }

  public static function isLogin()
  { 
    if (!isset($_SESSION))
      session_start();
    if (isset($_SESSION['user'])) {
      return true;
    }
    else {
      return false;
    }
  }

}