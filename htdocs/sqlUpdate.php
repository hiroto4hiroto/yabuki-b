<?php
    try {
        //DBに接続
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        //この""の中にSQL文を打つと反映される
        //ただし"を使ってはいけない
        $sql = "
        
        

CREATE TABLE `logintable` (
  `user` char(7) NOT NULL,
  `password` varchar(32) DEFAULT NULL,
  `resumeDate` date DEFAULT NULL,
  `isVender` boolean
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `logintable`
--

INSERT INTO `studentlogintable` (`user`, `password`, `resumeDate`, `isVender`) VALUES
('1742111', 'murata', NULL, 0),
('1742119', 'yamashita', NULL, 0),
('1742120', 'yamada', NULL, 0),
('0120117', 'shimoda', NULL, 1);



        ";
        $prepare = $db->prepare($sql);
        $prepare->execute();
        
        
        
        $db = new PDO($dsn, $dbUser, $dbPass);
        $sql = "SHOW TABLES FROM mydb;";
        $prepare = $db->prepare($sql);
        $temp = $prepare->execute();
        echo $temp;
                
    } catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }
?>
