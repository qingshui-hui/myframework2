<?php

namespace App\Controllers;

use App\Models\Board;

class BoardController
{
  public function index()
  {
    $boards = Board::all();
    return render('boards/index.php', ['boards' => $boards]);
  }

  public function new()
  {
    return view('boards/new.php')->render();
  }

  public function create()
  {
    $board = new Board;
    $board->create($_REQUEST);
    header("Location: /boards");
  }

  public function show()
  {
    echo $_REQUEST['id'];
    print_r(Board::find($_REQUEST['id'])->cards());
  }
}