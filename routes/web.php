<?php

use Libs\Routing\Route;
use Libs\Http\Request;
// Route::get('/todos/new', 'TodosController@new')->middleware('Authenticate');
Route::get('/todos/deleteOverdue', 'TodosController@deleteOverdue');
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

Route::get('/boards/{boardId}/cards/new', 'CardController@new');
Route::post('/boards/{boardId}/cards', 'CardController@create');
Route::get('/cards/{id}/destroy', 'CardController@destroy');

Route::get('/login', 'UserController@showLoginForm');
Route::post('/login', 'UserController@login');
Route::get('/logout', 'UserController@logout');
Route::get('/register', 'UserController@showRegisterForm');
Route::post('/register', 'UserController@register');


Route::get('/test1', 'TestController@test1');
Route::get('/test2/{id1}/{id2}', 'TestController@test2');
Route::get('/test-route', function() {
  require_once("views/tests/routeList.php");
});
Route::get('/testcallable/{id1}/{id2}', function(Request $request, $id1, $id2) {
  return view('tests/testcallable.php', 
          ['id1' => $id1, 'id2' => $id2, 'request' => $request]);
});
Route::post('/test4', function(Request $request) {
  return view('tests/test4.php', ['request' => $request]);
});
Route::get('/test-validation', 'TestController@showValidationForm');
Route::post('/test-validation', 'TestController@testValidation');
Route::get('/test-redirect', 'TestController@testRedirectForm');
Route::post('/test-redirect', 'TestController@testRedirect');
