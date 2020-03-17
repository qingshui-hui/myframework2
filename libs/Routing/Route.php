<?php

namespace Libs\Routing;
use Libs\Routing\RouteList;

class Route
// middlewareについてはdefault()メソッドを呼ぶ executeRequest()を参照
{
  private $url;
  private $requestMethod;
  private $controllerName;
  private $controllerMethod;
  private $middleware;

  public static function get($url, $action, $middleware = null)
  {
    return static::register($url, "GET", $action, $middleware);
  }

  public static function post($url, $action, $middleware = null)
  {
    return static::register($url, "POST", $action, $middleware);
  }

  public static function resource($name, $controllerName, $option = null)
  {
    if (isset($option['only'])) {
      $only = $option['only'];
    } else {
      $only = ["index", "new", "create", "show", "edit", "update", "destroy"];
    }
    if (!isset($option['middleware'])) {
      $middleware = null;
    } else {
      $middleware = $option['middleware'];
    }
    if (in_array("index", $only))
      static::get("/{$name}", $controllerName."@index", $middleware);
    if (in_array("new", $only))
      static::get("/{$name}/new", $controllerName."@new", $middleware);
    if (in_array("create", $only))
      static::post("/{$name}", $controllerName."@create", $middleware);

    if (in_array("show", $only))
      static::get("/{$name}/{id}", $controllerName."@show", $middleware);
    if (in_array("edit", $only))
      static::get("/{$name}/{id}/edit", $controllerName."@edit", $middleware);
    if (in_array("update", $only))
      static::post("/{$name}/{id}", $controllerName."@update", $middleware);
    if (in_array("destroy", $only))
      static::get("/{$name}/{id}/destroy", $controllerName."@destroy", $middleware);
  }

  public function middleware($name)
  {
    // registerの後に呼ばれるが、上書きできていた
    $this->middleware = $name;
  }

  public function checkUrl() :bool
  {
    $requestMethod = $_SERVER["REQUEST_METHOD"];
    if ($requestMethod != $this->requestMethod) {
      return false;
    }

    $request = preg_replace('/\?.+$/', "", $_SERVER['REQUEST_URI']);
    $urlArray = preg_split('#/#', $this->url);
    $requestArray = preg_split('#/#', $request);
    if (count($urlArray) !== count($requestArray)) {
      // 数の確認を入れないと、"/boards", "/boards/new" を混同する。
      return false;
    }
    for ($i = 0; $i < count($urlArray); $i++) {
      if (static::includeCurlyBrace($urlArray[$i])) {
        // if (!is_numeric($requestArray[$i])) {
        //   // /boards/new と /boards/{board} が混同することへの対策
        //   return false;
        // }
      } else {
        if ($urlArray[$i] !== $requestArray[$i]) {
          return false;
        }
      }
    }
    return true;
  }

  public function executeRequest()
  {
    $request = preg_replace('/\?.+$/', "", $_SERVER['REQUEST_URI']);
    if (!empty($this->middleware)) {
      $middlewareName = 'App\\Middleware\\'.$this->middleware;
      $middleware = new $middlewareName();
      if (!$middleware->default()) {
        return;
      }
    }

    $urlArray = preg_split('#/#', $this->url);
    $requestArray = preg_split('#/#', $request);
    $this->setUrlParams($urlArray, $requestArray);

    if (is_callable($this->action)) {
      $action = $this->action;
      $action();
      return;
    }
    $splittedAction = preg_split('/@/', $this->action);
    $controllerMethod = $splittedAction[1];
    $controllerName = 'App\\Controllers\\'.$splittedAction[0];
    $controller = new $controllerName();
    $controller->$controllerMethod();
  }

  public function toString() {
    if (is_string($this->action)) {
      $action = $this->action;
    } else {
      $action = "closure";
    }
    return "
    <tr>
      <td>".$this->requestMethod."</td>
      <td>".$this->url."</td>
      <td>".$action."</td>
      <td>".$this->middleware."</td>
    </tr>";
  }

  // --- protected or private members ---

  private static function register($url, $requestMethod, $action, $middleware = null)
  {
    $routeList = RouteList::getInstance();
    $instance = new Route();
    $instance->url = $url;
    $instance->requestMethod = $requestMethod;
    $instance->action = $action;
    $instance->middleware = $middleware;
    $routeList->addRoute($instance);
    return $instance;
  }

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

  protected function setUrlParams(Array $url, Array $request)
  {
    for ($i = 0; $i < count($url) ; $i++) {
      if (static::includeCurlyBrace($url[$i])) {
        $_REQUEST[static::removeCurlyBrace($url[$i])] = $request[$i];
      }
    }
    // print_r($_REQUEST);
  }
}