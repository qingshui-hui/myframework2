
<ul class='todo_list'>
  <?php foreach ($todos as $todo): ?>
    <li>
      <?= h($todo->content) ?>
      <a href="/todos/<?=$todo->id?>?id=<?=$todo->id?>">詳細</a>
      <a href="/todos/<?=$todo->id?>/edit?id=<?=$todo->id?>">編集</a>
      <a href="/todos/<?=$todo->id?>/destroy?id=<?=$todo->id?>">削除</a>
    </li>
  <?php endforeach; ?>
</ul>