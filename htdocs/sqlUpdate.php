<?php
    try {
        //DBに接続
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        //この""の中にSQL文を打つと反映される
        //ただし"を使ってはいけない
        $sql = "
        
        UPDATE INTO `imagetable` (`id`, `image`) VALUES ( 5, 89768769) WHERE `id` = 5;

        ";
        $prepare = $db->prepare($sql);
        $prepare->execute();
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        var_dump($result);
                
    } catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }
?>
