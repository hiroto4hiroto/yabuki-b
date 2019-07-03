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
        
        //予約一覧作成
        //SQL作成・実行
        $sql = "SELECT order.check, bento.date, bento.name, bento.price, bento.id FROM ordertable as `order` ";
        $sql .= "LEFT OUTER JOIN bentotable as `bento` ON order.id = bento.id WHERE user = ". $_SESSION['USER'];
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
            if ($debug || date("G") < 15 && $result["date"] == date( "Y-m-d", strtotime( $getdate ." + 1 day" ) ) )
            {
                $list .= '<td><input type="button" class="btn-sticky" onclick="OnButtonClick(\''.$result["id"].'\');" ';
                $list .= 'value="取消" style="width: 100%; height: 100%"></input>';
            } else {
                $list .= '<td><input type="button" class="btn-sticky" disabled);" ';
                $list .= 'value="不可" style="width: 100%; height: 100%"></input>';
            }
            
        }
        $list .= '</table><table><tr><td style="border-style:none;">';
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
    function OnButtonClick(name) {
        var res = confirm('「' + name + '」の予約を取り消しますか？');
        if(res) {
            //予約可能時間前か
            if (new Date().getHours() < 15){
                window.location.href =　location.href + '?order=' + name;
            }else{
                alert('取り消し可能時間を過ぎたため予約できませんでした。');
                window.location.href =　location.href + '?order=' + name;
            }
        }
        else {
            alert('取り消しはされませんでした。');
        }
    }
</script>
    
<body>
<p>弁当事前予約サービス</p>
<h1>予約確認</h1>
<p>あなたの予約した弁当はこちらになります。</p>
<?php echo $list; ?>
<hr>
<p>取り消し可能時間は前日の15:00までとなります。</p>
</body>
</html>
