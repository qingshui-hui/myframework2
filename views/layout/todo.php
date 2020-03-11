<!DOCTYPE html>
<html>

<head>
  <title><?php echo $title='todo' ?></title>
</head>
<body>
  <header>
    <a href="/todos/new">add todo</a> |
    <a href="/todos">todo list</a> |
    <?php if (App\Models\User::isLogin()) {?>
      <a href="/logout">ログアウト</a>
    <?php } else { ?>
      <a href="/login">ログイン</a>
    <?php } ?>
    
  </header>

<?php
$endlayout = "
<p style='display:none;'>endoflayout</p>
</body>
</html>
"
?>