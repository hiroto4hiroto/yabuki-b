<?php
    try {
        //DBに接続
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        //この""の中にSQL文を打つと反映される
        //ただし"を使ってはいけない
        $sql = "
    
CREATE TABLE `ordertable` (
  `check` tinyint(1) DEFAULT 0,
  `user` char(7) NOT NULL,
  `id` int(11) NOT NULL,
  `QRid` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



        ";
        $prepare = $db->prepare($sql);
        $prepare->execute();
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        var_dump( $result );
                
    } catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }
?>
<html>
<?php echo $result['image']; ?>
</html>
