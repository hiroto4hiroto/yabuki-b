<?php
    try {
        //DBに接続
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        //この""の中にSQL文を打つと反映される
        //ただし"を使ってはいけない
        $sql = "
        
        
drop table 'logintable':


        ";
        echo $sql + "<br>";
        $prepare = $db->prepare($sql);
        var_dump((Array)($prepare->execute()));

                
    } catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }
?>
