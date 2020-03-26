<?php

namespace App\Models;

use Libs\Database\Model;

class Card extends Model
{
  protected static $table = "cards";
  protected $primaryKey = ['id'];
  protected $properties = ['id', 'title', 'content', 'position', 'board_id','created_at', 'updated_at'];
}