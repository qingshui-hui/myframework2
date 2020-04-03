<?php

namespace Libs\Http;

class Session
{
  public static function start()
  {
    session_start();
    
    if (Session::get('flashCount', 0) > 0) {
      Session::put('flash', null);
    }
    Session::incrementFlashCount();
  }

  public static function get($name, $default = null)
  {
    // Session::get('contacts.name'); //$_SESSION['contacts']['name']の値が返る
    $keys = explode('.', $name);

    if (isset($_SESSION[$keys[0]])) {
      $tmpData = $_SESSION[array_shift($keys)];
      foreach($keys as $key) {
          if (isset($tmpData[$key])) {
              $tmpData = $tmpData[$key];
          } else {
              // 途中で存在しないキーがあった場合、defaultを返してループをぬける。
              return $default;
          };
      }
      return $tmpData;
    } else {
      return $default;
    }
  }

  public static function put($name, $val)
  {
    $keys = explode('.', $name);
    $keys = array_reverse($keys);
    // 後ろのキーから順に詰めていって、多階層の配列を作る
    $tmpData = $val;
    foreach ($keys as $key) {
        $last = $tmpData;
        $tmpData = [];
        $tmpData[$key] = $last;
    }
    $_SESSION = array_merge($_SESSION, $tmpData);
  }

  public static function useOnlyNext($key, $val)
  {
    $_SESSION['flashCount'] = 0;
    $_SESSION['flash'][$key] = $val;
  }

  public static function getFlash($key, $default = null)
  {
    if (isset($_SESSION['flash'])) {
      if (isset($_SESSION['flash'][$key])) {
        return $_SESSION['flash'][$key];
      }
    }
    return $default;
  }

  public static function incrementFlashCount()
  {
    if (isset($_SESSION['flashCount'])) {
      $_SESSION['flashCount'] += 1;
    }
  }

  public static function destroy()
  {
    session_destroy();
    $sessionIdName = "PHPSESSID";
    if (isset($_COOKIE[$sessionIdName])) {
      setcookie($sessionIdName, '', time() - 1800, '/');
    }
  }

  public static function generateCsrfToken()
  {
    $tokenByte = openssl_random_pseudo_bytes(16);
    $csrfToken = bin2hex($tokenByte);
    static::put('csrfToken', $csrfToken);
    return $csrfToken;
  }
}