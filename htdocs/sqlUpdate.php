<?php
    try {
        //DBに接続
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        //この""の中にSQL文を打つと反映される
        //ただし"を使ってはいけない
        $sql = "
        

select * from bentotable where name = い弁当 limit 1;


        ";
        $prepare = $db->prepare($sql);
        $prepare->execute();
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        echo $result['price'];
                
    } catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }
?>
