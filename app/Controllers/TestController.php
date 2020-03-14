<?php

namespace App\Controllers;

class TestController
{
  public function test1()
  {
    return view('tests/test1.php')->render();
  }
}