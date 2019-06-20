<?php
session_start();

$isDebug = true;

    //学生でなければ弾く
    if (!isset($_SESSION['USER'])) {
        header('Location: login.php');
        exit;
    }

    try {
        //DBに接続
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        
        //注文を受けたら
        if (isset($_GET['order'])) {
            //既に注文しているか確認
            $sql = "SELECT * FROM ordertable WHERE user = ". $_SESSION["USER"] ." AND date = '". $getdate ."' + INTERVAL 1 DAY limit 1;"; 
            $prepare = $db->prepare($sql);
            $prepare->execute();
            $result = $prepare->fetch(PDO::FETCH_ASSOC);
            
            $UUID = null;
            //既に1件注文していたら
            if (!empty($result)) $UUID = $result["QRid"];
            else $UUID = md5(uniqid(mt_rand(), true));
            

            //注文リストに一件追加
            $sql = "INSERT INTO `ordertable` (`check`, `date`, `user`, `name`, `QRid`)";
            $sql .= "VALUES (0, '". $getdate ."' + INTERVAL 1 DAY, '".$_SESSION['USER']."', '".$_GET['order']."', '".$UUID."');";
            $result = $db->prepare($sql);
            $result->execute();
        
            //トップページに移動
            header('Location: index.php?message='. $_GET['order'] .'を予約しました。');
            exit;
        }
        
        //一覧作成
        //SQL作成・実行
        $sql = 'select bento.id, bento.view, bento.date, bento.name, bento.price, bento.stocks, img.image';
        $sql .= 'from bentotable as bento right join imagetable as `img` on bento.id = img.id where bento.view = 1;';
        $sql .= 'SELECT * FROM bentotable;';
        $prepare = $db->prepare($sql);
        $list = "";
        $prepare->execute();
        
        foreach ($prepare->fetchAll(PDO::FETCH_ASSOC) as $result)
        {
            $list .= '<table style="width: calc(30vh + 15vw); height: calc(20vh + 10vw)">';
            $list .= '<tr style="width: 100%; height: 1.5em;">';
            $list .= '<td style="width: 70%;">販売日:'. $result["date"] .'';
            $list .= '<td style="width: 30%;">残り:'. $result["stocks"] .'個';
            $list .= '<tr style="width: 100%; height: 1.5em;">';
            $list .= '<td style="min-width: 70%;">'. $result["name"] .'';
            $list .= '<td style="max-width: 30%;">'. $result["price"] .'円';
            $list .= '<tr style="width: 100%; max-height: 100%;">';
            $list .= '<td style="min-width: 70%; background-image: url(\'data:image/jpeg;base64,'. base64_encode($result["image"]) .'\'); background-size: cover; background-position: center;">';
            //時間帯によって押せなくする
            if ($isDebug || date("G") < 15 && date("Y-m-d", strtotime("+1 day")) == $result["date"] ){
                $list .= '<td style="max-width: 30%;">';
                $list .= '<input type="button" class="btn-sticky" onclick="OnButtonClick(\''.$result["name"].'\');" ';
                $list .= 'value="予約する" style="width: 100%; height: 100%">';
            } else{
                $list .= '<td style="max-width: 30%;">';
                $list .= '<input type="button" class="btn-sticky" disabled);" ';
                $list .= 'value="予約不可" style="width: 100%; height: 100%">';
            }

            $list .= '</table><br>';
        }
    } catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }

?>
 
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>弁当事前予約サービス 弁当閲覧・予約</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style type="text/css">
    <!--
    tr td {border-style: solid;}
    -->
    </style>
    <script language="javascript" type="text/javascript">
    function OnButtonClick(name) {
        var res = confirm('「' + name + '」を予約しますか？');
        if(res) {
            //予約可能時間前か
            if (<?php echo $isDebug; ?> || new Date().getHours() < 15){
                window.location.href =　location.href + '?order=' + name;
            }else{
                alert('予約可能時間を過ぎたため予約できませんでした。');
                window.location.href =　location.href;
            }
        }
        else {
            alert('予約はされませんでした。');
        }
    }
</script>
</head>   
<body>
<p>弁当事前予約サービス</p>
<h1>弁当閲覧・予約</h1>

<?php echo $list; ?>
    
</body>
</html>
