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
//echo $result['image'];
                
    } catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }
?>
<html>
<div style="background-image:url('<?php echo $result['image'] ?>'); width: 50vw; height: 50vh;"></div>
</html>
