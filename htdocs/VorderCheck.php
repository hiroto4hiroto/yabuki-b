<?php
session_start();
    //業者でなければ弾く
if (!isset($_SESSION['VENDER'])) {
    header('Location: login.php');
    exit;
}
    try {
        require_once 'database_conf.php';
        //DBに接続
        $db = new PDO($dsn, $dbUser, $dbPass);
        //今日までの予約リストを削除
        if (isset($_GET['delete'])) {
            $sql = "DELETE FROM `ordertable` WHERE date <= '". $getdate ."'; ";
            $prepare = $db->prepare($sql);
            $prepare->execute();
            header('Location: Vindex.php?message=今日までの予約リストを削除しました');
        }
        $list = "";

        //数量一覧作成
        //SQL作成・実行
        //$sql = 'SELECT date, name, count(name) as `count` FROM ordertable GROUP BY date, name ORDER BY date;';
        $sql = 'select bento.id as id, bento.date as date, bento.name as name, count(name) as `count` ';
        $sql .= 'from bentotable as bento right join ordertable as `order` on bento.id = `order`.id GROUP BY id;';
        $prepare = $db->prepare($sql);
        $prepare->execute();
        
        $list .= '各弁当の予約数';
        $list .= '<br><table style="width: 80vw; height: 2em;"><tr>';
        $list .= '<td style="width: 15vw;">ID';
        $list .= '<td style="width: 15vw;">日付';
        $list .= '<td style="width: 30vw;">弁当名';
        $list .= '<td style="width: 20vw;">個数';

        foreach ($prepare->fetchAll(PDO::FETCH_ASSOC) as $result)
        {         
             $plusClass = '';
            if ($result["date"] == $getdate) $plusClass = ' class="todayOrder" ';
            
            $list .= '<tr>';
            $list .= '<td'. $plusClass .'>'. $result["id"];
            $list .= '<td'. $plusClass .'>'. $result["date"];
            $list .= '<td'. $plusClass .'>'. $result["name"];
            $list .= '<td'. $plusClass .'>'. $result["count"];
        }
        $list .= '</table>';
        
        
        //予約一覧作成
        //SQL作成・実行
        //$sql = 'SELECT * FROM ordertable ORDER BY date;';
        $sql = 'select `order`.id as `id`, `order`.check as `check`, bento.date as date, `order`.user as user, bento.name as name, `order`.QRid as QRid ';
        $sql .= 'from bentotable as bento right join `ordertable` as `order` on bento.id = `order`.id order by `order`.user;';
        $prepare = $db->prepare($sql);
        $prepare->execute();
        
        $list .= '予約一覧';
        $list .= '<br><table style="width: 80vw; height: 2em;"><tr>';
        $list .= '<td style="width: 5vw;">ID';
        $list .= '<td style="width: 5vw;">受取';
        $list .= '<td style="width: 10vw;">日付';
        $list .= '<td style="width: 10vw;">学生番号';
        $list .= '<td style="width: 20vw;">弁当名';
        $list .= '<td style="width: 30vw;">UUID';

        foreach ($prepare->fetchAll(PDO::FETCH_ASSOC) as $result)
        {
            $plusClass = '';
            if ($result["date"] == $getdate) $plusClass = ' class="todayOrder" ';

            $list .= '<tr>';
            $list .= '<td'. $plusClass .'>'. $result["id"];
            if ($result["check"] == 1)
                $list .= '<td'. $plusClass .' style="color:blue;">完了';
            else $list .= '<td'. $plusClass .' style="color:red;">未了';
            $list .= '<td'. $plusClass .'>'. $result["date"];
            $list .= '<td'. $plusClass .'>'. $result["user"];
            $list .= '<td'. $plusClass .'>'. $result["name"];
            $list .= '<td'. $plusClass .' style="width: 30vw; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">'. $result["QRid"];
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
    <title>弁当事前予約サービス 予約数の確認</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style type="text/css">
    <!--
    tr td {
        border-style: solid;
        }
        
    .orderText {
        font-size:1.5vw;
        }
    -->
    </style>
</head>
 
<script language="javascript" type="text/javascript">
    function OnButtonClick() {
        var res = confirm('今日までの予約を削除しますか？');
        if(res) {
            window.location.href = 'http://yabukib.pm-chiba.tech/VorderCheck.php?delete=true';
        }
        else {
            alert('削除はされませんでした。');
        }
    }
</script>
    
<body class="vender">
<p>弁当事前予約サービス</p>
<h1>予約数の確認</h1>

<?php if(isset($_GET['delete'])) echo '<p>今日までの予約を削除しました</p><br>'; ?>
<?php echo $list; ?>
<input type="button" class="btn-sticky" onclick="OnButtonClick();" value="今日までの予約を削除">
</body>
    
</html>
