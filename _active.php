<?php
    include_once("db.php");
    
    if (isset($_SESSION["uid"])) {
        $result = $pdo->query("SELECT activedate FROM `$_users` WHERE idusers = " . $_SESSION["uid"] . ";");
        
        $pretime = $result->fetch()["activedate"];
        
        $before = new DateTime($pretime);
        $after  = new DateTime();
        
        $diff = $after->getTimestamp() - $before->getTimestamp();
        
        if ($diff > 60 * 60 * 24) {
            $days = floor($diff / (60 * 60 * 24));
            $before->add(new DateInterval("P" . $days . "D"));
            
            $datetime = $before->format("Y-m-d H:i:s");
            
            $pdo->query("UPDATE `$_users` SET activedate = '$datetime' WHERE idusers = " . $_SESSION["uid"] . ";");
            $pdo->query("UPDATE `$_users` SET pts = pts + 1000 WHERE idusers = " . $_SESSION["uid"] . ";");
            
            $datetime = gmdate("Y-m-d H:i:s");
            $pdo->query("INSERT INTO `$_transact` (amount, idgetter, idsender, transdate) VALUES (1000, " . $_SESSION["uid"] . ", 0, '$datetime');");
        }
    }
?>
