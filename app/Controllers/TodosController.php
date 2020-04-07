<?php

namespace App\Controllers;
use App\Models\Todo;
use App\Middleware\Authenticate;
use Libs\View;
use Libs\Http\Session;
use Libs\Http\Request;
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

  public function index() 
  {
    $todos = Todo::all();
    return $this->view->set('todos/index.php', ['todos' => $todos]);
  }

  public function new()
  {
    $users = \App\Models\User::all();
    $csrfToken = Session::generateCsrfToken();
    return $this->view->set('todos/new.php', ['csrfToken' => $csrfToken, 'users' => $users]);
  }

  public function create(Request $request)
  {
    if ($_REQUEST['csrfToken'] !== Session::get('csrfToken')) {
      echo "不正なリクエストです";
      exit();
    }
    $validator = Validator::make($request->all(), ['content' => 'required', 'user_id' => 'required', 'date' => 'required']);
    if ($validator->fails()) {
      header("Location: /todos/new");
      exit();
    }
    $todo = new Todo();
    $params = $request->all();
    $deadline = $request->get('date').' '.$request->get('hour').':'.$request->get('minute');
    $params['deadline'] = $deadline;
    // print_r($params);
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
    $users = \App\Models\User::all();
    $csrfToken = Session::generateCsrfToken();
    return $this->view->set('todos/edit.php', ['todo' => $todo, 'users' => $users, 'csrfToken' => $csrfToken]);
  }

  public function update(Request $request, $id)
  {
    if ($_REQUEST['csrfToken'] !== Session::get('csrfToken')) {
      echo "不正なリクエストです";
      exit();
    }
    $validator = Validator::make($request->all(), ['content' => 'required', 'user_id' => 'required', 'date' => 'required']);
    if ($validator->fails()) {
      header("Location: /todos/{$id}/edit");
      exit();
    }
    $params = $request->all();
    $deadline = $request->get('date').' '.$request->get('hour').':'.$request->get('minute');
    $params['deadline'] = $deadline;

    $todo = Todo::find($id);
    $todo->update($params, $id);
    header("Location: /todos/".$id);
    exit();
  }

  public function destroy($id)
  {
    $todo = Todo::find($id);
    $todo->destroy();
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
