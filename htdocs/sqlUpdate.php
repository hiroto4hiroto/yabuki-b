<?php
    try {
        //DBに接続
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        //SQL作成・実行
        
        //この""の中にSQL文を打つと反映される
        //ただし"を使ってはいけない
        $sql = "
        


        

        ";

        $prepare = $db->prepare($sql);
        $prepare->execute();
                
    } catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }
?>
