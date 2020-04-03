<?php

namespace App\Controllers;

use App\Models\Board;

class BoardController
{
  public function index()
  {
    $boards = Board::all();
    return view('boards/index.php', ['boards' => $boards]);
  }

  public function new()
  {
    return view('boards/new.php');
  }

  public function create()
  {
    $board = new Board;
    $board->create($_REQUEST);
    header("Location: /boards");
    exit();
  }

  public function show()
  {
    echo $_REQUEST['id'];
    print_r(Board::find($_REQUEST['id'])->cards());
  }
}