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
        $sql = 'SELECT * FROM bentotable ORDER BY date, price ASC;';
        $sql .= 'SELECT * FROM bentotable;';
        $prepare = $db->prepare($sql);
        $list = "";
        $prepare->execute();
        
        foreach ($prepare->fetchAll(PDO::FETCH_ASSOC) as $result)
        {
            $list .= '<table style="width: calc(30vh + 15vw); height: calc(20vh + 10vw)">';
            $list .= '<tr style="width: 100%; height: 1.5em;">';
            $list .= '<td style="width: 70%;">販売日:'. $result["date"] .'';
            $list .= '<td style="width: 30%;">残り:'. $result["stocks"] .'個';
            $list .= '<tr style="width: 100%; height: 1.5em;">';
            $list .= '<td style="min-width: 70%;">'. $result["name"] .'';
            $list .= '<td style="max-width: 30%;">'. $result["price"] .'円';
            $list .= '<tr style="width: 100%; max-height: 100%;">';
            $list .= '<td style="min-width: 70%; background-image: url(\'bentoimages/'.$result["name"].'.jpg\'); background-size: cover; background-position: center;">';
            $list .= '<td style="max-width: 30%;"><input type="button" class="btn-sticky" value="予約する" style="width: 100%; height: 100%"><br>';
            $list .= '</table><br>';
        }
    } catch(PDOException $e) {
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

<?php echo $list; ?>
    
</body>
</html>
