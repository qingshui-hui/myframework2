<?php

namespace App\Controllers;
use App\Models\Todo;
use App\Middleware\Authenticate;
use Libs\View;
use Libs\Http\Session;
use Libs\Http\Request;

class TodosController 
{
  private $view;

  public function __construct()
  {
    $view = new View();
    $isLogin = \App\Models\User::isLogin();
    // layout用のデータはここで追加する必要がある
    $this->view = $view->setLayout('layout/todo.php')->addData(['isLogin' => $isLogin]);
  }

  public function index() 
  {
    $todos = Todo::all();
    return $this->view->set('todos/index.php', ['todos' => $todos]);
  }

  public function new()
  {
    $csrfToken = Session::generateCsrfToken();
    return $this->view->set('todos/new.php', ['csrfToken' => $csrfToken]);
  }

  public function create(Request $request)
  {
    if ($_REQUEST['csrfToken'] !== Session::get('csrfToken')) {
      echo "不正なリクエストです";
    }
    $todo = new Todo();
    $params = $request->all();
    $todo->create($params);
    header("Location: /todos");
    exit();
  }

  public function show($id)
  {
    $todo = Todo::find($id);
    return $this->view->set('todos/show.php', ['todo' => $todo]);
  }

  public function edit($id)
  {
    $todo = Todo::find($id);
    return $this->view->set('todos/edit.php', ['todo' => $todo]);
  }

  public function update(Request $request, $id)
  {
    $params = $request->all();
    $todo = new Todo();
    $todo->update($params, $id);
    header("Location: /todos/".$id);
    exit();
  }

  public function destroy($id)
  {
    $todo = new Todo();
    $todo->destroy($id);
    header("Location: /todos");
    exit();
  }
}