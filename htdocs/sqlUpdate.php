<?php
    try {
        //DBに接続
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        //この""の中にSQL文を打つと反映される
        //ただし"を使ってはいけない
        $sql = "
        
       INSERT INTO `ordertable` VALUES (`check`, `user`, `id`, `QRid`) VALUES (0, '1742120', 1, 'hogeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');

        
        
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
