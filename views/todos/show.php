<?php require_once 'views/layout/todo.php';?>

<ul class='todo'>
  <li>
    <span>id : </span>
    <?=$todo->id?>
  </li>
  <li>
    <span>content : </span>
    <?=$todo->content?>
  </li>
</ul>
<div class="links">
  <a href="/todos/<?=$todo->id?>/edit?id=<?=$todo->id?>">編集</a>
  <a href="/todos/<?=$todo->id?>/destroy?id=<?=$todo->id?>">削除</a>
</div>

<?php echo $endlayout ?>