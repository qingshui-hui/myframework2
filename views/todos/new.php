<?php require_once 'views/layout/todo.php';?>

<form action="/todos" method="post">
  <label for="content">内容</label>
  <input type="text" name="content" id="content">
  <input type="submit" value="送信">
</form>

<?php echo $endlayout ?>