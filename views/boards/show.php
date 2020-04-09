
<html>
  <head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="/public/reset.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" integrity="sha384-v8BU367qNbs/aIZIxuivaU55N5GPF89WBerHoGA4QTcbUjYiLQtKdrfXnqAcXyTv" crossorigin="anonymous">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  </head>
  <body>
    <div>
      <a href="/boards">
        <button>戻る</button>
      </a>
      <button id="send-positions-btn">並べ替えを保存する</button>
      <a href="/boards/<?=$board->id?>/destroy">
        <button>ボードを削除する</button>
      </a>
    </div>
    <div class="board">
      <h3>
        <a href="/boards/<?=$board->id?>"><?=h($board->title)?></a>
      </h3>
      <div class="addcard">
        <a href="/boards/<?=$board->id?>/cards/create">カードを追加する</a>
      </div>
      <ul class="cards sortable" id="sortable-<?=$board->id?>" data-id="<?=$board->id?>">
        <?php foreach($board->cards() as $card): ?>
          <li class="card draggable" data-id="<?=$card->id?>">
            <span><?= h($card->title) ?></span>
            <a href="/cards/<?=$card->id?>/destroy">
              <i class="fas fa-times"></i>
            </a>
            <a href="">
              <i class="fas fa-edit"></i>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </body>
</html>

<script>
$(function() {
  $( ".sortable" ).sortable({
    axis: "y",
  });
});
</script>
<!-- <script src="https://unpkg.com/axios/dist/axios.min.js"><script> -->
<script src="/views/boards/sort.js"></script>

<style>
a {
  text-decoration: none;
  color: #172b4d;
}
.board {
  margin: 20px;
  display: flex;
  flex-direction: column;

  background-color: #ebecf0;
  width: 272px;
  height: calc(100% - 40px);
  padding: 10px 0 10px;
  margin: 0 10px 0 0;
  white-space: initial;
  /* デフォルトで縮む効果を無効にできた */
  flex-shrink: 0;
}
.board h3 {
  color: #172b4d;
  font-weight: 600;
  margin: 0px 10px 8px;
  font-size: 18px;
  line-height: 22px;
}
.board .addcard {
  margin: 0 10px 8px;
}
.cards {
  /* 親要素をflexboxにしていることで、100%が残りの高さになる */
  height: 100%;
  overflow-y: scroll;
  white-space: initial;
}
.card {
  background-color: #fff;
  margin: 10px;
  padding: 5px;
}
.card .fa-edit, .card .fa-times {
  float: right;
  margin-right: 5px;
}
.card .fa-edit:hover, .card .fa-times {
  cursor: pointer;
}
</style>