<?php

namespace App\Models;

use Libs\Database\Model;

class Board extends Model
{
  protected static $table = "boards";
  protected $primaryKey = ['id'];
  protected $properties = ['id', 'title', 'position', 'created_at', 'updated_at'];

  // positionの順に並べ替える
  public function cards()
  {
    $db = \Libs\Database\Database::getInstance();
    $query = "SELECT * FROM cards WHERE board_id = :id ORDER BY `position`";
    $params = ['id' => $this->id];
    return Card::arrayToObjectList($db->query($query, $params));
  }

  public function destroyWithCards($boardId) :bool
  {
    $db = \Libs\Database\Database::getInstance();
    $query = "START TRANSACTION;";
    $query .= "DELETE FROM `boards` WHERE `id` = :id;";
    $query .= "DELETE FROM `cards` WHERE `board_id` = :board_id;";
    $query .= "COMMIT;";
    return $db->execute($query, ['id' => $boardId, 'board_id' => $boardId]);
  }
}