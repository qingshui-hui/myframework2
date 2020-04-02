<?php

namespace App\Controllers;
use App\Models\Todo;
use App\Middleware\Authenticate;
use Libs\View;

class TodosController 
{
  private $view;

  public function __construct()
  {
    $view = new View();
    $isLogin = \App\Models\User::isLogin();
    $this->view = $view->setLayout('layout/todo.php')->addData(['isLogin' => $isLogin]);
  }

  public function index() 
  {
    $todos = Todo::all();
    return $this->view->set('todos/index.php', ['todos' => $todos]);
  }

  public function new()
  {
    return $this->view->set('todos/new.php');
  }

  public function create()
  {
    $todo = new Todo();
    $params = $_REQUEST;
    $todo->create($params);
    header("Location: /todos");
  }

  public function show()
  {
    $todo = Todo::find($_REQUEST['id']);
    return $this->view->set('todos/show.php', ['todo' => $todo]);
  }

  public function edit()
  {
    $todo = Todo::find($_REQUEST['id']);
    return $this->view->set('todos/edit.php', ['todo' => $todo]);
  }

  public function update()
  {
    $params = $_REQUEST;
    $todo = new Todo();
    $todo->update($params, $params['id']);
    header("Location: /todos/".$params['id']);
  }

  public function destroy()
  {
    $todo = new Todo();
    $todo->destroy($_REQUEST['id']);
    header("Location: /todos");
  }
}