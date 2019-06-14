<?php
    try {
        //DBに接続
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        //この""の中にSQL文を打つと反映される
        //ただし"を使ってはいけない
        $sql = "

        delete from ordertable where date < '2099-09-09';


/*
INSERT INTO `ordertable` (`check`, `date`, `user`, `name`, `QRid`) VALUES
(0, '2019-07-19', '1742120', 'い弁当', '154fc572-a766-4522-a013-ff6562026145'),
(0, '2019-07-20', '1742120', 'い弁当', '254fc572-a766-4522-a013-ff6562026145'),
(0, '2019-07-21', '1742120', 'は弁当', '354fc572-a766-4522-a013-ff6562026145'),
(0, '2019-07-22', '1742120', 'に弁当', '454fc572-a766-4522-a013-ff6562026145'),
(0, '2019-07-23', '1742119', 'ほ弁当', '5d91c4ee-7817-45df-b0dc-658ff39a9f45');
*/

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
