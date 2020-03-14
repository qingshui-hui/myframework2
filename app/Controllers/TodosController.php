<?php

namespace App\Controllers;
use App\Models\Todo;
use App\Middleware\Authenticate;

class TodosController 
{
  public function index() 
  {
    $todos = Todo::all();
    require_once 'views/todos/index.php';
  }

  public function new()
  {
    require_once 'views/todos/new.php';
  }

  public function create()
  {
    $todo = new Todo();
    $params = $_POST;
    $todo->create($params);
    // redirect to $this->index()
    header("Location: /todos");
  }

  public function show()
  {
    $todo = Todo::find($_GET['id']);
    require_once 'views/todos/show.php';
  }

  public function edit()
  {
    $todo = Todo::find($_GET['id']);
    require_once 'views/todos/edit.php';
  }

  public function update()
  {
    $params = $_POST;
    $todo = new Todo();
    $todo->update($params, $params['id']);
    header("Location: /todos/".$params['id']."?id=".$params['id']);
  }

  public function destroy()
  {
    $todo = new Todo();
    $todo->destroy($_GET['id']);
    header("Location: /todos");
  }
}