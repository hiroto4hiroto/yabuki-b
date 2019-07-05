<?php
session_start();
$message = "";

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
        $sql = "SELECT * FROM ordertable WHERE user = ". $_SESSION['USER'] ." limit 1;";
        $prepare = $db->prepare($sql);
        $prepare->execute();
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        
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

<div id="QRview" style="height:50vh;"></div>

</body>
<script type="text/javascript">
	document.getElementById("QRview").innerHTML = '<img src="https://chart.apis.google.com/chart?chs=' +
		window.innerHeight * 0.8 + 'x' + window.innerHeight * 0.8 +
		'&cht=qr&chl=<?php echo $result["QRid"];?>>';
</script>
</html>
