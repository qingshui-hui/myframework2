
let sendPosBtn = document.getElementById('send-positions-btn');
sendPosBtn.addEventListener('click', sendPositions);

function sendPositions() {
  let positions = getPositions();
  $.ajax({
    url: "/boards/registerPosition",
    type: "POST",
    dataType: 'json',
    data: {
      positions: positions,
      boardId: getBoardId()
    }
  })
  .done(function() {
    alert('success');
  })
  .fail(function(XMLHttpRequest, textStatus, errorThrown) {
    console.log('failed');
　　console.log("XMLHttpRequest : " + XMLHttpRequest.status);
　　console.log("textStatus     : " + textStatus);
　　console.log("errorThrown    : " + errorThrown.message);
  });
}

function getPositions() {
  let board = document.getElementsByClassName('cards')[0];
  
  let cards = board.children;
  let positions = [];
  for (let i=0; i < cards.length; i++) {
    let id = cards[i].getAttribute('data-id');
    positions.push([id, i+1]);
  
  }
  console.log(positions);
  return positions;
}

function getBoardId() {
  let board = document.getElementsByClassName('cards')[0];
  let baordId = board.getAttribute('data-id');
  return baordId;
}