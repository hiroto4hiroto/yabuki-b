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
        $sql = 'SELECT ordertable.check as `check`, ordertable.date as `date`, ordertable.name as `name`, bentotable.price as `price`';
        $sql .= ' FROM ordertable WHERE INNER JOIN bentotable ON ordertable.name = bentotable.name AND user = '. $_SESSION['USER'];
        $prepare = $db->prepare($sql);
        $prepare->execute();
        
        $list .= '予約一覧';
        $list .= '<br><table style="width: 80vw; height: 2em;"><tr>';
        $list .= '<td style="width: 10vw;">受取済';
        $list .= '<td style="width: 15vw;">日付';
        $list .= '<td style="width: 35vw;">弁当名';
        $list .= '<td style="width: 20vw;">値段';
        foreach ($prepare->fetchAll(PDO::FETCH_ASSOC) as $result)
        {
            $list .= '<tr>';
            $list .= '<td class="orderText">'. $result["check"];
            $list .= '<td class="orderText">'. $result["date"];
            $list .= '<td class="orderText">'. $result["name"];
            $list .= '<td class="orderText">'. $result["price"];
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
    <title>弁当事前予約サービス 予約確認・キャンセル</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style type="text/css">
    <!--
    tr td {border-style: solid;}
    -->
    </style>
</head>
 
<script language="javascript" type="text/javascript">
    function OnButtonClick(name) {
        var res = confirm('「' + name + '」を予約しますか？');
        if(res) {
            //予約可能時間前か
            if (new Date().getHours() < 15){
                window.location.href =　location.href + '?order=' + name;
            }else{
                alert('予約可能時間を過ぎたため予約できませんでした。');
                window.location.href =　location.href + '?order=' + name;
            }
        }
        else {
            alert('予約はされませんでした。');
        }
    }
</script>
    
<body>
<p>弁当事前予約サービス</p>
<h1>予約確認・キャンセル</h1>
<p>あなたの予約した弁当はこちらになります。</p>
<?php echo $list; ?>
<hr>
<p>キャンセル可能時間は前日の15:00までとなります．</p>
</body>
</html>
