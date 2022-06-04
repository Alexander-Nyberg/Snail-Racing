<?php
    session_start();
    
    if (!isset($_SESSION["uid"]) || $_SESSION["admin"] != 1)
        header("Location: index.php");
    
    include_once("db.php");
    include_once("_active.php");
?>
<!doctype html>
<html>
    <head>
        <title>Stats</title>
        <meta charset='utf-8'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel='shortcut icon' href='img/dave_nobg.png' type='image/x-icon'>
        <link rel='stylesheet' href='css/style.css'>
    </head>
    <ul class='navbar'>
        <li><a href='./index.php'>Home</a></li>
        <li><a href='./about.php'>About</a></li>
        <li><a href='./racing.php'>Racing</a></li>
        <li><a href='./account.php'>Account</a></li>
        <li><a href='#' class='selected'>Stats</a></li>
    </ul>
    <body>
        
    </body>
    <script src='js/payout.js'></script>
</html>
