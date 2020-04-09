<?php

use Libs\Routing\Route;
use Libs\Http\Request;
// Route::get('/todos/new', 'TodosController@new')->middleware('Authenticate');
Route::get('/todos/search', 'TodosController@search');
Route::get('/todos/deleteOverdue', 'TodosController@deleteOverdue');
Route::resource('todos', 'TodosController', [
  'only' => ['index', 'show', 'create', 'store', 'edit', 'update', 'destroy'],
  'middleware' => 'Authenticate'
]);
Route::get('/', 'TodosController@index')->middleware('Authenticate');

Route::resource('boards', 'BoardController', [
  'only' => ['index', 'create', 'store', 'show', 'destroy']
]);

Route::get('/boards/{boardId}/cards/create', 'CardController@create');
Route::post('/boards/{boardId}/cards', 'CardController@store');
Route::get('/cards/{id}/destroy', 'CardController@destroy');
Route::get('/cards', 'CardController@index');

Route::get('/login', 'UserController@showLoginForm');
Route::post('/login', 'UserController@login');
Route::get('/logout', 'UserController@logout');
Route::get('/register', 'UserController@showRegisterForm');
Route::post('/register', 'UserController@register');
Route::get('/users/show', 'UserController@show');


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
Route::get('/test5', function() {
  return view('tests/test5.php');
});
Route::get('/test6', function() {
  return view('tests/test6.php');
});
