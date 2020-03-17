<?php

use Libs\Database\Migration;

class CreateBoardsTable extends Migration
{
  public function up()
  {
    $this->path = __FILE__;

    $query =
    'CREATE TABLE `boards` (
      `id` bigint(20) NOT NULL AUTO_INCREMENT,
      `title` varchar(255) NOT NULL,
      `position` int(11) DEFAULT NULL,
      `created_at` datetime DEFAULT NULL,
      `updated_at` datetime DEFAULT NULL,
      PRIMARY KEY (`id`)
    )';
    $this->createTable('boards', $query);
  }
}

$migration = new CreateBoardsTable();
$migration->up();
      
