
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<form action="/todos/<?=$todo->id?>" method="post">
  <input type="hidden" name="csrfToken" value="<?=$csrfToken?>">
  <input type="hidden" name="id" value="<?=$todo->id?>">
  <div>内容
    <input type="text" name="content" id="content" value="<?=$todo->content?>">
  </div>
  <div>担当者
    <select name="user_id">
      <?php foreach ($users as $user): ?>
        <?php if ($user->id === $todo->user()->id): ?>
          <option value="<?=$user->id?>" selected><?=$user->name?></option>
        <?php else: ?>
          <option value="<?=$user->id?>"><?=$user->name?></option>
        <?php endif; ?>
      <?php endforeach; ?>
    </select>
  </div>
  <div>期限
    <input name="date" type="text" id="datepicker" value="<?=$todo->date()?>">

    <select name="hour">
      <?php for ($h=0; $h < 24; $h++): ?>
        <?php $selectedHour = ($h === intval($todo->hour())) ? 'selected' : ''; ?>
        <option value="<?=$h?>" <?=$selectedHour?>><?=$h?></option>
      <?php endfor; ?>
    </select>
    <span>時</span>
    <select name="minute">
      <?php for ($m=0; $m < 60; $m++): ?>
        <?php $selectedMinute = ($m === intval($todo->minute())) ? 'selected' : ''; ?>
        <option value="<?=$m?>" <?=$selectedMinute?>><?=$m?></option>
      <?php endfor; ?>
    </select>
    <span>分</span>
  </div>
  <input type="submit" value="送信">
</form>

<script>
  // $today = new Date().toLocaleString({ timeZone: 'Asia/Tokyo' });
  // console.log($today);
  // $( "#datepicker" ).datepicker({
  //   dateFormat: 'yy/mm/dd',
  //   changeMonth: true,
  // });
  // $( "#datepicker" ).datepicker('setDate', $today);
</script>