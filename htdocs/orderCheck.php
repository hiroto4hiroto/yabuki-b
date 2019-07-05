<?php
session_start();
$list = "";
    //学生でなければ弾く
if (!isset($_SESSION['USER'])) {
    header('Location: login.php');
    exit;
}
    try {
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);

//取消を受けたら
if (isset($_GET['cansel'])) {
    //15時以降、日付が明日でない　場合は取消できない
    $sql = "SELECT * FROM `ordertable` WHERE id = ". (string)$_GET['cansel'] ." limit 1;";
    $prepare = $db->prepare($sql);
    $prepare->execute();
    $resultCheckStock = $prepare->fetch(PDO::FETCH_ASSOC);
    if (date("G") >= $getclosetime ||
        strtotime($result["date"]) >= strtotime(date( "Y-m-d", strtotime($getdate ." + 1 day")) )
       ){
        //トップページに移動
        header('Location: index.php?message=取消時間外等の理由により取り消しできませんでした。');
        exit;
    }
    
    //注文リストを一件削除
    $sql = "DELETE FROM `ordertable` WHERE id = ". (string)$_GET['cansel'] ." limit 1;";
    $result = $db->prepare($sql);
    $result->execute();
    //弁当の在庫を増やす
    $db = new PDO($dsn, $dbUser, $dbPass);
    $sql = "UPDATE `bentotable` SET stocks = stocks + 1 WHERE id = ". (string)$_GET['cansel'];
    $result = $db->prepare($sql);
    $result->execute();

    //トップページに移動
    header('Location: index.php?message=1件の予約を取り消しました。');
    exit;
}

        //予約一覧作成
        //SQL作成・実行
        $sql = "SELECT order.check, bento.date, bento.name, bento.price, bento.id FROM ordertable as `order` ";
        $sql .= "LEFT OUTER JOIN bentotable as `bento` ON order.id = bento.id WHERE user = ". $_SESSION['USER'] ." ORDER BY `date`, `check`, name;";
        $prepare = $db->prepare($sql);
        $prepare->execute();
        
        $sum = 0;
        $list .= '予約一覧';
        $list .= '<br><table style="width: 80vw; height: 2em;"><tr>';
        $list .= '<td style="width: 10vw;">受取';
        $list .= '<td style="width: 15vw;">日付';
        $list .= '<td style="width: 30vw;">弁当名';
        $list .= '<td style="width: 15vw;">値段';
        $list .= '<td style="width: 10vw;">取消';
        foreach ($prepare->fetchAll(PDO::FETCH_ASSOC) as $result)
        {
            $list .= '<tr>';
            if ($result["check"] == 0)
            {
                $list .= '<td style="color:red;">未了';
                $sum += $result["price"];
            }  
            else $list .= '<td style="color:blue;">完了';
            $list .= '<td>'. $result["date"];
            $list .= '<td>'. $result["name"];
            if ($result["check"] == 0)
                $list .= '<td style="color:red;">'. $result["price"] .'円';
            else
                $list .= '<td style="color:blue;">'. $result["price"] .'円';
            
            //15時前で前日であれば取り消し可能にする
            if ($debug || date("G") < $getclosetime && $result["date"] == date( "Y-m-d", strtotime( $getdate ." + 1 day" ) ) )
            {
                $list .= '<td><input type="button" class="btn-sticky" onclick="OnButtonClick(\''.$result["id"].'\');" ';
                $list .= 'value="取消" style="width: 100%; height: 100%"></input>';
            } else {
                $list .= '<td><input type="button" class="btn-sticky" disabled);" ';
                $list .= 'value="不可" style="width: 100%; height: 100%"></input>';
            }
            
        }
        $list .= '<tr><td colspan="3" style="border-style:none;">';
        $list .= '<td style="color:red;">未了合計金額<br>'.$sum.'円';
        $list .= '</table>';
    }
    catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>弁当事前予約サービス 予約確認</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
 
<script language="javascript" type="text/javascript">
    function OnButtonClick(id) {
        var res = confirm('予約を取り消しますか？');
        if(res) {
            //予約可能時間前か
            if (new Date().getHours() < <?php echo $getclosetime; ?>){
                window.location.href = location.href + '?cansel=' + id;
            }else{
                window.location.href = 'http://yabukib.pm-chiba.tech/index.php?message=取り消し可能時間を過ぎたため予約できませんでした。';
            }
        }
        else {
            alert('取り消しはされませんでした。');
        }
    }
</script>
    
<body>
<p>弁当事前予約サービス</p>
<h1>予約確認・取消</h1>
<p>あなたの予約した弁当は下記の通りです。</p>
<?php echo $list; ?>
<hr>
<p>取り消し可能時間は前日の<?php echo $getclosetime; ?>:00までとなります。</p>
</body>
</html>
