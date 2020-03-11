<p>aaa</p>

<?php
use Libraries\Database;

echo 'hello';

$db =Database::getInstance();
$todo = $db->query('SELECT * FROM todos where id = :id',  ['id' => 1]);
print_r($todo);

$db2 =  Database::getInstance(); //$db2は$dbと同じオブジェクト
// $result = $db2->execute('INSERT INTO todos (content) VALUES(:content);', ['content' => 'TODOテスト']);
