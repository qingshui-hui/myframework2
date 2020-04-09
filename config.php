<?php

ini_set('display_errors', 1);
// ini_set('session.cookie_lifetime', 1800);
// ブラウザを一度閉じても30分ログインしたままになる設定
// ini_set('session.cookie_httponly', 1);
date_default_timezone_set('Asia/Tokyo');

define('ENV', [
    'DSN' => 'mysql:host=db;dbname=dev_db;charset=utf8mb4',
    'DB_USER' => 'appuser',
    'DB_PASS' => "KabK#t)rWiiwE2J-Ai&Ev*a~4J!Qcz*%"
]);
