<?php
    session_start();
 
    // 変数の初期化
    $sql = null;
    $result = null;
    $db = null;
    $message = '';

    //ログイン済み
    if (isset($_SESSION['USER'])) {
        header('Location: index.php');
        exit;
    } else if (isset($_SESSION['VENDER'])) {
        header('Location: vendorMenu.php');
        exit;
    }

    //ログイン機能
    if(!empty($_POST['login']) && !empty($_POST["student"]) && !empty($_POST["password"])){
        
        $student = $_POST["student"];
        $password = $_POST["password"];

        try {
            //DBに接続
            require_once 'database_conf.php';
            $db = new PDO($dsn, $dbUser, $dbPass);
            //SQL作成・実行
            $sql = 'SELECT * FROM studentlogintable WHERE student = '. $student;
            $prepare = $db->prepare($sql);
            $prepare->execute();
            $result = $prepare->fetch(PDO::FETCH_ASSOC);
        
        } catch(PDOException $e) {
            echo $e->getMessage();
            die();
        }
        
        //本人確認
        if ($password == $result['password'] && $result['resumeDate'] == null) 
        {
            $_SESSION["USER"] = $_POST["student"];
            header("Location: index.php");
            exit;
        }
        else if ($result['resumeDate'] != null) {
            $message = 'ペナルティがあるため、'.$result['resumeDate'].'　を過ぎるまでご利用いただけません。';
        }
        else {
            $message = 'ログインに失敗しました。';
        }
    }
?>
 
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>ログインページ</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<p>弁当事前予約サービス</p>
<h2>ログインページ</h2>
<p style="color: red"><?php echo $message ?></p>
<form method="post" action="login.php">
    <table>
        <tr><td><label for="student">学生番号</label>
            <td><input id="student" type="text" name="student">
        <tr><td><label for="password">パスワード</label>
            <td><input id="password" type="password" name="password">
    </table>
    <br>
    <input class="btn-sticky" type="submit" name="login" value="ログイン">
</form>
 
</body>
</html>
