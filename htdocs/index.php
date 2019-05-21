<?php
session_start();

$canselMessage = "";

    //学生でなければ弾く
if (!isset($_SESSION['USER'])) {
    header('Location: login.php');
    exit;
}

//ログアウト機能
if(isset($_POST['logout'])){
    
    $_SESSION = [];
    session_destroy();
    header('Location: login.php');
    exit;
}
?>
 
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>トップページ</title>
</head>
 
<body>
<h1>弁当事前予約サービス</h1>
<h2>トップページ</h2>
<p>学生番号：<?php echo $_SESSION['USER'] ?>　ログイン中</p>

<?php
//キャンセル文
if(!empty($_GET['canselName']))
    echo "<p style='color:red;'>". $_GET['canselName'] ."の予約をキャンセルしました。<p>";
?>

<input type="button" onclick="location.href='./check.php'"value="予約確認"><br>
<input type="button" onclick="location.href='リンク先url'"value="弁当予約"><br>
<input type="button" onclick="location.href='./QRdisplay.php'"value="QRコード表示"><br>
<br>
<form method="post" action="login.php">
    <input type="submit" name="logout" value="ログアウト">
</form>
 
</body>
</html>
