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
        
        if( !empty($_POST['delivery']) ){
            //予約一覧作成
            //SQL作成・実行
            $sql = 'UPDATE ordertable SET `check` = 1 WHERE user = '. $_POST['user'];
            $prepare = $db->prepare($sql);
            $prepare->execute();
        }
        
        //予約一覧作成
        //SQL作成・実行
        $sql = 'SELECT * FROM ordertable ORDER BY `check`, `date`;';
        $prepare = $db->prepare($sql);
        $prepare->execute();
        
        $list .= '予約一覧';
        $list .= '<br><table style="width: 80vw; height: 2em;"><tr>';
        $list .= '<td style="width: 5vw;">受取';
        $list .= '<td style="width: 10vw;">日付';
        $list .= '<td style="width: 10vw;">学生番号';
        $list .= '<td style="width: 20vw;">弁当名';
        //$list .= '<td style="width: 35vw;">UUID';
        foreach ($prepare->fetchAll(PDO::FETCH_ASSOC) as $result)
        {
            if ($result["date"] == $getdate)
            {
                $list .= '<tr>';
            if ($result["check"] == 1)
                $list .= '<td class="todayOrder" style="color:blue;">完了';
            else $list .= '<td class="todayOrder" style="color:red;">未了';
                $list .= '<td class="todayOrder">'. $result["date"];
                $list .= '<td class="todayOrder">'. $result["user"];
                $list .= '<td class="todayOrder">'. $result["name"];
                //$list .= '<td class="todayOrder">'. $result["QRid"];
            }
            else {
                $list .= '<tr>';
                if ($result["check"] == 1)
                    $list .= '<td style="color:blue;">完了';
                else $list .= '<td style="color:red;">未了';
                $list .= '<td>'. $result["date"];
                $list .= '<td>'. $result["user"];
                $list .= '<td>'. $result["name"];
                //$list .= '<td class="orderText">'. $result["QRid"];
            }
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
<br>
<form method="post" action="Vdelivery.php">
    <table>
        <tr><td><label for="user">学生番号</label>
            <td><input id="user" type="text" name="user">
    </table>
    <br>
    <input class="btn-sticky" type="submit" name="delivery" value="引き渡し">
</form>
    <br>
    <?php echo $list; ?>
 
</body>
</html>
