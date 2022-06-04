<?php
    session_start();
    
    if (isset($_SESSION["uid"]))
        header("Location: account.php");
    
    include_once("db.php");
?>
<!doctype html>
<html>
    <head>
        <title>Sign Up</title>
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
        echo "<li><a href='#' class='selected'>Sign up</a></li>";
        echo "<li><a href='./signin.php'>Sign in</a></li>";
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
                <h4>Create account</h4>
                <label for='name'>username:</label><br>
                <input type='text' placeholder='enter username' name='name' autocomplete='on' maxlength='127' required><br>
                <label for='pwd'>password:</label><br>
                <input type='password' placeholder='enter password' name='pwd' autocomplete='on' maxlength='127' required><br>
                <input class='submit-input' type='submit' value='submit'>
            </form>
            <?php
                if (isset($_POST["name"]) && strlen($_POST["name"]) != 0 && isset($_POST["pwd"]) && strlen($_POST["pwd"]) != 0) {
                    $result = $pdo->query("SELECT * FROM `$_users`;");
                    
                    $found = false;
                    
                    while ($row = $result->fetch()) {
                        if ($_POST["name"] == $row["uname"]) {
                            $found = true;
                            break;
                        }
                    }
                    
                    if (!$found) {
                        $hash = password_hash($_POST["pwd"] . $salt, PASSWORD_DEFAULT);
                        
                        $datetime = gmdate("Y-m-d H:i:s");
                        
                        $stmt = $pdo->prepare("INSERT INTO `$_users` (joindate, activedate, uname, pwd, pts, color, admin) "
                            . " VALUES ('$datetime', '$datetime', ?, ?, 1000, '#000000', 0);");
                        $stmt->execute([$_POST["name"], $hash]);
                        
                        $_SESSION["admin"] = 0;
                        $_SESSION["uid"] = $pdo->lastInsertId();
                        $_SESSION["uname"] = $_POST["name"];
                        $_SESSION["pwd"] = $hash;
                        header("Location: index.php");
                    }
                }
            ?>
        </div>
        <div id='cookie' onclick='cookieaccept()'>
            This site uses cookies; by continuing to use this site you agree to the use of your data listed in our about section.
            <div id='cookie-inner' onclick='cookieaccept()'>accept</div>
        </div>
    </body>
    <script src='js/cookie.js'></script>
    <script src='js/payout.js'></script>
</html>
