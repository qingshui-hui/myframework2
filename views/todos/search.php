
<div class="button-list">
</div>
<div class="search form">
  <span>検索フォーム</span>
  <a href="/todos/search"><button>リセット</button></a>
  <form action="/todos/search" method="get">
    <span>担当者</span>
    <select name="user_id" id="select-user">
        <option value="">未選択</option>
      <?php foreach ($users as $user): ?>
        <?php $selectedUser = (intval($request->get('user_id')) === intval($user->id)) ? 'selected' : ''; ?>
        <option value="<?=$user->id?>" <?=$selectedUser?>><?=$user->name?></option>
      <?php endforeach; ?>
    </select>

    <div>
      <span>期間</span>
      <!-- 始まり -->
      <?php $startDate = $request->get('start.date', '') ?>
      <input name="start[date]" type="text" id="datepicker1" placeholder="クリックして、日付を選択" value="<?=$startDate?>" autocomplete="off">

      <select name="start[hour]">
        <?php for ($h=0; $h < 24; $h++): ?>
          <?php $startHour = $request->get('start.hour', '0') ?>
          <?php $selectedHour = ($h === intval($startHour)) ? 'selected' : ''; ?>
            <option value="<?=$h?>" <?=$selectedHour?> ><?=$h?></option>
        <?php endfor; ?>
      </select>
      <span>時</span>
      <select name="start[minute]">
        <?php for ($m=0; $m < 60; $m++): ?>
          <?php $startMinute = $request->get('start.minute', '0') ?>
          <?php $selectedMinute = ($m === intval($startMinute)) ? 'selected' : ''; ?>
          <option value="<?=$m?>" <?=$selectedMinute?>><?=$m?></option>
        <?php endfor; ?>
      </select>
      <span>分</span>
      <!-- 終わり -->
      <span>~</span>
      <?php $endDate = $request->get('end.date', '') ?>
      <input name="end[date]" id="datepicker2" placeholder="クリックして、日付を選択" value="<?=$endDate?>" autocomplete="off">

      <select name="end[hour]">
        <?php for ($h=0; $h < 24; $h++): ?>
          <?php $endHour = $request->get('end.hour', '0') ?>
          <?php $selectedHour = ($h === intval($endHour)) ? 'selected' : ''; ?>
            <option value="<?=$h?>" <?=$selectedHour?> ><?=$h?></option>
        <?php endfor; ?>
      </select>
      <span>時</span>
      <select name="end[minute]">
        <?php for ($m=0; $m < 60; $m++): ?>
          <?php $endMinute = $request->get('end.minute', '0') ?>
          <?php $selectedMinute = ($m === intval($endMinute)) ? 'selected' : ''; ?>
          <option value="<?=$m?>" <?=$selectedMinute?>><?=$m?></option>
        <?php endfor; ?>
      </select>
      <span>分</span>

    </div>

    <button type="submit">検索</button>
  </form>
</div>
<table class='todo-list'>
  <tr><th>内容</th><th>担当者</th><th>期限</th><th></th></tr>
  <?php foreach ($todos as $todo): ?>
    <tr>
      <td><?= h($todo->content) ?></td>
      <td><?= h($todo->user_name) ?></td>
      <?php if ($todo->dead()): ?>
        <td style='color:#dc2d2d;'><?= h($todo->deadline()) ?></td>
      <?php else: ?>
        <td><?= h($todo->deadline()) ?></td>
      <?php endif; ?>
      <td>
        <a href="/todos/<?=$todo->id?>">詳細</a>
        <a href="/todos/<?=$todo->id?>/edit">編集</a>
        <a href="/todos/<?=$todo->id?>/destroy">削除</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$( "#datepicker1" ).datepicker({
  dateFormat: 'yy/mm/dd',
  changeMonth: true,
});
$( "#datepicker2" ).datepicker({
  dateFormat: 'yy/mm/dd',
  changeMonth: true,
});
</script>