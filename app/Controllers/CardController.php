<?php

namespace App\Controllers;

use App\Models\Card;
use App\Models\Board;

class CardController
{
  public function new()
  {
    $board = Board::find($_REQUEST['board']);
    return view('cards/new.php', ['board' => $board])->render();
  }

  public function create()
  {
    $params = $_REQUEST;
    $params['board_id'] = $_REQUEST['board'];
    $card = new Card();
    $card->create($params);
    header("Location: /boards");
  }

  public function destroy()
  {
    $id = $_REQUEST['id'];
    $card = new Card();
    $card->destroy($id);
    header("Location: /boards");
  }
}
