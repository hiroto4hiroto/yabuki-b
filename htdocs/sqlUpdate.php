<?php
    try {
        //DBに接続
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        //この""の中にSQL文を打つと反映される
        //ただし"を使ってはいけない
        $sql = "
        
        
SHOW TABLES FROM yabukib;


        ";
        echo $sql;
        $prepare = $db->prepare($sql);
        print_r ($prepare->execute());

                
    } catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }
?>
