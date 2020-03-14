<?php

use Libs\Routing\RouteList;

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function printRouteList()
{
    $routeList = RouteList::getInstance();
    $routeList->print();
}

function env($key, $default = null)
{
  if (isset($_ENV[$key])) {
    return $_ENV[$key];
  } else {
    return $default;
  }
}