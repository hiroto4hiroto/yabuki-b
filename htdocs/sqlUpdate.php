<?php
    try {
        //DBに接続
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        //この""の中にSQL文を打つと反映される
        //ただし"を使ってはいけない
        $sql = "
        
        

        SELECT * from `imagetable` WHERE `id` = 5;
        
        
        ";
        $prepare = $db->prepare($sql);
        $prepare->execute();
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        header('Content-type: image/jpeg');
        print $result['image'];
                
    } catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }
?>
<html>
    <?php header('Content-type: image/jpeg'); ?>
    <img src="<?php echo $result['image']; ?>">;
    <!--
<div style="width: 50vw; height: 50vh; background-image:url(<?php echo $result['image'] ?>);"></div>
-->
</html>
