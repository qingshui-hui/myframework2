<?php

require_once 'config.php';
require_once 'helper.php';
require_once "vendor/autoload.php";

$migrations = 'database/migrations/*.php';
foreach (glob($migrations) as $m) {
  require_once $m;
}