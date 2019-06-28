<?php
session_start();

$message = "";

    //学生でなければ弾く
if (!isset($_SESSION['USER'])) {
    header('Location: login.php');
    exit;
}

//ログアウト機能
if(isset($_POST['logout'])){   
    $_SESSION = array();
    session_destroy();
    header('Location: login.php');
    exit;
}
?>
 
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>弁当事前予約サービス トップページ</title>
     <link rel="stylesheet" type="text/css" href="style.css">
</head>
 
<body>
<p>弁当事前予約サービス</p>
<h1>トップページ</h1>
<p>学生番号：<?php echo $_SESSION['USER'] ?>　ログイン中</p>

<?php
//キャンセル文
if(!empty($_GET['message']))
    echo "<p style='color:red;'>". $_GET['message'] ."</p>";
?>

<input type="button" class="btn-sticky" onclick="location.href='./bentoList.php'" value="弁当閲覧・予約" style="height: calc(var(--fontRatio) * 7.5);"><br>
<input type="button" class="btn-sticky" onclick="location.href='./orderCheck.php'" value="予約確認"><br>
//<input type="button" class="btn-sticky" onclick="location.href='./QRdisplay.php'" value="QRコード表示" style="height: calc(var(--fontRatio) * 7.5);"><br>
<br>
<form method="post" action="index.php">
    <input type="submit" class="btn-sticky" name="logout" value="ログアウト">
</form>
 
</body>
</html>
