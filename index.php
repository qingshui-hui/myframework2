<?php

require_once 'config.php';
require_once 'helper.php';
require_once "vendor/autoload.php";

use Libs\Routing\RouteList;
use Libs\Http\Session;

Session::start();

$routeList = RouteList::getInstance();
if ($routeList->RouteIsEmpty()) {
  require_once 'routes/web.php';
  require_once 'routes/api.php';
}
$routeList->searchRoute();

// ---- api のためのテスト  -----
$url = $_SERVER['PATH_INFO'];
if (preg_match('#application/json#', $_SERVER['HTTP_ACCEPT'])) {
  if ($url == '/testApi') {
    // $controller = new \App\Controllers\TestController();
    // $controller->testApi();
  }
}

?>