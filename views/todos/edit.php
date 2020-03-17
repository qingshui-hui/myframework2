
<form action="/todos/<?=$todo->id?>" method="post">
  <input type="hidden" name="id" value="<?=$todo->id?>">
  <label for="content">内容</label>
  <input type="text" name="content" id="content" value="<?=$todo->content?>">
  <input type="submit" value="送信">
</form>