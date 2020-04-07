
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<form action="/todos" method="post">
  <input type="hidden" name="csrfToken" value="<?=$csrfToken?>">
  <div>内容
    <input type="text" name="content" id="content">
  </div>
  <div>担当者
    <select name="user_id">
      <option value="">選択してください</option>
      <?php foreach ($users as $user): ?>
        <option value="<?=$user->id?>"><?=$user->name?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div>期限
    <input name="date" type="text" id="datepicker" placeholder="クリックして、日付を選択">

    <select name="hour">
      <?php for ($h=0; $h < 24; $h++): ?>
        <?php if ($h === intval(date('H'))): ?>
          <option value="<?=$h?>" selected><?=$h?></option>
        <?php else: ?>
          <option value="<?=$h?>"><?=$h?></option>
        <?php endif; ?>
      <?php endfor; ?>
    </select>
    <span>時</span>
    <select name="minute">
      <?php for ($m=0; $m < 60; $m++): ?>
        <option value="<?=$m?>"><?=$m?></option>
      <?php endfor; ?>
    </select>
    <span>分</span>
  </div>
  <input type="submit" value="送信">
</form>

<script>
  $today = new Date().toLocaleString({ timeZone: 'Asia/Tokyo' });
  $( "#datepicker" ).datepicker({
    dateFormat: 'yy/mm/dd',
    changeMonth: true,
  });
  $( "#datepicker" ).datepicker('setDate', $today);
</script>
