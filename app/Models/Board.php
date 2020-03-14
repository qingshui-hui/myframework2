<?php

namespace App\Models;

class Board extends Model
{
  protected static $table = "boards";
  protected $primaryKey = ['id'];
  protected $properties = ['id', 'title', 'position', 'created_at', 'updated_at'];

  public function cards()
  {
    $query = "SELECT * FROM cards WHERE board_id = :id";
    $params = ['id' => $this->id];
    return Card::arrayToObjectList($this->db->query($query, $params));
  }
}