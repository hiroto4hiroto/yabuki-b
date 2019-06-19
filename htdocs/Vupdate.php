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
       
        //該当番号を1件削除
        if (isset($_GET['delete'])) {
            $db = new PDO($dsn, $dbUser, $dbPass);
            $sql = "DELETE FROM `bentotable` where id = ". $_GET['delete'];
            $result = $db->prepare($sql);
            $result->execute();
        
            //トップページに移動
            header('Location: index.php?message=弁当ID '. $_GET['order'] .' 番を削除しました。');
            exit;
        }

        if (isset($_POST['update']) && $_POST['id'] != null)
        {
            $message = "";
            //番号のレコードがない場合、新規作成
            $db = new PDO($dsn, $dbUser, $dbPass);
            $sql = 'SELECT * FROM bentoTable WHERE bento = '. $_POST['id'];
            $prepare = $db->prepare($sql);
            $prepare->execute();
            if ($prepare->fetch(PDO::FETCH_ASSOC) == null)
            {
                $sql = 'INSERT INTO bentotable (`id`, `view`, `date`, `name`, `price`, `stocks`) VALUES ( '.$_POST["id"].', 0, "noName", 9999, 0)';
                $sql .= 'INSERT INTO imagetable (`id`, `image`) VALUES ('.$_POST["id"].', 0)';
                $prepare = $db->prepare($sql);
                $prepare->execute();
                $message .= "1件追加しました<br>";
            }
            //販売日の更新
            if ($_POST['date'])
            {
                $db = new PDO($dsn, $dbUser, $dbPass);
                $sql = 'UPDATE bentoTable SET date = "'.$_POST["date"].'" WHERE bento = '. $_POST['id'];
                $prepare = $db->prepare($sql);
                $prepare->execute();
                $message .= "販売日を更新しました<br>";
            }
            //弁当名の更新
            if ($_POST['name'] != "")
            {
                $db = new PDO($dsn, $dbUser, $dbPass);
                $sql = 'UPDATE bentoTable SET name = "'.$_POST["name"].'" WHERE bento = '. $_POST['id'];
                $prepare = $db->prepare($sql);
                $prepare->execute();
                $message .= "名前を更新しました<br>";
            }
            //価格の更新
            if ($_POST['price'] != null)
            {
                $db = new PDO($dsn, $dbUser, $dbPass);
                $sql = 'UPDATE bentoTable SET price = '.$_POST["price"].' WHERE bento = '. $_POST['id'];
                $prepare = $db->prepare($sql);
                $prepare->execute();
                $message .= "価格を更新しました<br>";
            }
            //在庫数の更新
            if ($_POST['stocks'] != null)
            {
                $db = new PDO($dsn, $dbUser, $dbPass);
                $sql = 'UPDATE bentoTable SET stocks = '.$_POST["stocks"].' WHERE bento = '. $_POST['id'];
                $prepare = $db->prepare($sql);
                $prepare->execute();
                $message .= "在庫数を更新しました<br>";
            }

            //jpeg形式でエラーがなければ画像を保存
            $raw_data = file_get_contents($_FILES['upfile']['tmp_name']);
            $tmp = pathinfo($_FILES["image"]["name"]);
            $extension = $tmp["extension"];
            if ($_FILES['image']['tmp_name'] != null && $_FILES['image']['error'] == UPLOAD_ERR_OK &&
                $extension === "jpg" || $extension === "jpeg" || $extension === "JPG" || $extension === "JPEG")
            {
                $db = new PDO($dsn, $dbUser, $dbPass);                
                $sql = "UPDATE INTO imagetable (`id, `image`) VALUES (". $_POST['id'] .", :raw_data);";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":raw_data", $raw_data, PDO::PARAM_STR);
                $stmt->execute();
                
                $message .= "画像を更新しました<br>";
            } else {
                $message .= "画像は何らかの理由で更新できませんでした<br>";
            }
        }
        
        //弁当一覧作成
        //SQL作成・実行
        $db = new PDO($dsn, $dbUser, $dbPass);
        $sql = 'SELECT * FROM bentotable ORDER BY id;';
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
        $list .= '<td style="width: 10vw;">jpg画像<br>1.6MBまで';
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
            $list .= '<td style=\'height:7.5vw; background-image:url("bentoimages/'.$result["id"].'.jpg"); background-size: cover;\'>';
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
        var res = confirm('弁当ID ' + id + ' 番を削除しますか？');
        if(res) {
            window.location.href =　location.href + '?delete=' + name;
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
<p>新規IDを入力すると登録、既存IDを入力すると更新されます。</p>
<form method="post" action="Vupdate.php" enctype="multipart/form-data">
    <table  style="width: 50vw;">
        <tr><td><label for="id">ID*</label>
            <td><input id="id" type="number" name="id" value="0">
        <label for="name"><tr><td>弁当名</label>
            <td><input id="name" type="text" name="name">
        <tr><td><label for="view">販売表示</label>
            <td><input id="view" type="checkbox" name="view" checked="checked">
        <tr><td><label for="date">販売日</label>
            <td><input id="date" type="date" name="date">
        <tr><td><label for="price">価格</label>
            <td><input id="price" type="number" name="price">
        <tr><td><label for="stocks">販売数</label>
            <td><input id="stocks" type="number" name="stocks">
        <tr><td><label for="image">jpg画像<br>1.6MBまで</label>
            <td><input id="image" type="file" name="image" accept="image/*.jpg">
        <tr><td colspan="2"><input class="btn-sticky" type="submit" name="update" value="登録・更新" style="width: 100%;">
    </table>
</form>
<br>
<?php echo $list; ?>
<br>
</body>
</html>
