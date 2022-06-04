
<?php
    include_once("db.php");
    
    if (isset($_POST["name"]) && strlen($_POST["name"]) != 0 && isset($_POST["oldpwd"]) && strlen($_POST["oldpwd"]) != 0 && isset($_POST["newpwd"]) && strlen($_POST["newpwd"]) != 0) {
        $result = $pdo->query("SELECT * FROM `$_users`;");
        
        $found = false;
        $prevhash = "";
        
        while ($row = $result->fetch()) {
            if ($_POST["name"] == $row["uname"]) {
                $found = true;
                $prevhash = $row["pwd"];
                break;
            }
        }
        
        if ($found) {
            $newhash = password_hash($_POST["newpwd"] . $salt, PASSWORD_DEFAULT);
            
            if (password_verify($_POST["oldpwd"] . $salt, $prevhash)) {
                $stmt = $pdo->prepare("UPDATE `$_users` SET pwd = ? WHERE idusers = ?;");
                $stmt->execute([$newhash, $_SESSION["uid"]]);
                header("Location: index.php");
            }
        }
    }
    
    header("Location: account.php");
?>