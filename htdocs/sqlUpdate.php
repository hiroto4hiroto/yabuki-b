<?php
    try {
        //DBに接続
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        //この""の中にSQL文を打つと反映される
        //ただし"を使ってはいけない
        $sql = "
        
INSERT INTO `ordertable` (`check`, `date`, `user`, `name`, `QRid`) VALUES
(0, '2019-07-19', '1742120', 'い弁当', '254fc572-a766-4522-a013-ff6562026145'),
(0, '2019-07-20', '1742120', 'い弁当', '254fc572-a766-4522-a013-ff6562026145'),
(0, '2019-07-19', '1742119', 'ろ弁当', 'fd91c4ee-7817-45df-b0dc-658ff39a9f45');

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
