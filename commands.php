<?php
// 次のコマンドでコントローラーを作成可能
// $ php commands.php controller tests

function test()
{
  file_put_contents('test.php', 'これはテ
  ストです');
}

function controller($name)
{
  $controllerName = ucfirst($name) ."Controller";
  $filePath = 'controllers/' .$controllerName .".php";
  $content = 
"<?php
class " .$controllerName ." {}";
  file_put_contents($filePath, $content);
}

function migrate_todos()
{
  require 'database/migrations/createTodosTable.php';
}

$command = $argv[1];

if ($argv[2]) {
  $command($argv[2]);
} else {
  $command();
}