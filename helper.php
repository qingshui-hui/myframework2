<?php

use Libs\Routing\RouteList;
use Libs\View;

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
  if (isset(ENV[$key])) {
    return ENV[$key];
  } else {
    return $default;
  }
}

function view($content, Array $data = null, $layout = null)
{
  $view = new View();
  $view->set($content, $data, $layout);
  return $view;
}

function redirect($path)
{
  header("Location: {$path}");
}