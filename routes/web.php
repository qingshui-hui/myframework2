<?php

use Libs\Routing\Route;

Route::resource('todos', 'TodosController');
Route::get('/', 'TodosController', 'index');

Route::get('/boards', 'BoardController', 'index');
Route::get('/boards/new', 'BoardController', 'new');
Route::post('/boards', 'BoardController', 'create');
Route::get('/boards/{id}', 'BoardController', 'show');

Route::get('/boards/{board}/cards/new', 'CardController', 'new');
Route::post('/boards/{board}/cards', 'CardController', 'create');
Route::get('/cards/{id}/destroy', 'CardController', 'destroy');

Route::get('/login', 'UserController', 'showLoginForm');
Route::post('/login', 'UserController', 'login');
Route::get('/logout', 'UserController', 'logout');
Route::get('/register', 'UserController', 'showRegisterForm');
Route::post('/register', 'UserController', 'register');

Route::get('/tests', 'TestController', 'test1');
Route::get('/test2', function() {
  require_once("views/tests/routeList.php");
});