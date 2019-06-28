<?php
session_start();
$list = "";
    try {
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        
        //予約一覧作成
        //SQL作成・実行
        $sql = "SELECT * FROM `ordertable`;";
        $prepare = $db->prepare($sql);
        $prepare->execute();
        
        $list .= '予約一覧';
        $list .= '<br><table style="width: 80vw; height: 2em;"><tr>';
        $list .= '<td style="width: 5vw;">受取';
        $list .= '<td style="width: 10vw;">学生番号';
        $list .= '<td style="width: 10vw;">弁当番号';
        //$list .= '<td style="width: 35vw;">UUID';
        foreach ($prepare->fetchAll(PDO::FETCH_ASSOC) as $result)
        {
            $list .= '<tr>';
            if ($result["check"] == 1)
                $list .= '<td style="color:blue;">完了';
            else $list .= '<td style="color:red;">未了';
            $list .= '<td $result["user"];
            $list .= '<td $result["id"];
            $list .= '<td $result["QRid"];
        }
        $list .= '</table>';
    } catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>弁当事前予約サービス デバッグ用　テーブル一覧</title>
     <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style="background-color: #000; color:#fff;">
<p>弁当事前予約サービス デバッグ用　テーブル一覧</p>
<br>
<form method="post" action="Vdelivery.php">
<br>
    <?php echo $list; ?>
<br>
</body>
</html>