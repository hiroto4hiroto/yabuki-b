<?php
session_start();
$list = "";
    try {
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);   
        
        if( !empty($_POST['runsql']) && !empty($_POST['sqltext']) )
        {
            $sql = $_POST['sqltext'];
            $prepare = $db->prepare($sql);
            $prepare->execute();
            $db = new PDO($dsn, $dbUser, $dbPass);
        }
        
        $sql = "SELECT * FROM `logintable` ORDER BY user;";
        $prepare = $db->prepare($sql);
        $prepare->execute();
        
        $list .= 'アカウント一覧<br>logintable';
        $list .= '<br><table style="width: 80vw; height: 2em;"><tr>';
        $list .= '<td style="width: 5vw;">学生番号<br>user';
        $list .= '<td style="width: 5vw;">パスワード<br>password';
        $list .= '<td style="width: 5vw;">ペナルティ解除日<br>resumeDate';
        foreach ($prepare->fetchAll(PDO::FETCH_ASSOC) as $result)
        {
            $list .= '<tr>';
            $list .= '<td>'. $result["user"];
            $list .= '<td>'. $result["password"];
            $list .= '<td>'. $result["resumeDate"];
        }
        $list .= '</table><br>';
        
        
        $sql = "SELECT * FROM `bentotable` ORDER BY id;";
        $prepare = $db->prepare($sql);
        $prepare->execute();
        
        $list .= '登録弁当一覧<br>bentotable';
        $list .= '<br><table style="width: 80vw; height: 2em;"><tr>';
        $list .= '<td style="width: 5vw;">ID<br>id';
        $list .= '<td style="width: 10vw;">販売表示<br>view';
        $list .= '<td style="width: 15vw;">販売日<br>date';
        $list .= '<td style="width: 25vw;">弁当名<br>name';
        $list .= '<td style="width: 7vw;">価格<br>price';
        $list .= '<td style="width: 6vw;">販売数<br>stocks';
        foreach ($prepare->fetchAll(PDO::FETCH_ASSOC) as $result)
        {
            $list .= '<tr>';
            $list .= '<td>'. $result["id"];
            if ($result["view"] == 1)
                $list .= '<td style="color:blue;">'. $result["view"];
            else $list .= '<td style="color:red;">'. $result["view"];
            $list .= '<td>'. $result["date"];
            $list .= '<td>'. $result["name"];
            $list .= '<td>'. $result["price"];
            $list .= '<td>'. $result["stocks"];
        }
        $list .= '</table><br>';
        
        
        $sql = "SELECT * FROM `ordertable` ORDER BY user;";
        $prepare = $db->prepare($sql);
        $prepare->execute();
        
        $list .= '予約一覧<br>ordertable';
        $list .= '<br><table style="width: 80vw; height: 2em;"><tr>';
        $list .= '<td style="width: 5vw;">受取<br>check';
        $list .= '<td style="width: 10vw;">学生番号<br>user';
        $list .= '<td style="width: 10vw;">弁当番号<br>id';
        $list .= '<td style="width: 35vw;">UUID<br>QRid';
        foreach ($prepare->fetchAll(PDO::FETCH_ASSOC) as $result)
        {
            $list .= '<tr>';
            if ($result["check"] == 1)
                $list .= '<td style="color:blue;">'. $result["check"] ;
            else $list .= '<td style="color:red;">'. $result["check"] ;
            $list .= '<td>'. $result["user"];
            $list .= '<td>'. $result["id"];
            $list .= '<td>'. $result["QRid"];
        }
        $list .= '</table><br>';
    } catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>弁当事前予約サービス デバッグ用　テーブル一覧</title>
     <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style="background-color: #000; color:#fff;">
<p>弁当事前予約サービス デバッグ用　テーブル一覧</p>
<br>
<form method="post" action="debug.php">
    SQL：
    <input type="text" id="sqltext" name="sqltext">
    <input class="btn-sticky" type="submit" name="runsql" value="画面の更新 and SQLを実行">
</form>
    <br>状態<br>
    <?php
        echo $getclosetime .'　｜'.$getdate .'　｜';
        if ($debug == 1) echo 'デバッグ状態　｜';
        else echo '本番状態　｜';    
        echo '<a href="https://github.com/yabukilab/yabuki-b/blob/master/htdocs/database_conf.php">変更</a><br>';
    ?>    
    <br>
    <?php echo $list; ?>
    <br>
    //更新の例<br>
    UPDATE テーブル名 SET price = 400 WHERE name = 'B弁当';<br>
    //追加の例<br>
    INSERT INTO `ordertable` (`check`, `user`, `id`, `QRid`) VALUES (0, '1742120', 1, 'hogeeee');<br>
    //削除<br>
    DELETE FROM `テーブル名` WHERE name = 'B弁当';<br>
</body>
</html>
