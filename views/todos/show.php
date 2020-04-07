
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
    <span>期限 : </span>
    <?=$todo->deadline()?>
  </li>
  <li>
    <span>担当者 : </span>
    <?=$todo->user()->name?>
  </li>
  <li>
    <span>作成日時 : </span>
    <?=date('Y/m/d H:i', strtotime($todo->created_at))?>
  </li>
</ul>
<div class="links">
  <a href="/todos/<?=$todo->id?>/edit?id=<?=$todo->id?>">編集</a>
  <a href="/todos/<?=$todo->id?>/destroy?id=<?=$todo->id?>">削除</a>
</div>
