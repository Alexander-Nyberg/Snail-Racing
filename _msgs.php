<?php
    include_once("db.php");
    
    if (!isset($_GET["action"])) {
        echo "";
    } else if ($_GET["action"] == "get") {
        $result = $pdo->query("SELECT * FROM `$_msgs` INNER JOIN `$_users` ON `$_users`.idusers = `$_msgs`.idusers WHERE shown = 1;");
        
        while ($row = $result->fetch()) {
            echo '{' . '"uname":"' . $row['uname'] . '","color:":"' . $row['color'] .
                '","content":"' . $row['content'] . '","admin":"' . $row["admin"] . '","date":"' . $row["msgdate"] . '"}\r\n';
        }
        
        echo "";
    } else {
        if (isset($_GET["uid"]) && isset($_GET["uname"]) && isset($_GET["pwd"])) {
            $datetime = gmdate("Y-m-d H:i:s");
            
            $msg = file_get_contents("php://input");
            
            if (strlen($msg)) {
                $stmt = $pdo->prepare("SELECT * FROM `$_users` WHERE idusers = ? AND uname = ? AND pwd = ?;");
                $stmt->execute([$_GET["uid"], $_GET["uname"], $_GET["pwd"]]);
                
                $rows = $stmt->fetchAll();
                
                if (count($rows)) {
                    $row = $rows[0];
                    $stmt = $pdo->prepare("INSERT INTO `$_msgs` (idusers, content, msgdate, shown) VALUES (?, ?, ?, 1);");
                    $stmt->execute([$row["idusers"], $msg, $datetime]);
                }
            }
        }    
    }
?>