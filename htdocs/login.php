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
            $db = new PDO("mysql:host=127.0.0.1; dbname=yabukib; charset=utf8",'test','pass');    
            //SQL作成・実行
            $sql = 'SELECT * FROM studentLoginTable WHERE student = '. $student;
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
    }
?>
 
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>ログインページ</title>
</head>
 
<body>
<h1>弁当事前予約サービス</h1>
<h2>ログインページ</h2>
<p style="color: red"><?php echo $message ?></p>
<form method="post" action="login.php">
    <label for="student">学生番号</label>
    <input id="student" type="text" name="student">
    <br>
    <label for="password">パスワード</label>
    <input id="password" type="password" name="password">
    <br>
    <input type="submit" name="login" value="ログイン">
</form>
 
</body>
</html>
