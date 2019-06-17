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
        $sql = 'SELECT * FROM bentotable ORDER BY `view`, `date`, `price`, `name`;';
        $prepare = $db->prepare($sql);
        $prepare->execute();
        
        $list .= '登録弁当一覧';
        $list .= '<br><table style="width: 80vw; height: 2em;"><tr>';
        $list .= '<td style="width: 10vw;">販売表示';
        $list .= '<td style="width: 15vw;">販売日';
        $list .= '<td style="width: 25vw;">弁当名';
        $list .= '<td style="width: 10vw;">価格';
        $list .= '<td style="width: 10vw;">在庫';
        $list .= '<td style="width: 10vw;">jpg画像';
        foreach ($prepare->fetchAll(PDO::FETCH_ASSOC) as $result)
        {
            $plusClass = '';
            if ($result["date"] == $getdate) $plusClass = ' class="todayOrder" ';
            
            $list .= '<tr>';
            if ($result["view"] == 1)
                $list .= '<td'. $plusClass .'style="color:blue;">公開';
            else $list .= '<td'. $plusClass .' style="color:red;">未公開';
            $list .= '<td'. $plusClass .'>'. $result["date"];
            $list .= '<td'. $plusClass .'>'. $result["name"];
            $list .= '<td'. $plusClass .'>'. $result["price"];
            $list .= '<td'. $plusClass .'>'. $result["stocks"];
            $list .= '<td style=\'height:7.5vw; background-image:url("bentoimages/'.$result["name"].'.jpg"); background-size: cover;\'>';
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
        <label for="name"><tr><td><弁当名</label>
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
