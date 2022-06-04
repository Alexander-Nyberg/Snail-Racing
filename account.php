<?php
    session_start();
    
    if (!isset($_SESSION["uid"]))
        header("Location: signin.php");
    
    include_once("db.php");
    include_once("_active.php");
?>
<!doctype html>
<html>
    <head>
        <title>Your Account</title>
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
    echo "<li><a href='#' class='selected'>Account</a></li>";
    
    if($_SESSION["admin"] == 1)
        echo "<li><a href='./stats.php'>Stats</a></li>";
?>
    </ul>
    <body>
        <div class='form-div'>
            <form class='account-form' action='_pwd.php' method='get'>
                <h4 class='foldable' onclick='changeShow(`changepwd-show`)'>Change Password</h4>
                <div class='selectable' id='changepwd-show'>
                    <label for='name'>username</label><br>
                    <input type='text' placeholder='enter username' name='name' autocomplete='on' maxlength='127' required><br>
                    <label for='oldpwd'>password</label><br>
                    <input type='password' placeholder='old password' name='oldpwd' autocomplete='on' maxlength='127' required><br>
                    <label for='newpwd'>new password</label><br>
                    <input type='password' placeholder='new password' name='newpwd' autocomplete='on' maxlength='127' required><br>
                    <input class='submit-input' type='submit' value='submit'>
                </div>
            </form>
        </div>
    </body>
    <script src='js/payout.js'></script>
    <script src='js/select.js'></script>
</html>
