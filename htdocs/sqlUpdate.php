<?php
    try {
        //DBに接続
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        //SQL作成・実行
        
        //この""の中にSQL文を打つと反映される
        //ただし"を使ってはいけない
        $sql = "


CREATE TABLE `ordertable` (
  `QRid` char(36) NOT NULL,
  'name' text DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


        ";

        $prepare = $db->prepare($sql);
        $prepare->execute();
                
    } catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }
?>
