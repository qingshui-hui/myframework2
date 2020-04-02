<?php

namespace Libs\Http;

class Session
{
  public static function get($key, $default = null)
  {
    if (isset($_SESSION[$key])) {
      $val = $_SESSION[$key];
      return $val;
    } else {
      return $default;
    }
  }

  public static function push($key, $val)
  {
    $_SESSION[$key] = $val;
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

  public static function deleteOldRequest()
  {
    static::push('request', null);
  }

  public static function incrementFlashCount()
  {
    if (isset($_SESSION['flashCount'])) {
      $_SESSION['flashCount'] += 1;
    }
  }
}