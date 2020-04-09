<!-- 新規作成と編集のフォームを共通の形式でかけるように、inputの初期値を設定する。
コントローラーのnew, editメソッドを参照 -->
<input type="hidden" name="csrfToken" value="<?=$csrfToken?>">
<div>内容
  <input type="text" name="content" id="content" value="<?=$request->get('content')?>">
  <?php foreach ($errors->get('content') as $message): ?>
    <p><?=$message?></p>
  <?php endforeach; ?>
</div>
<div>担当者
  <select name="user_id">
    <option value="">選択してください</option>
    <?php foreach ($users as $user): ?>
      <?php $selectedUser = (intval($request->get('user_id')) === intval($user->id)) ? 'selected' : ''; ?>
      <option value="<?=$user->id?>" <?=$selectedUser?>><?=$user->name?></option>
    <?php endforeach; ?>
  </select>
  <?php foreach($errors->get('user_id') as $message): ?>
    <p><?=$message?></p>
  <?php endforeach ?>
</div>
<div>期限
  <?php $date = $request->get('date', date('Y/m/d')) ?>
  <input name="date" type="text" id="datepicker" placeholder="クリックして、日付を選択" value="<?=$date?>">

  <select name="hour">
    <?php for ($h=0; $h < 24; $h++): ?>
      <?php $hour = $request->get('hour', date('H')) ?>
      <?php $selectedHour = ($h === intval($hour)) ? 'selected' : ''; ?>
        <option value="<?=$h?>" <?=$selectedHour?> ><?=$h?></option>
    <?php endfor; ?>
  </select>
  <span>時</span>
  <select name="minute">
    <?php for ($m=0; $m < 60; $m++): ?>
      <?php $minute = $request->get('minute', '0') ?>
      <?php $selectedMinute = ($m === intval($minute)) ? 'selected' : ''; ?>
      <option value="<?=$m?>" <?=$selectedMinute?>><?=$m?></option>
    <?php endfor; ?>
  </select>
  <span>分</span>
  <?php foreach($errors->get('date') as $message): ?>
    <p><?=$message?></p>
  <?php endforeach ?>
</div>
<input type="submit" value="送信">

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $( "#datepicker" ).datepicker({
    dateFormat: 'yy/mm/dd',
    changeMonth: true,
  });
</script>