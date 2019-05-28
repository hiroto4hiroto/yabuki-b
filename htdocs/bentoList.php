<?php
session_start();

    // 変数の初期化
    $sql = null;
    $result = null;
    $db = null;
    $message = '';

    //学生でなければ弾く
    if (!isset($_SESSION['USER'])) {
        header('Location: login.php');
        exit;
    }

    try {
        //DBに接続
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        //SQL作成・実行
        $sql = 'SELECT * FROM bentoTable ORDER BY date, bento ASC;';
        $sql .= 'SELECT * FROM bentoTable;';
        $prepare = $db->prepare($sql);
        $list = "";
        $prepare->execute();
        
        foreach ($prepare->fetchAll(PDO::FETCH_ASSOC) as $result)
        {
            $list .= "<tr>\n";
            $list .= "<td style='width:15vw;'>{$result['date']}</td>\n";
            $list .= "<td style='width:10vw;'>{$result['bento']}</td>\n";
            $list .= "<td style='width:20vw;'>{$result['name']}</td>\n";
            $list .= "<td style='width:10vw;'>{$result['price']}</td>\n";
            $list .= "<td style='width:10vw;'>{$result['stocks']}</td>\n";
            $list .= "<td style='width:20vw; height:15vw; background:url(\"./bentoImages/".(string)$result['bento'].".jpg\"); background-size:cover; background-position: center;'></td>\n";
            $list .= "</tr>\n";
        }
    }
    catch {
        echo $e->getMessage();
        die();
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

<table style="width: calc(30vh + 15vw); height: calc(20vh + 10vw)">
        <tr style="width: 100%; height: 1.5em;">
        <td style="min-width: 50%;">販売日:2019/07/07
        <td style="max-width: 50%;">残り:99
    <tr style="width: 100%; height: 1.5em;">
        <td style="min-width: 70%;">１２３４５６７８弁当
        <td style="max-width: 30%;">1234円
    <tr style="width: 100%; max-height: 100%;">
        <td style="min-width: 70%;">弁当画像
        <td style="max-width: 30%;">予約<br>する
</table>
    
</body>
</html>
