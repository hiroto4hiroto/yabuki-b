<?php
session_start();
$canselMessage = "";
    //学生でなければ弾く
if (!isset($_SESSION['USER'])) {
    header('Location: login.php');
    exit;
}
?>
 
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>弁当事前予約サービス 弁当閲覧・予約</title>
     <link rel="stylesheet" type="text/css" href="style.css">
</head>
 
<body>
<p>弁当事前予約サービス</p>
<h1>弁当閲覧・予約</h1>
    
<table style="border: 1px;">
    <tr><td>弁当名<td>値段
    <tr><td>弁当画像<td>アレルギー表示<td>注文ボタン
</table>
    
</body>
</html>