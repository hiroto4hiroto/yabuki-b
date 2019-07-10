<?php
//デバッグ状態か否か「0 or 1」1にすると無条件で予約できたりする
$debug = 0;
//日にちの設定　date("Y-m-d");　とすればリアルタイムになる
$getdate = '2019-07-20';//date("Y-m-d"); //'2019-07-19'
//予約・キャンセルの締切時間
$getclosetime = 15;
// データベース設定（サーバで公開するとき）
$dbServer = '127.0.0.1';
$dbUser = $_SERVER['MYSQL_USER'];
$dbPass = $_SERVER['MYSQL_PASSWORD'];
$dbName = $_SERVER['MYSQL_DB'];
# MySQL用のDSN文字列
$dsn = "mysql:host={$dbServer};dbname={$dbName};charset=utf8";
?>
