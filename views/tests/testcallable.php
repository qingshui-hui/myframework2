<?php

echo "<p>Route::get('testcallable', function({
  
}))</p>";
echo "<p>".print_r($request)."</p>";
echo "<p>".date('Y/m/d H:i')."</p>";
echo "<p>".date('Y/m/d H:i', strtotime("2010/10/10"))."</p>";
echo "<p>".date('Y/m/d H:i', strtotime('now'))."</p>";

?>
<?php echo $_COOKIE['PHPSESSID']; ?>
<script>
// alert(document.cookie);
</script>