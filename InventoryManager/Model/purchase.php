<?php

include __DIR__ . '/Model/model_inventory.php';

$id = filter_input(INPUT_POST, 'id');
$unitPrice=filter_input(INPUT_POST, 'unitPrice');
$purchaseAmount=filter_input(INPUT_POST, 'purchaseAmount');

$answer = purchaseItem($id, $unitPrice, $purchaseAmount, 3);

/*
$_SESSION["itemId"] = filter_input(INPUT_POST, 'id');
$_SESSION["unitPrice"] = filter_input(INPUT_POST, 'unitPrice');
$_SESSION["purchaseAmount"] = filter_input(INPUT_POST, 'purchaseAmount');

*/


?>
