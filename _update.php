<?php
    include_once("db.php");
    include_once("_time.php");
    
    $time = time();
    
    if (isset($_GET["action"])) {
        if ($time % 450 <= 225) {
            $datestr = datestring();
            
            $stmt = $pdo->prepare("SELECT * FROM `$_races` WHERE racedate = '$datestr';");
            $stmt->execute();
            
            $i = 0;
            $arr = array();
            
            if ($row = $stmt->fetch()) {
                $i++;
                array_push($arr, $row);
            }
            
            if ($i == 0) {
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
                
                $stmt = $pdo->prepare("SELECT * FROM `$_races` WHERE racedate = '$datestr';");
                $stmt->execute();
                
                $i = 0;
                $arr = array();
                
                if ($row = $stmt->fetch()) {
                    $i++;
                    array_push($arr, $row);
                }
            }
            
            echo '{"race":1,"seed":' . $arr[0]["seed"] . ',"time":' . ($time % 450) . '}';
        } else {
            echo '{"race":0,"time":"' . gmdate("i:s", 450 - $time % 450) . '"}';
        }
    }
?>
