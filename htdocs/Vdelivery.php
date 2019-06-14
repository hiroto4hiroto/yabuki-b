<?php
session_start();
$list = "";
    //業者でなければ弾く
if (!isset($_SESSION['VENDER'])) {
    header('Location: login.php');
    exit;
}
    try {
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        
        //予約一覧作成
        //SQL作成・実行
        $sql = 'SELECT * FROM ordertable ORDER BY date;';
        $prepare = $db->prepare($sql);
        $prepare->execute();
        
        $list .= '予約一覧';
        $list .= '<br><table style="width: 80vw; height: 2em;"><tr>';
        $list .= '<td style="width: 5vw;">受取';
        $list .= '<td style="width: 10vw;">日付';
        $list .= '<td style="width: 10vw;">学生番号';
        $list .= '<td style="width: 20vw;">弁当名';
        $list .= '<td style="width: 35vw;">UUID';
        foreach ($prepare->fetchAll(PDO::FETCH_ASSOC) as $result)
        {
            $list .= '<tr>';
            $list .= '<td class="orderText">'. $result["check"];
            $list .= '<td class="orderText">'. $result["date"];
            $list .= '<td class="orderText">'. $result["user"];
            $list .= '<td class="orderText">'. $result["name"];
            $list .= '<td class="orderText">'. $result["QRid"];
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
    <title>弁当事前予約サービス 引き渡し操作</title>
     <link rel="stylesheet" type="text/css" href="style.css">
</head>
 
<body class="vender">
<p>弁当事前予約サービス</p>
<h1>引き渡し操作</h1>

<form method="post" action="Vdelivery.php">
    <table>
        <tr><td style="border: solid 1px;"><label for="user">学生番号</label>
            <td style="border: solid 1px;"><input id="user" type="text" name="user">
    </table>
    <br>
    <input class="btn-sticky" type="submit" name="delivery" value="引き渡し">
</form>
 
</body>
</html>
