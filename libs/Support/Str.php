<?php

namespace Libs\Support;

class Str
{
  public static function removeBrace($str)
  {
    $str = substr($str, 1);
    $str = substr($str, 0, strlen($str) - 1);
    return $str;
  }
}