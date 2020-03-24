<!DOCTYPE html>
<html>

<head>
  <title><?php echo $title='todo' ?></title>
</head>
<body>
  <header>
    <a href="/todos/new">add todo</a> |
    <a href="/todos">todo list</a> |
    <a href="/boards">boards</a> |
    <?php if (App\Models\User::isLogin()):?>
      <a href="/logout">ログアウト</a>
    <?php else: ?>
      <a href="/login">ログイン</a>
    <?php endif; ?>
    
  </header>
  <div class='content'>
    <?php $view->yield(); ?>
  </div>
  <?php require_once('views/layout/footer.php'); ?>
</body>
</heml>