<?php
    if (isset($_GET["id"])) {
        include_once("db.php");
        
        $stmt = $pdo->prepare("SELECT * FROM `$_users` WHERE idusers = ?;");
        
        $stmt->execute([$_GET["id"]]);
        
        $rows = $stmt->fetchAll();
        
        if (count($rows))
            echo $rows["0"]["pts"];
        else
            echo 1;
    }
?>
