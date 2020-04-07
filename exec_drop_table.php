<?php

require_once 'config.php';
require_once 'helper.php';
require_once "vendor/autoload.php";

use Libs\Database\Database;

$db = Database::getInstance();
$db->execute("drop table todos");