<?php
session_start();
$message = "";
    //業者でなければ弾く
if (!isset($_SESSION['VENDER'])) {
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
    <title>弁当事前予約サービス 業者トップページ</title>
     <link rel="stylesheet" type="text/css" href="style.css">
</head>
 
<body style="background-color:#ffb;">
<p>弁当事前予約サービス</p>
<h1>業者トップページ</h1>
<p>業者番号：<?php echo $_SESSION['VENDER'] ?>　ログイン中</p>

<?php
//キャンセル文
if(!empty($_GET['message']))
    echo "<p style='color:red;'>". $_GET['message'] ."</p>";
?>
<input type="button" class="btn-sticky" onclick="location.href='./Vupdate.php'" value="弁当情報の登録・更新" style="height: calc(var(--fontRatio) * 7.5);"><br>
<input type="button" class="btn-sticky" onclick="location.href='./bentoList.php'" value="実際の弁当一覧を見る"><br>
<input type="button" class="btn-sticky" onclick="location.href='./VorderCheck.php'" value="予約数の確認" style="height: calc(var(--fontRatio) * 7.5);"><br>
<input type="button" class="btn-sticky" onclick="location.href='./VQRreador.php'" value="引き渡し操作" style="height: calc(var(--fontRatio) * 7.5);"><br>
<!--
    <input type="button" class="btn-sticky" onclick="location.href='./Vdelivery.php'" value="引き渡し操作" style="height: calc(var(--fontRatio) * 7.5);"><br>
-->
    <br>
<!--
    <input type="button" class="btn-sticky" onclick="location.href='./VPenalty.php'" value="ペナルティ操作"><br>
-->
<form method="post" action="Vindex.php">
    <input type="submit" class="btn-sticky" name="logout" value="ログアウト">
</form>
 
</body>
</html>
