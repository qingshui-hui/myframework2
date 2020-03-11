<?php

require_once 'config.php';
require_once 'helper.php';
require_once "vendor/autoload.php";
// このファイルにより、app/ , libs/ 以下のファイルをまとめて使える

use App\Route;

Route::resource('todos');
Route::get('/', 'TodosController', 'index');
Route::get('/login', 'UserController', 'showLoginForm');
Route::post('/login', 'UserController', 'login');
Route::get('/logout', 'UserController', 'logout');
Route::get('/register', 'UserController', 'showRegisterForm');
Route::post('/register', 'UserController', 'register');

Route::get('/tests', 'TestController', 'test1');
