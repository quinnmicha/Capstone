<?php
session_start();
var_dump($_SESSION['editItem']);
$jsonResults= json_encode($_SESSION['editItem']);
echo $jsonResults;

?>
