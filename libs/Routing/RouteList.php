<?php

namespace Libs\Routing;

class RouteList
{
  private static $instance = null;
  private $routes = [];
  //Singleton
  public static function getInstance() :RouteList
  {
      if (is_null(self::$instance)) {
          self::$instance = new self();
      }
      return self::$instance;
  }

  public function addRoute(Route $route)
  {
    array_push($this->routes, $route);
  }

  public function getRouteList()
  {
    return $this->routes;
  }

  public function RouteIsEmpty() :bool
  {
    if (empty($this->getRouteList())) {
      return true;
    } else {
      return false;
    }
  }

  public function searchRoute() {
    foreach ($this->routes as $route) {
      if ($route->checkUrl()) {
        $route->executeRequest();
        break;
      }
    }
  }

  public function print() {
    echo "<table>";
    foreach ($this->routes as $route) {
      echo $route->toString();
    }
    echo "</table>";
  }
}