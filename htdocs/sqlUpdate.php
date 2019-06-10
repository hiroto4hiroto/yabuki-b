<?php
    try {
        //DBに接続
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        //この""の中にSQL文を打つと反映される
        //ただし"を使ってはいけない
        $sql = "
        
        

CREATE TABLE `logintable` (
  `id` char(7) NOT NULL,
  `password` varchar(32) DEFAULT NULL,
  `resumeDate` date DEFAULT NULL,
  `isVender` boolean
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `logintable`
--

INSERT INTO `studentlogintable` (`id`, `password`, `resumeDate`, `isVender`) VALUES
('1742111', 'murata', NULL, FALSE),
('1742119', 'yamashita', NULL, FALSE),
('1742120', 'yamada', NULL, FALSE),
('0120117', 'shimoda', NULL, TRUE);



        ";
        $prepare = $db->prepare($sql);
        $prepare->execute();
        
        
        
        $db = new PDO($dsn, $dbUser, $dbPass);
        $sql = "select * from sys.objects;";
        $prepare = $db->prepare($sql);
        echo $prepare->execute();
                
    } catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }
?>
