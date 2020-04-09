<?php

namespace App\Controllers;

use App\Models\Board;
use App\Models\Card;
use Libs\Http\Request;

class BoardController
{
  public function index()
  {
    $boards = Board::all();
    return view('boards/index.php', ['boards' => $boards]);
  }

  public function create()
  {
    return view('boards/create.php');
  }

  public function store(Request $request)
  {
    $board = new Board;
    $board->create($request->all());
    header("Location: /boards");
    exit();
  }

  public function show($id)
  {
    $board = Board::find($id);
    return view('boards/show.php', ['board' => $board]);
  }

  public function destroy($id)
  {
    $success = (new Board)->destroyWithCards($id);
    if ($success) {
      header("Location: /boards");
      exit();
    } else {
      
    }
  }

  // json形式でリクエストがとんでくる。
  public function registerPosition(Request $request)
  {
    $card = new Card();
    $positions = $request->get('positions');
    $boardId = $request->get('boardId');

    foreach ($positions as $p) {
      // $p は　[card_id, position]
      $card->update(['position' => $p[1]], $p[0]);
    }

  }
}