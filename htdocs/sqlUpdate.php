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
  'resumeDate' date DEFAULT NULL,
  'isVender' tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO 'studentlogintable' ('user', 'password', 'resumeDate', 'isVender') VALUES
('1742111', 'murata', NULL, 0);
('1742119', 'yamashita', NULL, 0),
('1742120', 'yamada', NULL, 0),
('9999999', 'shimoda', NULL, 1);


        ";
        $prepare = $db->prepare($sql);
        $prepare->execute();
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        echo $result['password'];
                
    } catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }
?>
