<?php
include __DIR__ . '/Model/model_inventory.php';

$profitData = getProfitByWeek();
$results[0] = array(); // week 
$results[1] = array(); // profit

    foreach ($profitData as $v) {
        array_push($results[0], $v['week']);
        array_push($results[1], $v['profit']);
    }
    $jsonResults= json_encode($results);
    echo $jsonResults;

?>