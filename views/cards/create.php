<!DOCTYPE html>
<html>
<head>
</head>
<body>
  <header>
  </header>
  <div>ボード名: <?=$board->title?></div>
  <div>カードを追加</div>
  <form action="/boards/<?=$board->id?>/cards" method="post">
    <label for="title">タイトル</label>
    <input type="text" name="title" id="title">
    <br>
    <label for="content">内容</label>
    <input type="text" name="content" id="content">
    <input type="submit" value="送信">
  </form>
</body>
</html>