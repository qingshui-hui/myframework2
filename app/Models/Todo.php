<?php

namespace App\Models;

use Libs\Database\Model;

class Todo extends Model
{
  protected static $table = "todos";
  protected $primaryKey = ['id'];
  protected $properties = ['id', 'content', 'created_at', 'updated_at'];

  public function daysFromCreation()
  {
    $time_from = strtotime($this->created_at);
    $time_to = strtotime('now');

    $dif = $time_to - $time_from;
    $dif_time = date("H:i:s", $dif);
    $dif_days = (strtotime(date("Y-m-d", $dif))) / 86400;
    
    return "{$dif_days}日 {$dif_time}";
    // 表示結果の例 "131日 16:02:55"
  }
}