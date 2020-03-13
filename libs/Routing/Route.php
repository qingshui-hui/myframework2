<?php

namespace Libs\Routing;
use Libs\Routing\RouteList;

class Route
{
  private $url;
  private $requestMethod;
  private $controllerName;
  private $controllerMethod;

  public static function get($url, $controllerName, $method = null)
  {
    static::register($url, "GET", $controllerName, $method);
  }

  public static function post($url, $controllerName, $method)
  {
    static::register($url, "POST", $controllerName, $method);
  }

  public static function resource($name, $controllerName, $option = null)
  {
    if (isset($option['only'])) {
      $only = $option['only'];
    } else {
      $only = ["index", "new", "create", "show", "edit", "update", "destroy"];
    }
    if (in_array("index", $only))
      static::get("/{$name}", $controllerName, "index");
    if (in_array("new", $only))
      static::get("/{$name}/new", $controllerName, "new");
    if (in_array("create", $only))
      static::post("/{$name}", $controllerName, "create");

    if (in_array("show", $only))
      static::get("/{$name}/{id}", $controllerName, "show");
    if (in_array("edit", $only))
      static::get("/{$name}/{id}/edit", $controllerName, "edit");
    if (in_array("update", $only))
      static::post("/{$name}/{id}", $controllerName, "update");
    if (in_array("destroy", $only))
      static::get("/{$name}/{id}/destroy", $controllerName, "destroy");
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
    $urlArray = preg_split('#/#', $this->url);
    $requestArray = preg_split('#/#', $request);


    $this->setUrlParams($urlArray, $requestArray);
    $controllerName = $this->controllerName;
    $controllerMethod = $this->controllerMethod;
    if (is_callable($controllerName)) {
      $controllerName();
      return;
    }
    $controllerName = 'App\\Controllers\\'.$controllerName;
    $controller = new $controllerName();
    $controller->$controllerMethod();
  }

  public function toString() {
    if (is_string($this->controllerName)) {
      $action = $this->controllerName."@".$this->controllerMethod;
    } else {
      $action = "closure";
    }
    return "
    <tr>
      <td>".$this->requestMethod."</td>
      <td>".$this->url."</td>
      <td>".$action."</td>
    </tr>";
  }

  // --- protected or private members ---

  private static function register($url, $requestMethod, $controllerName, $method)
  {
    $routeList = RouteList::getInstance();
    $instance = new Route();
    $instance->url = $url;
    $instance->requestMethod = $requestMethod;
    $instance->controllerName = $controllerName;
    $instance->controllerMethod = $method;
    $routeList->addRoute($instance);
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