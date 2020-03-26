<?php

use Libs\Routing\Route;
use Libs\Support\Str;
// インポート規則はファイル単位のものです。つまり、インクルードされたファイルは インクロード元の親ファイルのインポート規則を 引き継ぎません。

echo "test2\n";
$route = new Route();
$reflMethod = new ReflectionMethod('Libs\Routing\Route', 'getUrlParams');
$reflMethod->setAccessible(true);
print_r($reflMethod->invokeArgs($route, [['test', '{id}', '{id2}'], ['test', '1', '2']]));

echo "<p>id1 = {$id1}</p>";
echo "<p>id2 = {$id2}</p>";
print_r($request);

echo Str::removeBrace('{(aaa)}');