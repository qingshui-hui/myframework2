<?php

namespace App\Requests;

use Libs\Http\Request;
use Libs\Database\Database;
use App\Models\Todo;

class TodosSearchRequest
{
  private $request;

  public function __construct()
  {
    $this->request = new Request();
  }

  public function getTodos()
  {
    return $this->searchTodos();
  }

  // private

  private function searchTodos() :array
  {
    $db = Database::getInstance();
    $query = "select todos.*, users.name as user_name, users.email as user_email from todos 
        join users on todos.user_id = users.id where 1=1";
    $params = [];

    if ($this->request->isset('user_id')) {
      $query .= " AND user_id = :user_id";
      $params['user_id'] = $this->request->get('user_id');
    }

    if ($this->request->isset('start.date')) {
      $query .= " AND deadline >= :start";
      $params['start'] = $this->makeTimeString('start');
    }

    if ($this->request->isset('end.date')) {
      $query .= " AND deadline <= :end";
      $params['end'] = $this->makeTimeString('end');
    }

    $query .= " ORDER BY deadline";
    $todos = $db->query($query, $params);
    return Todo::arrayToObjectList($todos);
  }

  private function makeTimeString($timeName)
  {
    $date = $this->request->get("{$timeName}.date");
    $hour = $this->request->get("{$timeName}.hour");
    $minute = $this->request->get("{$timeName}.minute");
    // mysql 内において、比較可能な日時データにする。
    return "{$date} {$hour}:{$minute}";
  }
}