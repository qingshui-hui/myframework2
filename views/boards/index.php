
<html>
  <head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="./public/reset.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" integrity="sha384-v8BU367qNbs/aIZIxuivaU55N5GPF89WBerHoGA4QTcbUjYiLQtKdrfXnqAcXyTv" crossorigin="anonymous">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  </head>
  <body>
    <header>
      <h3>ボードリスト<a href="/boards/create">ボードを追加する</a></h3>
    </header>
    <div class="content_wrapper">
      <div class="boards">
        <?php foreach ($boards as $board): ?>
          <div class="board">
            <h3>
              <a href="/boards/<?=$board->id?>"><?=h($board->title)?></a>
            </h3>
            <div class="addcard">
              <a href="/boards/<?=$board->id?>/cards/create">カードを追加する</a>
            </div>
            <ul class="cards sortable" id="sortable-<?=$board->id?>">
              <?php foreach($board->cards() as $card): ?>
                <li class="card draggable">
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
        <?php endforeach; ?>
      </div>
    </div>
  </body>
</html>

<script>
$(function() {
  $( ".sortable" ).sortable({
    connectWith: ".sortable"
  });
});
</script>

<style>
a {
  text-decoration: none;
  color: #172b4d;
}
header {
  height: 40px;
  background-color: rgb(126, 199, 223);
  padding: 10px;
}
header h3 {
  color: #ebecf0;
}
.content_wrapper {
  height: calc(100% - 60px);
  background-color: rgb(173, 215, 230);
}
.boards {
  margin: 0 10px;
  padding: 10px 0 20px;
  height: calc(100% - 30px);
  display: flex;
  flex-wrap: nowrap;
  overflow-x: scroll;
  /* white-space: nowrap; */
}
.board {
  display: flex;
  flex-direction: column;

  background-color: #ebecf0;
  width: 272px;
  height: calc(100% - 40px);
  padding: 10px 0 10px;
  margin: 0 10px 0 0;
  white-space: initial;
  /* デフォルトで縮む効果を向こうにできた */
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