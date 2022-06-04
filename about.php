<?php
    session_start();
    
    include_once("db.php");
    include_once("_active.php");
?>
<!doctype html>
<html>
    <head>
        <title>About</title>
        <meta charset='utf-8'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel='shortcut icon' href='img/dave_nobg.png' type='image/x-icon'>
        <link rel='stylesheet' href='css/style.css'>
    </head>
    <ul class='navbar'>
        <li><a href='./index.php'>Home</a></li>
        <li><a href='#' class='selected'>About</a></li>
        <li><a href='./racing.php'>Racing</a></li>
<?php
    if (!isset($_SESSION["uid"])) {
        echo "<li><a href='./signup.php'>Sign up</a></li>";
        echo "<li><a href='./signin.php'>Sign in</a></li>";
    }
    
    else {
        echo "<li><a href='./account.php'>Account</a></li>";
        
        if($_SESSION["admin"] == 1)
            echo "<li><a href='./stats.php'>Stats</a></li>";
    }
?>
    </ul>
    <body>
        <div class='about-div'>
            <h3>About</h3>
            <p>Snail Racing is a highschool project developed by Alexander Nyberg.</p>
            <h3>Credits</h3>
            <h4>Lead programmer</h4>
            <p>Alexander Nyberg</p>
            <h4>Lead designer</h4>
            <p>Dean Hamzic</p>
            <h4>Volunteer Pentester</h4>
            <p>Emil Andersson</p>
            <h3>Data</h3>
            <p>
                Snail racing stores certain necessary data such as when you last visited the
                site and how many points you have used in order for the site to function. You can
                use the site without having an account, but then you cannot send messages or use
                any points.
            </p>
        </div>
        <div id='cookie' onclick='cookieaccept()'>
            This site uses cookies; by continuing to use this site you agree to the use of your data listed in our about section.
            <div id='cookie-inner' onclick='cookieaccept()'>accept</div>
        </div>
    </body>
    <script src='js/cookie.js'></script>
    <script src='js/payout.js'></script>
</html>
