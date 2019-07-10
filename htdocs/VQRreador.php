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
        
	//引き渡し処理
        $isCheck = 0;
        $QRid = "";
        if( !empty($_GET['QRid']) || isset($_POST['delivery']) ){
            $isCheck = 1;

            //引き渡し完了に更新
            $sql = 'UPDATE `ordertable` LEFT JOIN bentotable ON `ordertable`.id = bentotable.id';
            if (!empty($_GET['QRid']) )
                $sql .= ' SET `ordertable`.check = 1 WHERE `ordertable`.QRid = "'. $_GET["QRid"] .'";';
            else
                $sql .= ' SET `ordertable`.check = 1 WHERE `ordertable`.user = "'. $_POST["user"] .'" and bentotable.date = "'. $getdate .'";';
            $prepare = $db->prepare($sql);
            $prepare->execute();
            $db = new PDO($dsn, $dbUser, $dbPass);
            
            //表示するレコードのQRidを設定
            if (!empty($_GET['QRid'])) $QRid = $_GET['QRid'];
            else {
                $sql = 'SELECT QRid FROM `ordertable` LEFT JOIN bentotable ON `ordertable`.id = bentotable.id';
                $sql .= ' SET `ordertable`.check = 1 WHERE `ordertable`.user = "'. $_POST["user"] .'" and bentotable.date = "'. $getdate .'" limit 1;';
                $prepare = $db->prepare($sql);
                $prepare->execute();
                $QRid = $prepare->fetch(PDO::FETCH_ASSOC);
            }
        }
	
	if ($isCheck == 1){
            //引き渡し完了一覧作成
            //SQL作成・実行
            $sql = "SELECT `order`.QRid as `QRid`, `order`.check as `check`, `bento`.date as `date`, `order`.user as `user`, `order`.id as `id`, `bento`.name as `name`";
            $sql .= " FROM `ordertable` as `order` LEFT JOIN `bentotable` as `bento` ON `order`.id = `bento`.id";
            $sql .= " WHERE `order`.QRid = '". $QRid ."'";
            $sql .= " ORDER BY `order`.check, `bento`.date, `order`.user, `order`.id;";
            $prepare = $db->prepare($sql);
            $emptyCheck = $prepare->execute();
		    
            //念のため、更新数が1以上か確認
            if (mysql_num_rows($prepare->execute()->fetchAll(PDO::FETCH_ASSOC)) > 0)
            {
                $list .= '下記の注文を引き渡し完了にしました';
                $list .= '<br><table style="width: 80vw; height: 2em;"><tr>';
                $list .= '<td style="width: 5vw;">受取';
                $list .= '<td style="width: 10vw;">日付';
                $list .= '<td style="width: 10vw;">学生番号';
                $list .= '<td style="width: 20vw;">弁当名';
                //$list .= '<td style="width: 35vw;">UUID';
                foreach ($prepare->fetchAll(PDO::FETCH_ASSOC) as $result)
                {
                    $list .= '<tr>';
                    $list .= '<td class="todayOrder" style="color:blue;">完了';
                    $list .= '<td class="todayOrder">'. $result["date"];
                    $list .= '<td class="todayOrder">'. $result["user"];
                    $list .= '<td class="todayOrder">'. $result["name"];
                }
                $list .= '</table>';
            }
            else {
                $list .= '入力に対応する予約がありませんでした。<br>入力内容が正しいか確認してください。<br>';
            }
        }
        
        
        //予約一覧作成
        //SQL作成・実行
        $sql = "SELECT `order`.check as `check`, `bento`.date as `date`, `order`.user as `user`, `order`.id as `id`, `bento`.name as `name`";
        $sql .= " FROM `ordertable` as `order` LEFT JOIN `bentotable` as `bento` ON `order`.id = `bento`.id";
        $sql .= " ORDER BY `order`.check, `bento`.date, `order`.user, `order`.id;";
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
            $plusClass = '';
            if ($result["date"] == $getdate) $plusClass = ' class="todayOrder" ';
                
            $list .= '<tr>';
            if ($result["check"] == 1)
                $list .= '<td'. $plusClass .' style="color:blue;">完了';
            else $list .= '<td'. $plusClass .' style="color:red;">未了';
            $list .= '<td'. $plusClass .'>'. $result["date"];
            $list .= '<td'. $plusClass .'>'. $result["user"];
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
    <meta charset="utf-8" />
    <title>弁当事前予約サービス 引き渡し操作</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body class="vender">
    <p>弁当事前予約サービス</p>
    <h1>引き渡し操作</h1>
    <input type="button" class="btn-sticky" onclick="location.href='./Vindex.php'" value="トップページに戻る"><br><br>
    <form method="post" action="VQRreador.php">
    <table>
        <tr>
            <td colspan="3">
                <label class="btn-sticky" style="height: calc(var(--fontRatio) * 7.5);"><br>QRコードを撮影&引渡<br>
                    <input style="display:none;" type="file" accept="image/*" capture="environment" onchange="openQRCamera(this);" /><br>
        <tr>
            <td><label style="width: 15vw;" for="user">学生番号</label>
            <td><input style="width: 25vw;" id="user" style="width: 25vw;" type="text" name="user" maxlength="7">
            <td><input style="width: 40vw;" class="btn-sticky" type="submit" name="delivery" value="引き渡し">
    </table>
    </form>
    </label>
	    
	    <label class="btn-sticky" style="height: calc(var(--fontRatio) * 7.5);"><br>QRコードを撮影&引渡<br>
                    <input style="display:none;" type="file" accept="image/*" capture="environment" onchange="openQRCamera(this);" /><br>

    <script type="text/javascript" charset="utf-8">
        function openQRCamera(node) {
            var reader = new FileReader();
            reader.onload = function () {
                node.value = "";
                qrcode.callback = function (res) {
                    if (res instanceof Error) {
                        alert("QRコードを認識できませんでした。");
                    } else {
                        //QR読み込み成功
                        alert("QRコードを認識しました。");
                        window.location.href = location.href + '?QRid=' + res;
                    }
                };
                qrcode.decode(reader.result);
            };
            reader.readAsDataURL(node.files[0]);
        }
    </script>

    <br>
    <?php echo $list; ?>
</body>

</html>
