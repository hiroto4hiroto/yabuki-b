<?php
    try {
        //DBに接続
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        //この""の中にSQL文を打つと反映される
        //ただし"を使ってはいけない
        $sql = "
drop table bentotable;

CREATE TABLE `bentotable` (
  `id` int(11) NOT NULL,
  `view` tinyint(1) DEFAULT 0,
  `date` date NOT NULL,
  `name` text NOT NULL,
  `price` int(11) NOT NULL,
  `stocks` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `bentotable` (`id`, `view`, `date`, `name`, `price`, `stocks`) VALUES
(1, 0, '2019-07-20', 'い弁当', 300, 50),
(2, 0, '2019-07-20', 'ろ弁当', 300, 30),
(3, 0, '2019-07-20', 'は弁当', 350, 20),
(4, 0, '2019-07-20', 'スペシャル弁当', 10000, 200);


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
