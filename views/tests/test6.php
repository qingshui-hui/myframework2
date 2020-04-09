<?php
// json request はどうあつかうか

// print_r($_SERVER);
print_r(file_get_contents('php://input'));
print_r($http_response_header);

// 受け取り側
// $json = file_get_contents("php://input");
// $contents = json_decode($json, true);
// var_dump($contents);
?>
<button id="api">test api</button>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
$('#api').on('click', testApi);
function testApi() {
  console.log('click');

  $.ajax({
    type: "POST",
    url: '/testApi',
    dataType: 'json',
    data: {
      name: "bbb",
      status: "from jquery"
    }
  })
  .done(function(data) {
    console.log(data);
  })
  .fail(function(XMLHttpRequest, textStatus, errorThrown) {
    console.log('failed')
    // console.log(error)
　　console.log("XMLHttpRequest : " + XMLHttpRequest.status);
　　console.log("textStatus     : " + textStatus);
　　console.log("errorThrown    : " + errorThrown.message);
  });
}
</script>