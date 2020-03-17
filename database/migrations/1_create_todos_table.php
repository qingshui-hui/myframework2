<?php

use Libs\Database\Migration;

class CreateTodosTable extends Migration
{
  public function up()
  {
    $this->path = __FILE__;

    $query = 
    'CREATE TABLE `todos` (
      `id` bigint(20) NOT NULL AUTO_INCREMENT,
      `content` varchar(255) DEFAULT NULL,
      `created_at` datetime DEFAULT NULL,
      `updated_at` datetime DEFAULT NULL,
      PRIMARY KEY (`id`)
    );';
    $this->createTable('todos', $query);
  }
}

$migration = new CreateTodosTable();
$migration->up();