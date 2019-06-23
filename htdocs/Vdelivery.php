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
            $sql = 'UPDATE `ordertable` SET `check` = 1 WHERE user = '. $_POST['user'];
            $prepare = $db->prepare($sql);
            $prepare->execute();
        }
        
        //予約一覧作成
        //SQL作成・実行
        $sql = "SELECT `order`.check as `check`, `bento`.date as `date`, `order`.user as `user`, `order`.id as `id`, `bento`.name as `name`";
        $sql .= " FROM `ordertable` as `order` LEFT JOIN `bentotable` as `bento` ON `order`.id = `bento`.id";
        $sql .= " ORDER BY `order`.check, `bento`.date, `order`.id;";
        $prepare = $db->prepare($sql);
        $prepare->execute();
        
        $list .= '予約一覧';
        $list .= '<br><table style="width: 80vw; height: 2em;"><tr>';
        $list .= '<td style="width: 5vw;">受取';
        $list .= '<td style="width: 10vw;">日付';
        $list .= '<td style="width: 10vw;">学生番号'; 
        $list .= '<td style="width: 5vw;">弁当ID';
        $list .= '<td style="width: 20vw;">弁当名';
        foreach ($prepare->fetchAll(PDO::FETCH_ASSOC) as $result)
        {
            $plusClass = '';
            if ($result["date"] == $getdate) $plusClass = ' class="todayOrder" ';
                
            $list .= '<tr>';
            if ($result["check"] == 1)
                $list .= '<td'. $plusClass .' style="color:blue;">完了';
            else $list .= '<td'. $plusClass .' style="color:red;">未了';
            $list .= '<td'. $plusClass .'>'. $result["date"];
            $list .= '<td'. $plusClass .'>'. $result["user"];
            $list .= '<td'. $plusClass .'>'. $result["id"];
            $list .= '<td'. $plusClass .'>'. $result["name"];
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
