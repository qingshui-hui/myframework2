<?php
// ---- basic 認証 --------
$user = @$_SERVER['PHP_AUTH_USER'];
$pass = @$_SERVER['PHP_AUTH_PW'];

if (!($user === "admin") || !($pass === "admin") ) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="Basic Authentication Sample"');
    echo "user name and password are neccessary";
    exit();
}

// ----- database テーブルの結合 join --------
use Libs\Database\Database;

$db = Database::getInstance();
$query = "select todos.*, users.name as user_name, users.email as user_email from todos
    join users on todos.user_id = users.id";
$todos = $db->query($query);
?>
<body>
    <?php foreach ($todos as $todo) {
        print_r($todo);
        echo "<br>";
    }?>

</body>