<?php
// 03/26 コントローラーのメソッドないでviewをレンダリングするのではなく、メソッドの返り値として渡された、viewのインスタンスに対して、route内でrender()を行うように変更した。

namespace Libs\Routing;
use Libs\Routing\RouteList;
use Libs\Http\Request;

// middlewareについてはdefault()メソッドを呼ぶ executeRequest()を参照
class Route
{
  private $url;
  private $requestMethod;
  private $controllerName;
  private $controllerMethod;
  private $middleware;

  // routeアクションの実行時に決まる変数
  private $requestUrl = null;
  private $urlParams = [];

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
      $only = ["index", "create", "store", "show", "edit", "update", "destroy"];
    }
    if (!isset($option['middleware'])) {
      $middleware = null;
    } else {
      $middleware = $option['middleware'];
    }
    if (in_array("index", $only))
      static::get("/{$name}", $controllerName."@index", $middleware);
    if (in_array("create", $only))
      static::get("/{$name}/create", $controllerName."@create", $middleware);
    if (in_array("store", $only))
      static::post("/{$name}", $controllerName."@store", $middleware);

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
    if ($this->passMiddleware()) {
      $this->setUrlParams();
      $return = $this->executeAction();
      if (is_object($return)) {
        // 関数の返り値が空だと、Warning, nullだと何もなし;
        if (get_class($return) === "Libs\View") {
          // これにはオブジェクトを渡さなければならない
          $return->render();
        }
      };
    }
    return;
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

  private function passMiddleware() :bool
  {
    if (isset($this->middleware) && $this->middleware !== "") {
      $middlewareName = 'App\\Middleware\\'.$this->middleware;
      $middleware = new $middlewareName();
      if (!$middleware->default()) {
        // ミドルウェアを通過できなければ、
        return false;
      }
    }
    return true;
  }

  protected function setUrlParams()
  {
    $this->requestUrl = preg_replace('/\?.+$/', "", $_SERVER['REQUEST_URI']);
    $url = preg_split('#/#', $this->url);
    $request = preg_split('#/#', $this->requestUrl);
    $urlParams = [];
    for ($i = 0; $i < count($url) ; $i++) {
      if (static::includeCurlyBrace($url[$i])) {
        $_REQUEST[static::removeCurlyBrace($url[$i])] = $request[$i];
        $urlParams[static::removeCurlyBrace($url[$i])] = $request[$i];
      }
    }
    $this->urlParams = $urlParams;
  }

  private function executeAction()
  {
    // 返り値はViewのインスタンスにしたい。
    if (is_callable($this->action)) {
      $action = $this->action;
      $function = new \ReflectionFunction($this->action);
      if (count($function->getParameters()) < 1) {
        return $function->invoke();
      } else {
        $preparedParams = $this->prepareMethodParams($function->getParameters());
        return $function->invokeArgs($preparedParams);
      }
    }

    $splittedAction = preg_split('/@/', $this->action);
    $controllerMethod = $splittedAction[1];
    $controllerName = 'App\\Controllers\\'.$splittedAction[0];

    $controller = new $controllerName();
    $method = new \ReflectionMethod($controllerName, $controllerMethod);
    if (count($method->getParameters()) < 1) {
      return $method->invoke($controller);
    } else {
      $preparedParams = $this->prepareMethodParams($method->getParameters());
      return $method->invokeArgs($controller, $preparedParams);
    }
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

  protected function getUrlParams(Array $url, Array $request)
  {
    $urlParams = [];
    for ($i = 0; $i < count($url) ; $i++) {
      if (static::includeCurlyBrace($url[$i])) {
        $urlParams[static::removeCurlyBrace($url[$i])] = $request[$i];
      }
    }
    return $urlParams;
  }

  protected function prepareMethodParams(Array $reflParams)
  {
    $urlParams = $this->urlParams;
    $preparingParams = [];

    if ($reflParams[0]->hasType() && $reflParams[0]->getType()->getName() === 'Libs\Http\Request') {
      $preparingParams[0] = new Request();
    }
    foreach ($reflParams as $index => $reflParam) {
      if (isset($urlParams[$reflParam->getName()])) {
        $preparingParams[$index] = $urlParams[$reflParam->getName()];
      }
    }
    return $preparingParams;
  }
}