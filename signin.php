<?php
    session_start();
    
    include_once("db.php");
?>
<!doctype html>
<html>
    <head>
        <title>Sign In</title>
        <meta charset='utf-8'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel='shortcut icon' href='img/dave_nobg.png' type='image/x-icon'>
        <link rel='stylesheet' href='css/style.css'>
    </head>
    <ul class='navbar'>
        <li><a href='./index.php'>Home</a></li>
        <li><a href='./about.php'>About</a></li>
        <li><a href='./racing.php'>Racing</a></li>
<?php
    if (!isset($_SESSION["uid"])) {
        echo "<li><a href='./signup.php'>Sign up</a></li>";
        echo "<li><a href='#' class='selected'>Sign in</a></li>";
    }
    
    else {
        echo "<li><a href='./account.php'>Account</a></li>";
        
        if($_SESSION["uid"] == 0)
            echo "<li><a href='./stats.php'>Stats</a></li>";
    }
?>
    </ul>
    <body>
    <div class='form-div'>
        <form method='post' class='account-form'>
            <h4>Sign In</h4>
            <label for='name'>username:</label><br>
            <input type='text' placeholder='enter username' name='name' autocomplete='on' maxlength='127' required><br>
            <label for='pwd'>password:</label><br>
            <input type='password' placeholder='password' name='pwd' autocomplete='on' maxlength='127' required><br>
            <input class='submit-input' type='submit' value='submit'>
        </form>
        <?php
            if (isset($_POST["name"]) && strlen($_POST["name"]) != 0 && isset($_POST["pwd"]) && strlen($_POST["pwd"])) {
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
                    if (password_verify($_POST["pwd"] . $salt, $prevhash)) {
                        $stmt = $pdo->prepare("SELECT * FROM `$_users` WHERE uname = ? AND pwd = ?;");
                        $stmt->execute([$_POST["name"], $prevhash]);
                        
                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                        
                        $rows = $stmt->fetchAll();
                        
                        $_SESSION["admin"] = $rows[0]["admin"];
                        $_SESSION["uid"] = $rows[0]["idusers"];
                        $_SESSION["uname"] = $rows[0]["uname"];
                        $_SESSION["pwd"] = $rows[0]["pwd"];
                        header("Location: index.php");
                    }
                }
            }
        ?>
        <div id='cookie' onclick='cookieaccept()'>
            This site uses cookies; by continuing to use this site you agree to the use of your data listed in our about section.
            <div id='cookie-inner' onclick='cookieaccept()'>accept</div>
        </div>
    </body>
    <script src='js/cookie.js'></script>
    <script src='js/payout.js'></script>
</html>
