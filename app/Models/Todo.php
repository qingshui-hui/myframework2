<?php

namespace App\Models;

class Todo extends Model
{
  protected static $table = "todos";
  protected $primaryKey = ['id'];
  protected $properties = ['id', 'content', 'created_at', 'updated_at'];

  public function __construct()
  {
    parent::__construct();
  }
}