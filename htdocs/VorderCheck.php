<?php
session_start();
$isDebug = true;
    //業者でなければ弾く
if (!isset($_SESSION['VENDER'])) {
    header('Location: login.php');
    exit;
}
    try {
        //DBに接続
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);

        //一覧作成
        //SQL作成・実行
        $sql = 'SELECT * FROM ordertable ORDER BY date;';
        $prepare = $db->prepare($sql);
        $list = "";
        $prepare->execute();
        
        $list .= '<table style="width: 80vw; height: 2em;"><tr>';
        $list .= '<td style="width: 5vw;">受取';
        $list .= '<td style="width: 10vw;">日付';
        $list .= '<td style="width: 10vw;">学生番号';
        $list .= '<td style="width: 20vw;">弁当名';
        $list .= '<td style="width: 35vw;">UUID';

        foreach ($prepare->fetchAll(PDO::FETCH_ASSOC) as $result)
        {
            $list .= '<tr>';
            $list .= '<td>'. $result["check"];
            $list .= '<td>'. $result["date"];
            $list .= '<td>'. $result["user"];
            $list .= '<td>'. $result["name"];
            $list .= '<td>'. $result["QRid"];
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
        font-size:1.5vw;
        }
    -->
    </style>
</head>
 
<script language="javascript" type="text/javascript">
    function OnButtonClick(name) {
        var res = confirm('すべての予約を削除しますか？');
        if(res) {
            window.location.href =　location.href + '?delete=true';
        }
        else {
            alert('削除はされませんでした。');
        }
    }
</script>
    
<body style="background-color:#ffb;">
<p>弁当事前予約サービス</p>
<h1>予約数の確認</h1>
<?php echo $list; ?>

</body>
</html>
