
<ul class='todo'>
  <li>
    <span>id : </span>
    <?=$todo->id?>
  </li>
  <li>
    <span>内容 : </span>
    <?=$todo->content?>
  </li>
  <li>
    <span>作成日時 : </span>
    <?=$todo->created_at?>
  </li>
  <li>
    <span>経過日数 : </span>
    <?=$todo->daysFromCreation()?>
  </li>
</ul>
<div class="links">
  <a href="/todos/<?=$todo->id?>/edit?id=<?=$todo->id?>">編集</a>
  <a href="/todos/<?=$todo->id?>/destroy?id=<?=$todo->id?>">削除</a>
</div>
