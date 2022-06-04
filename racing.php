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
        <li><a href='./index.php'>Home</a></li>
        <li><a href='./about.php'>About</a></li>
        <li><a href='#' class='selected'>Racing</a></li>
<?php
    if (!isset($_SESSION["uid"])) {
        echo "<li><a href='./signup.php'>Sign up</a></li>";
        echo "<li><a href='./signin.php'>Sign in</a></li>";
    }
    
    else {
        echo "<li><a href='./account.php'>Account</a></li>";
        
        if($_SESSION["admin"] == 1)
            echo "<li><a href='./stats.php'>Stats</a></li>";
        
        echo "<li class='score'><a id='score-elem'>Score</a></li>";
    }
?>
    </ul>
    <body>
        <div class='container-div'>
            <div class='chat-div'>
                <div id='msg-container-div'></div>
                <div class='textbox-div'>
                    <input type='text' id='sendmsg-input' maxlength='255'>
                </div>
            </div>
            <div class='race-div'>
                <canvas id='race-canvas'></canvas>
            </div>
        </div>
<?php
        if (isset($_SESSION["uid"]))
            echo "<div class='bet-elems'>
            <select name='snail' id='bet-snail'>
                <option value='dave'>Dave</option>
                <option value='john'>John</option>
                <option value='adam'>Adam</option>
                <option value='jeremy'>Jeremy</option>
                <option value='oscar'>Oscar</option>
            </select>
            <select name='amount' id='bet-amount'>
                <option value='10'>10</option>
                <option value='20'>20</option>
                <option value='30'>30</option>
                <option value='40'>40</option>
                <option value='50'>50</option>
                <option value='60'>60</option>
                <option value='70'>70</option>
                <option value='80'>80</option>
                <option value='90'>90</option>
                <option value='100'>100</option>
            </select>
            <button id='bet-now'>bet</button>
        </div>";
?>
        <div id='cookie' onclick='cookieaccept()'>
            This site uses cookies; by continuing to use this site you agree to the use of your data listed in our about section.
            <div id='cookie-inner' onclick='cookieaccept()'>accept</div>
        </div>
    </body>
<?php
    if (isset($_SESSION["uid"])) {
        echo "<script>const __uid = '" . $_SESSION["uid"] . "';"
            . "const __uname   = '" . $_SESSION["uname"] . "';"
            . "const __pwd     = '" . $_SESSION["pwd"] . "';</script>";
        
        echo "<script src='js/bet.js'></script>";
    } else {
        echo "<script>const __uid = '0';"
            . "const __uname   = 'guest';"
            . "const __pwd     = '';</script>";
    }
?>
        <script src='js/chat.js'></script>
        <script src='js/cookie.js'></script>
        <script src='js/payout.js'></script>
        <script src='js/race.js'></script>
        <script src='js/score.js'></script>
        <script>
            init(12322844);
        </script>
</html>
