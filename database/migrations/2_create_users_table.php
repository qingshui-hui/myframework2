<?php
use Libs\Database\Migration;

class CreateUsersTable extends Migration
{
  public function up()
  {
    $this->path = __FILE__;

    $query = 
    'CREATE TABLE `users` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
      `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
      `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `users_email_unique` (`email`)
    )';
    $this->createTable('users', $query);
  }
}

$migration = new CreateUsersTable();
$migration->up();