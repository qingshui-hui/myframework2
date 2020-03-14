<?php

namespace App\Controllers;

use App\Models\Board;

class BoardController
{
  public function index()
  {
    $boards = Board::all();
    require_once 'views/boards/index.php';
  }

  public function new()
  {
    require_once 'views/boards/new.php';
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