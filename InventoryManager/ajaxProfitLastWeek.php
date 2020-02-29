<?php
include __DIR__ . '/Model/model_inventory.php';

$profitData = getReportLastWeek();
$results[0] = array(); // expense 
$results[1] = array(); // revenue
$results[2] = array(); // week selected

array_push($results[0], number_format($profitData['expense'], 2, '.', ''));
array_push($results[1], number_format($profitData['revenue'], 2, '.', ''));
array_push($results[2], $profitData['week']);
$jsonResults= json_encode($results);
echo $jsonResults;

?>