<?php

namespace App;

class Route 
{
  public static function get($url, $controllerName, $method)
  {
    $request = $_SERVER['REQUEST_URI'];
    $requestMethod = $_SERVER["REQUEST_METHOD"];

    if ($request == $url) {
      if ($requestMethod == "GET") {
        $controllerName = 'App\\Controllers\\' . $controllerName;
        $controller = new $controllerName();
        $controller->$method();
      }
    }
  }

  public static function post($url, $controllerName, $method)
  {
    $request = $_SERVER['REQUEST_URI'];
    $requestMethod = $_SERVER["REQUEST_METHOD"];

    if ($request == $url) {
      if ($requestMethod == "POST") {
        $controllerName = 'App\\Controllers\\' . $controllerName;
        $controller = new $controllerName();
        $controller->$method();
      }
    }
  }

  public static function resource($name)
  {
    $request = $_SERVER['REQUEST_URI'];
    $list = preg_split('#/#', $request);
    $method = $_SERVER["REQUEST_METHOD"];

    if (preg_match('#'.$name.'#', $list[1]) == 1) {
      $controllerName = 'App\\Controllers\\'.ucfirst($name)."Controller";
      // require __DIR__ . '/controllers' . '/' . $controllerName . '.php';
      $controller = new $controllerName();

      if (count($list) == 2) {
        if ($method == "GET") {
          $controller->index();

        } else if ($method == "POST") {
          $controller->create();
        }

      } else if (count($list) == 3) {
        $id = $list[2];
        if ($id == "new") {
          $controller->new();

        } else if ($method == "GET") {
          $controller->show();

        } else if ($method == "POST") {
          $controller->update();
        }

      } else if (count($list) == 4) {
        $id = $list[2];
        $req = $list[3];
        if (preg_match("#^destroy#", $req) == 1) {
          $controller->destroy();

        } else if (preg_match("#^edit#", $req) == 1) {
          $controller->edit();
        }
      }
    }
  }
}