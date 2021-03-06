<?php 
    
    exec('/bin/grep -c ^processor /proc/cpuinfo',$resultNumberOfCores);
    $numberOfCores = $resultNumberOfCores[0];

    exec('/bin/cat /proc/loadavg | /usr/bin/awk \'{print $1","$2","$3}\'',$resultLoadAvg);
    $loadAvg = explode(',',$resultLoadAvg[0]);

    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(
        array_map(
            "convertToPercentage",
            $loadAvg,
            array_fill(0, count($loadAvg), $numberOfCores)
        )
    );
    
    function convertToPercentage($value, $numberOfCores){
        return array($value, (int)($value * 100 / $numberOfCores));
    }
