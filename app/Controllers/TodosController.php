<?php

namespace App\Controllers;
use App\Models\Todo;
use App\Models\User;
use App\Middleware\Authenticate;
use App\Requests\TodosCreateRequest;
use App\Requests\TodosSearchRequest;
use Libs\View;
use Libs\Http\Session;
use Libs\Http\Request;
use Libs\Http\Errors;
use Libs\Http\Validator;
// メソッドの第一引数にRequestクラスを入れるとroutingのメソッド呼び出し時に注入してくれる

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

  public function search()
  {
    $customRequest = new TodosSearchRequest();
    $todos = $customRequest->getTodos();
    $users = User::all();
    $request = new Request();
    return $this->view->set('todos/search.php', ['todos' => $todos, 'users' => $users, 'request' => $request]);
  }

  public function index() 
  {
    $todos = Todo::allWithUsers();
    $users = User::all();
    return $this->view->set('todos/index.php', ['todos' => $todos, 'users' => $users]);
  }

  public function create()
  {
    $users = \App\Models\User::all();
    $csrfToken = Session::generateCsrfToken();
    $errors = Session::getAndForget('errors', new Errors());
    $request = Session::getAndForget('request', new Request);
    return $this->view->set('todos/create.php', ['csrfToken' => $csrfToken, 'users' => $users, 'errors' => $errors, 'request' => $request]);
  }

  public function store(Request $request)
  {
    // if ($_REQUEST['csrfToken'] !== Session::get('csrfToken')) {
    //   echo "不正なリクエストです";
    //   exit();
    // }
    $customRequest = new TodosCreateRequest();
    if ($customRequest->validator->fails()) {
      Session::put('errors', $customRequest->errors);
      Session::put('request', $customRequest->request);
      header("Location: /todos/create");
      exit();
    } else {
      $params = $customRequest->modifiedRequest;
      (new Todo)->create($params);
      header("Location: /todos");
      exit();
    }
  }

  public function show($id)
  {
    $todo = Todo::find($id);
    return $this->view->set('todos/show.php', ['todo' => $todo]);
  }

  public function edit($id)
  {
    $todo = Todo::find($id);
    $users = User::all();
    $csrfToken = Session::generateCsrfToken();
    $errors = Session::getAndForget('errors', new Errors());
    $request = Session::getAndForget('request', $todo->convertToRequest());
    return $this->view->set('todos/edit.php', ['todo' => $todo, 'users' => $users, 'csrfToken' => $csrfToken, 'errors' => $errors, 'request' => $request]);
  }

  public function update(Request $request, $id)
  {
    // if ($_REQUEST['csrfToken'] !== Session::get('csrfToken')) {
    //   echo "不正なリクエストです";
    //   exit();
    // }
    $customRequest = new TodosCreateRequest();
    if ($customRequest->validator->fails()) {
      Session::put('errors', $customRequest->errors);
      Session::put('request', $customRequest->request);
      header("Location: /todos/{$id}/edit");
      exit();
    } else {
      $params = $customRequest->modifiedRequest;
      (new Todo)->update($params, $id);
      header("Location: /todos/".$id);
      exit();
    }
  }

  public function destroy($id)
  {
    (new Todo)->destroy($id);
    header("Location: /todos");
    exit();
  }

  public function deleteOverdue()
  {
    $todos = Todo::all();
    foreach ($todos as $todo) {
      if ($todo->dead()) {
        $todo->destroy();
      }
    }
    echo "<a href='/'>todo list</a>";
    echo "削除しました";
  }
}
