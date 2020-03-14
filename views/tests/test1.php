<p>aaa</p>

<?php
use Libs\Database;

echo 'hello';

$db =Database::getInstance();
$todo = $db->query('SELECT * FROM todos where id = :id',  ['id' => 1]);
print_r($todo);

$result = $db->query("SHOW TABLES LIKE :table", ['table' => 'users']);
print_r($result);


// セッション管理開始
session_start();
 
if (!isset($_SESSION['count'])) {
    // キー'count'が登録されていなければ、1を設定
    $_SESSION['count'] = 1;
} else {
    //  キー'count'が登録されていれば、その値をインクリメント
    $_SESSION['count']++;
}
 
echo $_SESSION['count']."回目の訪問です。";
print_r(env('DSN')."\n");

$pattern = 'database/migrations/*.php';
// $pattern = $_SERVER['DOCUMENT_ROOT'] . '/database/migrations/*.php';
foreach ( glob( $pattern ) as $filename )
{
  echo $filename."\n";
}
?>