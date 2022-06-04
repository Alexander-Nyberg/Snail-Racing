<?php
    include_once("db.php");
    include_once("_time.php");
    
    $snails = [
        "dave",
        "john",
        "adam",
        "jeremy",
        "oscar",
    ];
    
    if (isset($_GET["name"]) && strlen($_GET["name"]) != 0 && isset($_GET["pwd"]) && strlen($_GET["pwd"]) != 0
            && isset($_GET["snail"]) && strlen($_GET["snail"]) != 0 && isset($_GET["amount"]) && strlen($_GET["amount"]) != 0
            && in_array($_GET["snail"], $snails) && (time() + 225) % 450 <= 225) {
        $stmt = $pdo->prepare("SELECT * FROM `$_users` WHERE uname = ? AND pwd = ? AND pts >= ?;");
        $stmt->execute([$_GET["name"], $_GET["pwd"], $_GET["amount"]]);
        
        $rows = $stmt->fetchAll();
        
        if (count($rows)) {
            $amount = intval($_GET["amount"]);
            $idusers = $rows[0]["idusers"];
            $newscore = intval($rows[0]["pts"]) - $amount;
            $idx = array_search($_GET["snail"], $snails);
            $datestr = datestring(450);
            
            $stmt = $pdo->prepare("SELECT * FROM `$_races` WHERE racedate = '$datestr';");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            
            if (!count($rows)) {
                $num = rand();
                
                $places = [0, 0, 0, 0, 0];
                $randseed = $num;
                $racelength = 20;
                $baseseed = $randseed;
                $moves = 0;
                $winner = 0;
                
                function randbit()
                {
                    global $randseed;
                    $newbit = ($randseed & 1) ^ (($randseed & 8) >> 3);
                    
                    $bit = $randseed & 1;
                    
                    $randseed = abs($newbit << 31) | ($randseed >> 1);
                    
                    $randseed = abs($randseed % 0x100000000);
                    
                    return $bit ? 1 : 0;
                }
                
                function _random($min, $max)
                {
                    $num = randbit();
                    
                    for ($i = 0; $i < 31; $i++) {
                        $num *= 2;
                        $num += randbit();
                    }
                    
                    return floor(($num / floatval(0x100000000)) * ($max - $min)) + $min;
                }
                
                for ($i = 0; $i < 64; $i++)
                    _random(0, 1);
                
                while (1) {
                    $i = _random(0, 5);
                    $moves++;
                    $places[$i]++;
                    if ($places[$i] >= $racelength) {
                        $winner = $i;
                        break;
                    }
                }
                
                $pdo->query("INSERT INTO `$_races` (seed, winner, betdave, betjohn, betadam, betjeremy, betoscar, racedate)"
                    . " VALUES ($num, $winner, 0, 0, 0, 0, 0, '$datestr');");
            }
            
            $stmt = $pdo->prepare("SELECT * FROM `$_races` WHERE racedate = '$datestr';");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            
            $idraces = $rows[0]["idraces"];
            
            $s = $snails[$idx];
            
            $pdo->query("INSERT INTO `$_bets` (idraces, idusers, amount, snail, betdate) VALUES ($idraces, $idusers, $amount, $idx, '$datestr');");
            $pdo->query("UPDATE `$_users` SET pts = $newscore WHERE idusers = $idusers;");
            $pdo->query("UPDATE `$_races` SET bet$s = bet$s + $amount WHERE racedate = '$datestr';");
        }
    }
?>
