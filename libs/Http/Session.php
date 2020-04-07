<?php

namespace Libs\Http;

use Libs\Support\ArrayUtil;

class Session
{
  public static function start()
  {
    session_start();
  }

  public static function get($name, $default = null)
  {
    return ArrayUtil::get_deep($_SESSION, $name, $default);
  }

  public static function put($name, $val)
  {
    $_SESSION = ArrayUtil::put_deep($_SESSION, $name, $val);
  }

  public static function forget($name)
  {
    ArrayUtil::unset_deep($_SESSION, $name);
  }

  public static function getAndForget($name, $default)
  {
    $return = self::get($name, $default);
    self::forget($name);
    return $return;
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
    self::put('csrfToken', $csrfToken);
    return $csrfToken;
  }
}