<?php

namespace App\Controllers;

use Libs\Http\Request;
use Libs\Http\Validator;
use Libs\Http\Session;
use Libs\Http\Errors;

class TestController
{
  public function test1()
  {
    return view('tests/test1.php');
  }

  public function test2(Request $request, $id1, $id2)
  {
    return view('tests/test2.php',
              ['id1' => $id1, 'id2' => $id2, 'request' => $request]);
  }

  public function showValidationForm()
  {
    $errors = new Errors();
    $request = new Request();
    return view('tests/test-validation.php',
              ['errors' => $errors, 'input' => $request]);
  }

  public function testValidation(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|unique:users',
      'nickname' => 'nullable|min:4|max:10',
      'title' => 'required'
    ]);
    if ($validator->fails()) {
      $request->session()->push('request',$request);
      return view('tests/test-validation.php', [
                'errors' => $validator->getErrors(),
                'input' => $request
                ]);
    } else {
      print_r($validator->getValidated());
      echo "<p><a href='/test1'>back</a></p>";
    }
  }

  public function testRedirectForm()
  {
    // エラーを表示したいフォーム側で次の二つを設定。
    $errors = Session::getAndForget('errors', new Errors());
    $request = Session::getAndForget('request', new Request());
    return view('tests/test-redirect.php', 
          ['errors' => $errors, 'request' => $request]);
  }

  public function testRedirect()
  {
    // RequestとValidatorを一つにまとめたようなクラス
    $customRequest = new \App\Requests\TestRedirectRequest();
    $validator = $customRequest->validator;
    if ($validator->fails()) {
      // 一時的に保存して、リダイレクト先に渡す。
      Session::put('request',$customRequest->request);
      Session::put('errors', $customRequest->errors);
      header("Location: /test-redirect");
      exit();
    } else {
      print_r($validator->getValidated());
      echo "<p><a href='/test1'>back</a></p>";
    }
  }

  public function testApi()
  {
    // jquery ajax のpost
    // $_REQUEST で、javascripから送られたデータを受け取れる。
    $name = "aaa";
    $response = json_encode($_REQUEST);
    header("Content-Type: application/json; charset=utf-8");
    echo $response;
    exit();
  }
}