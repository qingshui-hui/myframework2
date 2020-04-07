<?php

namespace App\Requests;

use Libs\Http\Request;
use Libs\Http\Validator;

class TestRedirectRequest
{
    public $validator;
    public $request;
    public $errors;

    public function __construct()
    {
        $this->request = new Request();
        $this->validator = Validator::make($this->request->all(), $this->rules());
        $this->errors = $this->validator->getErrors();
        $this->changeErrorMessage();
    }

    // ---private---
    private function rules()
    {
        return [
            'email' => 'required|unique:users',
            'nickname' => 'nullable|min:4|max:10',
            'title' => 'required'
        ];
    }
    private function changeErrorMessage()
    {
        // $this->errors->changeMessage('email.required', "please put email");
        // $this->errors->changeMessage('title.required', "please put title");
    }
}