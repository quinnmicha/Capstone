<?php

include_once __DIR__. "/Model/includes/functions.php";
//include_once __DIR__. "/../Model/model_movies.php";

session_start();

if(isPostRequest()){
    $_SESSION['username'] = filter_input(INPUT_POST, 'username');
    $_SESSION['password'] = filter_input(INPUT_POST, 'password');
    $_SESSION['submit'] = filter_input(INPUT_POST, 'submit');
    
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $usertype = $_SESSION['submit'];
    
   /* $login = checkLogin($username, $password);
    
    if(is_string($login)){
        if(strpos($login, "Error") !== true){
            //$_SESSION['validationMsg'] = "Username and Password Do Not Match Existing User";
            header('Location: login.php');
        }else{
           // unset($_SESSION['validationMsg']);
            var_dump($login);
        }
    }*/
    var_dump($username);
    var_dump($password);
    var_dump($usertype);
}

if($_SESSION['submit'] == 'Register'){
        header('Location: register.php');
    }
