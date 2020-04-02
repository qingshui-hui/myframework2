<?php
session_start();

require_once 'config.php';
require_once 'helper.php';
require_once "vendor/autoload.php";

use Libs\Routing\RouteList;
use Libs\Http\Session;



if (Session::get('flashCount', 0) > 0) {
  Session::push('flash', null);
}
// Put session_start(); before your DOCTYPE declaration
Session::incrementFlashCount();

$routeList = RouteList::getInstance();
if ($routeList->RouteIsEmpty()) {
  require_once 'routes/web.php';
}
$routeList->searchRoute();

?>