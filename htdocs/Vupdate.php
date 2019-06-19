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
        
        //弁当一覧作成
        //SQL作成・実行
        $sql = 'SELECT * FROM bentotable ORDER BY `id`;';
        $prepare = $db->prepare($sql);
        $prepare->execute();
        
        $list .= '登録弁当一覧';
        $list .= '<br><table style="width: 80vw; height: 2em;"><tr>';
        $list .= '<td style="width: 5vw;">ID';
        $list .= '<td style="width: 10vw;">販売表示';
        $list .= '<td style="width: 15vw;">販売日';
        $list .= '<td style="width: 25vw;">弁当名';
        $list .= '<td style="width: 7vw;">価格';
        $list .= '<td style="width: 6vw;">販売数';
        $list .= '<td style="width: 10vw;">jpg画像';
        $list .= '<td style="width: 7vw;">削除';
        foreach ($prepare->fetchAll(PDO::FETCH_ASSOC) as $result)
        {
            $plusClass = '';
            if ($result["date"] == $getdate) $plusClass = ' class="todayOrder" ';
            
            $list .= '<tr>';
            $list .= '<td'. $plusClass .'>'. $result["id"];
            if ($result["view"] == 1)
                $list .= '<td'. $plusClass .'style="color:blue;">公開';
            else $list .= '<td'. $plusClass .' style="color:red;">未公開';
            $list .= '<td'. $plusClass .'>'. $result["date"];
            $list .= '<td'. $plusClass .'>'. $result["name"];
            $list .= '<td'. $plusClass .'>'. $result["price"];
            $list .= '<td'. $plusClass .'>'. $result["stocks"];
            $list .= '<td style=\'height:7.5vw; background-image:url("bentoimages/'.$result["name"].'.jpg"); background-size: cover;\'>';
            //削除ボタン
            $list .= '<td'. $plusClass .'>';
            $list .= '<input type="button" class="btn-sticky" onclick="OnButtonClick(\''.$result["id"].'\');" ';
            $list .= 'value="削除" style="width: 100%; height: 100%">';
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
    <script language="javascript" type="text/javascript">
    function OnButtonClick(id) {
        var res = confirm('ID ' + id + ' 番を削除しますか？');
        if(res) {
            window.location.href =　location.href + '?order=' + name;
        }
        else {
            alert('削除はされませんでした。');
        }
    }
</script>
</head>
<body class="vender">
<p>弁当事前予約サービス</p>
<h1>弁当情報登録・更新</h1>
<br>
    <p>新規IDを入力すると登録、既存IDを入力すると更新されます。</p>
<form method="post" action="Vupdate.php" enctype="multipart/form-data">
    <table>
        <tr><td><label for="id">ID*</label>
            <td><input id="id" type="number" name="id">
        <label for="name"><tr><td><弁当名</label>
            <td><input id="name" type="text" name="name">
        <tr><td><label for="view">販売表示</label>
            <td><input id="view" type="checkbox" name="view" checked="checked">
        <tr><td><label for="date">販売日</label>
            <td><input id="date" type="date" name="date" >
        <tr><td><label for="price">価格</label>
            <td><input id="price" type="number" name="price">
        <tr><td><label for="stocks">販売数</label>
            <td><input id="stocks" type="number" name="stocks">
        <tr><td><label for="image">画像</label>
            <td><input id="image" type="file" accept="image/*.jpg">
        <tr><td colspan="2"><input class="btn-sticky" type="submit" name="update" value="登録・更新" style"width: 50vw;">
    </table>
</form>
<br>
<?php echo $list; ?>
 
</body>
</html>
