<?php
    include_once("db.php");
    include_once("_time.php");
    
    $races = $pdo->prepare("SELECT * FROM `$_races` WHERE payout = 0;");
    $races->execute();
    
    $datestr = datestring(225);
    
    foreach ($races->fetchAll() as $race) {
        if ($race["racedate"] != $datestr) {
            
            $winner = $race["winner"];
            $idraces = $race["idraces"];
            
            $bets = $pdo->prepare("SELECT * FROM `$_bets` WHERE idraces = ?;");
            $bets->execute([$race["idraces"]]);
            
            foreach ($bets->fetchAll() as $bet) {
                if ($bet["snail"] == $winner) {
                    $betscol = array();
                    array_push($betscol, intval($race["betdave"]));
                    array_push($betscol, intval($race["betadam"]));
                    array_push($betscol, intval($race["betjohn"]));
                    array_push($betscol, intval($race["betjeremy"]));
                    array_push($betscol, intval($race["betoscar"]));
                    $truetotal = array_sum($betscol);
                    
                    $betscol[$winner] = 0;
                    $total = array_sum($betscol);
                    
                    $idusers = $bet["idusers"];
                    
                    if (floatval($total) != 0)
                        $amount = intval($bet["amount"]) + intval((1.1 * floatval($truetotal)) * floatval($bet["amount"]) / floatval($total));
                    else
                        $amount = 1.1 * floatval($bet["amount"]);
                    
                    $pdo->query("UPDATE `$_users` SET pts = pts + $amount WHERE idusers = $idusers;");
                }
            }
            
            $pdo->query("UPDATE `$_races` SET payout = 1 WHERE idraces = $idraces;");
        }
    }
?>
