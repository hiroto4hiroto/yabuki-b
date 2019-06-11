<?php
    try {
        //DBに接続
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        //この""の中にSQL文を打つと反映される
        //ただし"を使ってはいけない
        $sql = "
          
CREATE TABLE 'logintable' (
  'user' char(7) NOT NULL,
  'password' varchar(32) DEFAULT NULL,
  'resumeDate' date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- テーブルのデータのダンプ `logintable`
--
INSERT INTO 'studentlogintable' ('user', 'password', 'resumeDate') VALUES
('1742111', 'murata', NULL),
('1742119', 'yamashita', NULL),
('1742120', 'yamada', NULL),
('0120117', 'shimoda', NULL);

        ";
        $prepare = $db->prepare($sql);
        $prepare->execute();

                
    } catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }
?>
