<?php
    function datestring(int $offset=0)
    {
        $_time = time() + $offset;
        $time = $_time;
        
        $min = $time % (60 * 60);
        $min = floor($min / 450);
        
        $sec = $min % 60;
        $min = floor($min / 60);
        $time = floor($time / (60 * 60));
        
        $min = $min < 10 ? "0$min" : "$min";
        $sec = $sec < 10 ? "0$sec" : "$sec";
        
        $datestr = sprintf("%s:%s:%s", date("Y-m-d H"), $min, $sec);
        
        return $datestr;
    }
    
    if (isset($_GET["j"]))
        echo datestring(450);
?>
