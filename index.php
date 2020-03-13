<?php

require_once 'config.php';
require_once 'helper.php';
require_once "vendor/autoload.php";

use Libs\Routing\RouteList;

$routeList = RouteList::getInstance();
if ($routeList->RouteIsEmpty()) {
  require_once 'routes/web.php';
}
$routeList->searchRoute();
