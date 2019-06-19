<?php
    try {
        //DBに接続
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        //この""の中にSQL文を打つと反映される
        //ただし"を使ってはいけない
        $sql = "

drop table imagetable;

CREATE TABLE `imagetable` (
  `id` int(11) NOT NULL,
  `image`  MEDIUMBLOB DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE bentotable ADD PRIMARY KEY (`id`);


        ";
        $prepare = $db->prepare($sql);
        $prepare->execute();
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        echo $result;
                
    } catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }
?>
