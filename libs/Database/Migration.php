<?php

namespace Libs\Database;

use Libs\Database;

abstract class Migration
{
  protected $db;
  protected $path;

  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  protected function tableExits($table)
  {
    // usersをバッククオートで囲むとヒットしない
    $tablesArray = $this->db->query("SHOW TABLES LIKE :table",
      ['table' => $table]);
    if (empty($tablesArray)) {
      return false;
    } else {
      return true;
    }
  }

  protected function createTable($table, $query)
  {
    if (!$this->tableExits($table)) {

      if ($this->db->execute($query)) {
        print("success: ".basename($this->path)."\n");
      } else {
        print("fail: ".basename($this->path)."\n");
      }

    } else {
      print('already exists: '.basename($this->path)."\n");
    }
  }
}