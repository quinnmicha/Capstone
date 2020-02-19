<?php
include __DIR__ . '/Model/model_inventory.php';
session_start();

$id = filter_input(INPUT_POST, 'id');
$_SESSION['editItem']=array();
$answer = getItem($id);
array_push($_SESSION['editItem'], $answer);




?>
