<?php

namespace App\Controllers;

use App\Models\Card;
use App\Models\Board;
use Libs\Http\Request;

class CardController
{
  public function index()
  {
    $cards = Card::all();
    return view('cards/index.php', ['cards' => $cards]);
  }

  public function create($boardId)
  {
    $board = Board::find($boardId);
    return view('cards/create.php', ['board' => $board]);
  }

  public function store(Request $request)
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
