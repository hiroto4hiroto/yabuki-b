<?php
$debug = 0;
$getdate = '2019-07-19';//date("Y-m-d"); //'2019-07-19'
// データベース設定（サーバで公開するとき）
$dbServer = '127.0.0.1';
$dbUser = $_SERVER['MYSQL_USER'];
$dbPass = $_SERVER['MYSQL_PASSWORD'];
$dbName = $_SERVER['MYSQL_DB'];
# MySQL用のDSN文字列
$dsn = "mysql:host={$dbServer};dbname={$dbName};charset=utf8";
?>
