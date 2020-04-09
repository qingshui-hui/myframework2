<?php

namespace App\Models;

use Libs\Database\Model;
use Libs\Http\Request;

class Todo extends Model
{
  protected static $table = "todos";
  protected $primaryKey = ['id'];
  protected $properties = ['id', 'content', 'user_id', 'deadline',  'created_at', 'updated_at'];

  public static function allWithUsers()
  {
    $db = \Libs\Database\Database::getInstance();
    $query = "select todos.*, users.name as user_name, users.email as user_email from todos 
        join users on todos.user_id = users.id";
    $todos = $db->query($query);
    return static::arrayToObjectList($todos);
  }

  public function convertToRequest()
  {
    $this->addPropertiesInForm();
    $request = new Request();
    $request->setData([]);
    $request->put('id', $this->id);
    $request->put('content', $this->content);
    $request->put('user_id', $this->user_id);
    $request->put('date', $this->date);
    $request->put('hour', $this->hour);
    $request->put('minute', $this->minute);
    return $request;
  }

  public function addPropertiesInForm()
  {
    $time = strtotime($this->deadline);
    $this->date = date('Y/m/d', $time);
    $this->hour = date('H', $time);
    $this->minute = date('i', $time);
  }

  public function user()
  {
    return User::find($this->user_id) ?? new User();
  }

  public function deadline()
  {
    // 11:0 -> 11:00 となるように変換
    return date('Y/m/d H:i', strtotime($this->deadline));
  }

  public function dead() :bool
  {
    if (strtotime($this->deadline) < strtotime('now')) {
      return true;
    } else {
      return false;
    }
  }
}