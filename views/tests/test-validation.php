<?php

?>

<p>test-validation<a href="/test1">back</a></p>
<p>[
      'email' => 'required|unique:users',
      'nickname' => 'nullable|max:10',
      'title' => 'required'
    ]</p>
<form action="/test-validation" method="post">
  <div>e-メール
    <input type="text" name="email" id="email" value="<?=$input['email']?>">
    <?php foreach($errors->get('email') as $error): ?>
      <p><?= $error ?></p>
    <?php endforeach; ?>
  </div>
  <div>ニックネーム
    <input type="text" name="nickname" id="nickname">
    <?php foreach($errors->get('nickname') as $error): ?>
      <p><?= $error ?></p>
    <?php endforeach; ?>
  </div>
  <div>タイトル
    <input type="text" name="title" id="title">
    <?php foreach($errors->get('title') as $error): ?>
      <p><?= $error ?></p>
    <?php endforeach; ?>
  </div>
  <div>
    <button type="submit">テスト</button>
  </div>
</form>
<div><button id="btn1">1</button>10文字制限, タイトルは必要</div>
<div><button id="btn2">2</button></div>
<div><button id="btn3">3</button>ニックネームは空でも良い</div>

<script>
function setInput(email, nickname, title) {
  document.getElementById('email').value = email;
  document.getElementById('nickname').value = nickname;
  document.getElementById('title').value = title;
}
let btn1 = document.getElementById('btn1');
btn1.addEventListener('click', function () {
  setInput('aa@aa', 'kawahanagai', '')
});
let btn2 = document.getElementById('btn2');
btn2.addEventListener('click', function () {
  setInput('afew@wfewfe', 'kawa', 'susukisougen')
});
let btn3 = document.getElementById('btn3');
btn3.addEventListener('click', function () {
  setInput('afefew@wfefegw', '', 'harunoyama')
});
</script>