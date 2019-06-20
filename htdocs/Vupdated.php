<?php
session_start();
$message = "";
    //業者でなければ弾く
if (!isset($_SESSION['VENDER'])) {
    header('Location: login.php');
    exit;
}
?>
 
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>弁当事前予約サービス 更新完了</title>
     <link rel="stylesheet" type="text/css" href="style.css">
    <script>
function enter(){
    if( window.event.keyCode == 13 ){
        window.location.href = location.href='./Vupdate.php';
    }
}
</script>
</head>
 
<body style="background-color:#ffb;">
<p>弁当事前予約サービス</p>
<h1>更新完了</h1>

<?php
if(!empty($_GET['message']))
    echo "<p style='color:red;'>". $_GET['message'] ."</p>";
?>
<p>※記述されない場合は更新されていません</p>
<form name="form1">
  <input type="" >
</form>
<input type="submit" class="btn-sticky" onkeypress="enter();" value="戻る"><br>
</body>
</html>
