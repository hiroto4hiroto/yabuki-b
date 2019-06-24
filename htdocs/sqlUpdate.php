<?php
    try {
        //DBに接続
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        //この""の中にSQL文を打つと反映される
        //ただし"を使ってはいけない
        $sql = "
    
SELECT `ordertaable`.QRid = `QRid` FROM `ordertable` LEFT OUTER JOIN `bentotable` ON `bentotable`.id = `ordertable`.id WHERE `ordertable`.user = '1742120' AND `bentotable`.date = '". $getdate ."' + INTERVAL 1 DAY limit 1;


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
