<?php

use Libs\Database\Migration;

class CreateCardsTable extends Migration
{
  public function up()
  {
    $this->path = __FILE__;

    $query = 
    'CREATE TABLE `cards` (
      `id` bigint(20) NOT NULL AUTO_INCREMENT,
      `title` varchar(100) NOT NULL,
      `content` text,
      `position` int(11) DEFAULT NULL,
      `board_id` int(11) NOT NULL,
      `created_at` datetime DEFAULT NULL,
      `updated_at` datetime DEFAULT NULL,
      PRIMARY KEY (`id`)
    );';
    $this->createTable('cards', $query);
  }
}

$migration = new CreateCardsTable();
$migration->up();
      
