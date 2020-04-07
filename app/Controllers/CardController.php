<?php

namespace App\Controllers;

use App\Models\Card;
use App\Models\Board;
use Libs\Http\Request;

class CardController
{
  public function new($boardId)
  {
    $board = Board::find($boardId);
    return view('cards/new.php', ['board' => $board]);
  }

  public function create(Request $request)
  {
    $params = $request->all();
    $params['board_id'] = $request->get('boardId');
    $card = new Card();
    $card->create($params);
    header("Location: /boards");
    exit();
  }

  public function destroy($id)
  {
    $card = new Card();
    $card->destroy($id);
    header("Location: /boards");
    exit();
  }
}
