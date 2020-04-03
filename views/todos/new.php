
<form action="/todos" method="post">
  <input type="hidden" name="csrfToken" value="<?=$csrfToken?>">
  <label for="content">内容</label>
  <input type="text" name="content" id="content">
  <input type="submit" value="送信">
</form>
