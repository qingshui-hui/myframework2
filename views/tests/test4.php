<?php

echo "<p>request->all() : ";
print_r($request->all());
echo "</p>";

// ＄＿FILESの第二階層
// name, tmp_name, error, type, size
if (isset($_FILES['image'])) {
  $fileName = $_FILES['image']['name'];
  print_r($request->file('image')['tmp_name']);
  print_r($_FILES['image']['tmp_name']);
  // if (move_uploaded_file($_FILES['image']['tmp_name'], "public/uploads/{$fileName}")) {
  //   echo "<p>ファイルのアップロードに成功しました</p>";
  // } else {
  //   echo $_FILES['image']['error'];
  //   echo "<p>失敗しました</p>";
  // }
}
?>

<!-- <iframe src="public/sample/robot-movie.mp4"></iframe> -->