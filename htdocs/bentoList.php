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
    
<table>
    <tr style="width: 100%; height: 5vh;">
        <td style="width: 70%; height: 100%;">弁当名
        <td style="width: 70%; height: 100%;">値段
    <tr style="width: 100%; height: 20vh;">
        <td style="width: 70%; height: 100%;">弁当画像
        <td style="width: 30%; height: 100%;">注文ボタン
</table>
    
</body>
</html>
