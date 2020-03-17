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
  if (isset($_ENV[$key])) {
    return $_ENV[$key];
  } else {
    return $default;
  }
}

function view($content, Array $data = [])
{
  $view = new View();
  $view->setContent($content);
  $view->setData($data);
  return $view;
}

function render($content, Array $data = [])
{
  // view() のショートカット
  $view = new View();
  $view->render($content, $data);
}