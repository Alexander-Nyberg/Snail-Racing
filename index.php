<?php
    session_start();
    
    include_once("db.php");
    include_once("_active.php");
?>
<!doctype html>
<html>
    <head>
        <title>Snail Racing</title>
        <meta charset='utf-8'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel='shortcut icon' href='img/dave_nobg.png' type='image/x-icon'>
        <link rel='stylesheet' href='css/style.css'>
    </head>
    <ul class='navbar'>
        <li><a href='#' class='selected'>Home</a></li>
        <li><a href='./about.php'>About</a></li>
        <li><a href='./racing.php'>Racing</a></li>
<?php
    if (!isset($_SESSION["uid"])) {
        echo "<li><a href='./signup.php'>Sign up</a></li>";
        echo "<li><a href='./signin.php'>Sign in</a></li>";
    }
    
    else {
        echo "<li><a href='./account.php'>Account</a></li>";
        
        if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1)
            echo "<li><a href='./stats.php'>Stats</a></li>";
    }
?>
    </ul>
    <body>
        <div class='news-div'>
            <h3>News</h3>
            <p>The site is done!</p>
            <p>Please take some time to answer <a href='https://forms.gle/MWqSobx7sNTdNTzEA'>this survey</a> after you have tried the site.</p>
        </div>
        <div id='cookie' onclick='cookieaccept()'>
            This site uses cookies; by continuing to use this site you agree to the use of your data listed in our about section.
            <div id='cookie-inner' onclick='cookieaccept()'>accept</div>
        </div>
    </body>
    <script src='js/cookie.js'></script>
    <script src='js/payout.js'></script>
</html>
