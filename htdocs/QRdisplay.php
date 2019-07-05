<?php
session_start();

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
        $sql = "SELECT order.check, bento.date, bento.name, bento.price, bento.id, order.QRid FROM ordertable as `order` ";
        $sql .= "LEFT OUTER JOIN bentotable as `bento` ON order.id = bento.id WHERE user = ". $_SESSION['USER'] ." AND date = '".$getdate."' ORDER BY `date`, name;";
        $prepare = $db->prepare($sql);
        $prepare->execute();
        
	$uuid = '';
        $sum = 0;
        $list = '予約一覧';
        $list .= '<br><table style="width: 80vw; height: 2em;"><tr>';
        $list .= '<td style="width: 30vw;">弁当名';
        foreach ($prepare->fetchAll(PDO::FETCH_ASSOC) as $result)
        {
		$uuid = $result["QRid"];
            $list .= '<tr>';
            $list .= '<td>'. $result["name"];
	    $list .= '<td>'. $result["QRid"];
        }
        $list .= '<tr><td colspan="3" style="border-style:none;">';
        $list .= '<td style="color:red;">未了合計金額<br>'.$sum.'円';
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
    <title>弁当事前予約サービス トップページ</title>
    <link rel="stylesheet" type="text/css" href="style.css">	
</head>
 
<body>
<p>弁当事前予約サービス</p>
<h1>QRコード表示</h1>
<br>

<div id="QRview"></div>
<?php $list; ?>

</body>
<script type="text/javascript">
	document.getElementById("QRview").innerHTML =
		'<img src="https://chart.apis.google.com/chart?chs=512x512&cht=qr&chl=<?php echo $uuid;?>" width="80%">';
</script>
</html>
