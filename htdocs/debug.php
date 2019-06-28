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
        
        $list .= 'アカウント一覧';
        $list .= '<br><table style="width: 80vw; height: 2em;"><tr>';
        $list .= '<td style="width: 5vw;">学生番号';
        $list .= '<td style="width: 5vw;">パスワード';
        $list .= '<td style="width: 5vw;">ペナルティ解除日';
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
        
        $list .= '登録弁当一覧';
        $list .= '<br><table style="width: 80vw; height: 2em;"><tr>';
        $list .= '<td style="width: 5vw;">ID';
        $list .= '<td style="width: 10vw;">販売表示';
        $list .= '<td style="width: 15vw;">販売日';
        $list .= '<td style="width: 25vw;">弁当名';
        $list .= '<td style="width: 7vw;">価格';
        $list .= '<td style="width: 6vw;">販売数';
        foreach ($prepare->fetchAll(PDO::FETCH_ASSOC) as $result)
        {
            $list .= '<tr>';
            $list .= '<td>'. $result["id"];
            if ($result["view"] == 1)
                $list .= '<td style="color:blue;">公開';
            else $list .= '<td style="color:red;">未公開';
            $list .= '<td>'. $result["date"];
            $list .= '<td>'. $result["name"];
            $list .= '<td>'. $result["price"];
            $list .= '<td>'. $result["stocks"];
        }
        $list .= '</table><br>';
        
        
        $sql = "SELECT * FROM `ordertable` ORDER BY user;";
        $prepare = $db->prepare($sql);
        $prepare->execute();
        
        $list .= '予約一覧';
        $list .= '<br><table style="width: 80vw; height: 2em;"><tr>';
        $list .= '<td style="width: 5vw;">受取';
        $list .= '<td style="width: 10vw;">学生番号';
        $list .= '<td style="width: 10vw;">弁当番号';
        $list .= '<td style="width: 35vw;">UUID';
        foreach ($prepare->fetchAll(PDO::FETCH_ASSOC) as $result)
        {
            $list .= '<tr>';
            if ($result["check"] == 1)
                $list .= '<td style="color:blue;">完了';
            else $list .= '<td style="color:red;">未了';
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
<p>SQL</p>
<form method="post" action="debug.php">
    <!--
        <input type="text" name="sqltext" style="width:80vw; height:25vh;">
    -->
    <TEXTAREA rows="10" cols="50" name="body"></TEXTAREA>
    <input class="btn-sticky" type="submit" name="runsql" value="SQLを実行">
</form>
<br>
    <?php echo $list; ?>
<br>
</body>
</html>
