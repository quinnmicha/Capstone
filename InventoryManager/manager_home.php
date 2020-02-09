<?php

include_once __DIR__. "/Model/includes/functions.php";
//include_once __DIR__. "/../Model/model_movies.php";

session_start();

if( isset($_SESSION["usertype"])){
    if($_SESSION["usertype"]=="admin"){
        echo "userName: " . $_SESSION["username"];
        echo " userType: " . $_SESSION["usertype"];
    }
    else{
        header('Location: ../InventoryManager/index.php');
    }
} 



if($_SESSION['submit'] == 'Register'){
        header('Location: register.php');
    }
