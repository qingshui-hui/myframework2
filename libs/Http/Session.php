<?php

namespace Libs\Http;

class Session
{
  public function __construct()
  {
    // $this->session = $_SESSION;
  }

  public static function get($key, $else = null)
  {
    session_start();
    if (isset($_SESSION[$key])) {
      $val = $_SESSION[$key];
      session_write_close();
      return $val;
    } else {
      session_write_close();
      return $else;
    }
  }

  public static function push($key, $val)
  {
    session_start();
    $_SESSION[$key] = $val;
    session_write_close();
  }

  public static function useOnlyNext($key, $val)
  {
    session_start();
    $_SESSION['flashCount'] = 0;
    $_SESSION['flash'][$key] = $val;
    session_write_close();
  }

  public static function getFlashErrors()
  {
    return static::getFlash('errors', new Errors());
  }

  public static function getFlashRequest()
  {
    return static::getFlash('request', new Request());
  }

  public static function getFlash($key, $else = null)
  {
    session_start();
    if (isset($_SESSION['flash'])) {
      if (isset($_SESSION['flash'][$key])) {
        session_write_close();
        return $_SESSION['flash'][$key];
      }
    }
    session_write_close();
    return $else;
  }

  public static function deleteOldRequest()
  {
    static::push('request', null);
  }

  public static function incrementFlashCount()
  {
    session_start();
    if (isset($_SESSION['flashCount'])) {
      $_SESSION['flashCount'] += 1;
    }
    session_write_close();
  }
}