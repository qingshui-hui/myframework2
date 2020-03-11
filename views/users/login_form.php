<?php require_once 'views/layout/app.php'; ?>

<form action="/login" method="post">
  <label for="email">メールアドレス</label>
  <input type="email" name="email" id="email">
  <br>
  <label for="password">パスワード</label>
  <input type="password" name="password" id="password">
  <br>
  <button type="submit">ログイン</button>
</form>
<div>
  <span>アカウントをお持ちでない方は-></span>
  <a href="/register">新規登録</a>
</div>

<?php echo $endlayout ?>