<?php
include __DIR__ . '/Model/model_inventory.php';
session_start();

$id = filter_input(INPUT_POST, 'id');

$answer = getItem($id);
array_push($_SESSION['editItem'], $answer);
var_dump($_SESSION['editItem']);
var_dump($answer);


?>
