<?php
include __DIR__ . '/Model/model_inventory.php';

$profitData = getReportLastWeek();
$results[0] = array(); // week 
$results[1] = array(); // profit

    foreach ($profitData as $v) {
        array_push($results[0], $v['expense']);
        array_push($results[1], $v['profit']);
    }
    $jsonResults= json_encode($results);
    echo $jsonResults;

?>