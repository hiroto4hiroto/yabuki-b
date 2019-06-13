<?php
    try {
        //DBに接続
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        //この""の中にSQL文を打つと反映される
        //ただし"を使ってはいけない
        $sql = "
        
SELECT * FROM ordertable ORDER BY date, price ASC;

        ";
        $prepare = $db->prepare($sql);
        $prepare->execute();
        
        foreach ($prepare->fetchAll(PDO::FETCH_ASSOC) as $result){
            var_dump($result);
        }
        
                
    } catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }
?>
