<?php

namespace App;

class Route
{
  public static function get($url, $controllerName, $method)
  {
    static::passUrlParamsToController($url, "GET", $controllerName, $method);
  }

  public static function post($url, $controllerName, $method)
  {
    static::passUrlParamsToController($url, "POST", $controllerName, $method);
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

  // --- protected or private members ---

  protected static function includeCurlyBrace($str) :bool
  {
    if (preg_match("#^{.+}#", $str)) {
      // 括弧に囲まれている時のみヒットする
      return true;
    }
    else {
      return false;
    }
  }

  protected static function removeCurlyBrace($str) :string
  {
    $str = rtrim($str, '}');
    $str = ltrim($str, '{');
    return $str;
  }

  protected static function setUrlParams(Array $url, Array $request)
  {
    for ($i = 0; $i < count($url) ; $i++) {
      if (static::includeCurlyBrace($url[$i])) {
        $_REQUEST[static::removeCurlyBrace($url[$i])] = $request[$i];
      }
    }
    // print_r($_REQUEST);
  }

  protected static function checkUrl(Array $url, Array $request) :bool
  {
    if (count($url) !== count($request)) {
      // 数の確認を入れないと、"/boards", "/boards/new" を混同する。
      return false;
    }
    for ($i = 0; $i < count($url); $i++) {
      if (!static::includeCurlyBrace($url[$i])) {
        if ($url[$i] !== $request[$i]) {
          return false;
        }
      }
    }
    return true;
  }

  protected static function passUrlParamsToController($url, $_requestMethod,$controllerName, $method)
  {
    $request = $_SERVER['REQUEST_URI'];
    $requestMethod = $_SERVER["REQUEST_METHOD"];

    $urlArray = preg_split('#/#', $url);
    $requestArray = preg_split('#/#', $request);

    if (static::checkUrl($urlArray, $requestArray)) {
      if ($requestMethod == $_requestMethod) {
        static::setUrlParams($urlArray, $requestArray);
        $controllerName = 'App\\Controllers\\' . $controllerName;
        $controller = new $controllerName();
        $controller->$method();
      }
    }
  }
}