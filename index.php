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
}
$routeList->searchRoute();

?>