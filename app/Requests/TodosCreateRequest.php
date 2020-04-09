<?php

namespace App\Requests;

use Libs\Http\Validator;
use Libs\Http\Request;

class TodosCreateRequest
{
  public $validator;
  public $request;
  public $modifiedRequest = [];
  public $errors;

  public function __construct()
  {
    $this->setProperties();
    if ($this->validator->fails()) {
      $this->changeErrorMessage();
    } else {
      $this->modifyRequest();
    }
  }

  // ---private---
  private function setProperties()
  {
    $this->request = new Request();
    $this->validator = Validator::make($this->request->all(), $this->rules());
    $this->errors = $this->validator->getErrors();
  }

  private function rules()
  {
    return [
      'content' => 'required',
      'user_id' => 'required',
      'date' => 'required',
      'hour' => 'required',
      'minute' => 'required'
    ];
  }

  private function modifyRequest()
  {
    // validationに通ったときだけ、実行する。
    $request = $this->request->all();
    $deadline = $request['date'].' '.$request['hour'].':'.$request['minute'];
    $this->modifiedRequest['content'] = $request['content'];
    $this->modifiedRequest['user_id'] = $request['user_id'];
    $this->modifiedRequest['deadline'] = $deadline;
  }

  private function changeErrorMessage()
  {
    $this->errors->changeMessage('content.required', '内容を入力してください');
    $this->errors->changeMessage('user_id.required', "担当者を選択してください");
    $this->errors->changeMessage('date.required', "日付が入力されていません");
  }
}