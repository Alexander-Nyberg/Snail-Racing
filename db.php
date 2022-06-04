<?php
    $_username = "root";
    $_password = "sAdAsA45";
    
    $_servername = "localhost";
    $_dbname     = "stuff";
    
    $_bets       = "bets";
    $_msgs       = "msgs";
    $_races      = "races";
    $_transact   = "trans";
    $_users      = "users";
    $_logon      = "logon";
    
    $salt = "e9+HLGQ48IF8Zrzw";
    
    try {
        $pdo = new PDO("mysql:host=$_servername;dbname=$_dbname", $_username, $_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    catch (PDOException $e) {
        die("connecting to the server failed: " . $e->getMessage());
    }
?>
