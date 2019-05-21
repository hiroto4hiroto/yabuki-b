<?php
// データベース設定（ローカルで開発するとき）
$dbServer = '127.0.0.1';
$dbUser = 'test';
$dbPass = 'pass';
$dbName = 'yabukib';
# MySQL用のDSN文字列です。
$dsn = "mysql:host={$dbServer};dbname={$dbName};charset=utf8";
?>