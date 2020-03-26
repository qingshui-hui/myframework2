<?php

namespace App\Controllers;

use Libs\Http\Request;
use Libs\Http\Validator;
use Libs\Http\Errors;

class TestController
{
  public function test1()
  {
    return view('tests/test1.php')->render();
  }

  public function test2(Request $request, $id1, $id2)
  {
    return view('tests/test2.php', ['id1' => $id1, 'id2' => $id2, 'request' => $request])->render();
  }

  public function showValidationForm()
  {
    // $errors->get('email')は必ず配列を返すため、viewでforeachを使えばエラーが起きない。
    // 
    $errors = new Errors();
    $input = ['email' => ''];
    render('tests/test-validation.php', ['errors' => $errors, 'input' => $input]);
  }

  public function testValidation(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|unique:users',
      'nickname' => 'nullable|max:10',
      'title' => 'required'
    ]);
    if ($validator->fails()) {
      // print_r($validator->getInput());
      // print_r($validator->getErrors());
      render('tests/test-validation.php', ['errors' => $validator->getErrors(), 'input' => $validator->getInput()]);
    } else {
      print_r($validator->getValidated());
    }
  }
}