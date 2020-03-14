<?php

use Libs\Routing\Route;
// Route::get('/todos/new', 'TodosController@new')->middleware('Authenticate');
Route::resource('todos', 'TodosController', [
  'only' => ['new', 'create', 'edit', 'update', 'destroy'],
  'middleware' => 'Authenticate'
]);
Route::resource('todos', 'TodosController', [
  'only' => ['index', 'show']
]);
Route::get('/', 'TodosController@index');

Route::resource('boards', 'BoardController', [
  'only' => ['index', 'new', 'create', 'show']
]);

Route::get('/boards/{board}/cards/new', 'CardController@new');
Route::post('/boards/{board}/cards', 'CardController@create');
Route::get('/cards/{id}/destroy', 'CardController@destroy');

Route::get('/login', 'UserController@showLoginForm');
Route::post('/login', 'UserController@login');
Route::get('/logout', 'UserController@logout');
Route::get('/register', 'UserController@showRegisterForm');
Route::post('/register', 'UserController@register');

Route::get('/test1', 'TestController@test1');
Route::get('/test2', function() {
  require_once("views/tests/routeList.php");
});