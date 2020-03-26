
<?php

use Libs\Database\Database;

echo 'hello';
$db =Database::getInstance();
$todo = $db->query('SELECT * FROM todos where id = :id',  ['id' => 1]);
print_r($todo);

$result = $db->query("SHOW TABLES LIKE :table", ['table' => 'users']);
print_r($result);


// セッション管理開始
 
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
$users = [
  [1, 'kusuda'],
  [2, 'honda'],
  [3, 'yamane'],
  [4, 'takanashi']
]
?>

<p>aaa</p>
<p><a href="/test2/3/2">/test2/3/2</a></p>
<p><a href="/testcallable/8/14">/testcallable</a></p>
<p><a href="/test-validation">/test-validation</a></p>
<p><a href="/test-redirect">/test-redirect</a></p>
<p><a href="/test-route">/routeList</a></p>

<form action="/test4" method="POST" enctype="multipart/form-data">
  <div>名前
    <input type="text" name="name" value="yamada">
  </div>
  <div>タグ
    <input type="text" name="tag" value="hito">
  </div>
  <div>内容
    <input type="text" name="content" value="yoroshiku">
  </div>
  <div>
    <input type="file" name="image">
  </div>
  <?php foreach($users as $user): ?>
    <input type="checkbox" name="userIds[]" id="" value="<?= $user[0] ?>">
    <span><?= $user[1] ?></span>
  <?php endforeach; ?>
  <input type="submit" value="送信">
</form>