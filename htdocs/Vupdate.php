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
        $sql = 'SELECT * FROM bentotable ORDER BY `view`, `date`, `price`, `name`;';
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
    <title>弁当事前予約サービス 弁当情報登録・更新</title>
     <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="vender">
<p>弁当事前予約サービス</p>
<h1>弁当情報登録・更新</h1>
<br>
<form method="post" action="Vupdate.php" enctype="multipart/form-data">
    <table>
        <tr><td><label for="view">弁当名</label>
            <td><input id="name" type="text" name="name">
        <tr><td><label for="view">販売表示</label>
            <td><input id="view" type="checkbox" name="view">
        <tr><td><label for="date">販売日</label>
            <td><input id="date" type="date" name="date">
        <tr><td><label for="price">価格</label>
            <td><input id="price" type="number" name="price">
        <tr><td><label for="stocks">販売数</label>
            <td><input id="stocks" type="number" name="stocks">
        <tr><td><label for="image">画像</label>
            <td><input id="image" type="file" accept="image/*.jpg">
    </table>
    <br>
    <input class="btn-sticky" type="submit" name="update" value="登録・更新">
</form>
<br>
<?php echo $list; ?>
 
</body>
</html>
