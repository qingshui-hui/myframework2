<!DOCTYPE html>
<html>
<head>
</head>
<body>
  <header>
  </header>
  <a href="/boards">to boards</a>
  <table>
    <tr>
      <th>id</th>
      <th>title</th>
      <th>content</th>
      <th>board_id</th>
      <th>position</th>
    </tr>
    <?php foreach ($cards as $card): ?>
      <tr>
        <td><?=$card->id?></td>
        <td><?=$card->title?></td>
        <td><?=$card->content?></td>
        <td><?=$card->board_id?></td>
        <td><?=$card->position?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>