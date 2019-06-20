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
 
<body class="vender">
<p>弁当事前予約サービス</p>
<h1>更新完了</h1>

<?php
if(!empty($_GET['message']))
    echo "<p style='color:red;'>". $_GET['message'] ."</p>";
?>
<p>※記述されない場合は更新されていません</p>
<form name="form">
<input type="button" class="btn-sticky" onclick="location.href='./bentoList.php'" value="実際の弁当一覧を見る"><br>
<input type="button" class="btn-sticky" onclick="location.href='./Vupdate.php'" value="戻る" style="height: calc(var(--fontRatio) * 7.5);">
</body>
</html>
