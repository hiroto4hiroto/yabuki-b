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
    <style type="text/css">
    <!--
    tr td {border-style: solid;}
    -->
    </style>
</head>
 
<body>
<p>弁当事前予約サービス</p>
<h1>弁当閲覧・予約</h1>

<table style="width: 35vh; height: 25vh;">
    <tr style="width: 100%; height: 1.5em;">
        <td style="width: 70%;">弁当名
        <td style="width: 30%;">値段
    <tr style="width: 100%; max-height: 100%;">
        <td style="width: 70%;">弁当画像
        <td style="width: 30%;">注文ボタン
</table>
    
</body>
</html>
