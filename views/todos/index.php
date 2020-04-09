
<div class="button-list">
  <a href="/todos/search"><button>検索ページへ</button></a>
  <a href="/todos/deleteOverdue">
    <button id="delete-overdue">期限切れを全て消去</button>
  </a>
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

<script>
</script>