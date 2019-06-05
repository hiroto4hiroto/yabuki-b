<?php
    try {
        //DBに接続
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        //SQL作成・実行
        
        //この""の中にSQL文を打つと反映される
        //ただし"を使ってはいけない
        $sql = "
        

--
-- テーブルの構造 `bentotable`
--

CREATE TABLE `bentotable` (
  `date` date NOT NULL,
  `name` text NOT NULL,
  `price` int(11) NOT NULL,
  `stocks` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `bentotable`
--

INSERT INTO `bentotable` (`date`, `name`, `price`, `stocks`) VALUES
('2019-05-30', 'A弁当', 300, 50),
('2019-05-30', 'B弁当', 350, 30),
('2019-05-30', 'スペシャル弁当', 10000, 200);
        

        ";

        $prepare = $db->prepare($sql);
        $prepare->execute();
                
    } catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }
?>
