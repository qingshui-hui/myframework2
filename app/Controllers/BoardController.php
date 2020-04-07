<?php

namespace App\Controllers;

use App\Models\Board;
use Libs\Http\Request;

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

  public function create(Request $request)
  {
    $board = new Board;
    $board->create($request->all());
    header("Location: /boards");
    exit();
  }

  public function show($id)
  {
    echo $id;
    print_r(Board::find($id)->cards());
  }
}