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
        //header('Content-type: image/jpeg');
        //print $result['image'];
                
    } catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }
?>
<html>
    <div style="width: 50vw; height: 50vh; background-image:url('data:image/jpeg;base64,<?php echo base64_encode($result["image"]); ?>;')"></div>
    <img src="data:image/jpg;base64,<?php echo base64_encode($result['image']); ?>">
</html>
