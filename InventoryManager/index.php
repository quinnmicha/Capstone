<?php

//include_once __DIR__. "/Model/includes/functions.php";
include __DIR__ . '/Model/model_inventory.php';

if(isPostRequest()){
    $user = filter_input(INPUT_POST, 'username');
    $pass = filter_input(INPUT_POST, 'password');
    $login = login($user, $pass);
    if($login!=FALSE){
        session_start();

        $_SESSION['username'] = filter_input(INPUT_POST, 'username');
        $_SESSION['password'] = filter_input(INPUT_POST, 'password');
        $_SESSION['usertype'] = filter_input(INPUT_POST, 'usertype');
        header("Location: ../InventoryManager/manager_home.php");
    }
}
?>
<html lang="en">
<head>
  <title>Log In</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="Design/design.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
    
<div class="container">
    <div class="row align-items-start">
        <header>
            <div class="block1">

            </div>
            <div class="block2">

            </div>
        </header>
    </div>
    
    <div class="row align-items-center">
        <h2 style="text-align: center; margin-top: 10%; margin-bottom: 2%">Welcome to the Inventory Management System</h2>
        <h3 style="text-align: center; margin-bottom: 8%">The Only Inventory You'll Ever Need !</h3>
        <form class="form-horizontal" action="index.php" method="post">
            <div class="form-group">
                <label class="control-label col-sm-offset-1 col-sm-2" for="username">User Name:</label>
                <div class="col-sm-6">          
                    <input type="text" class="form-control" style="border-color: #5380b7;" id="username" id="username" placeholder="Enter User Name" name="username" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-offset-1 col-sm-2" for="password">Password:</label>
                <div class="col-sm-6">          
                    <input type="text" class="form-control" style="border-color: #5380b7;" id="password" placeholder="Enter Password" name="password" required>
                </div>
             
            </div>
            
            <div class="form-group">
            
                <div class="col-sm-offset-5 col-sm-7" style="padding-top: 2%">
                    <button type="submit" name="submit" value="Login" class="col-sm-2 btn btn-default btn-lg" style="border-color: #5380b7; color: #5380b7;">Login</button>
                </div>
            
            </div>  
                        <?php
                if(isPostRequest())
                    {
                        echo 
                        '<div style="width:50%; margin:auto;">
                            <div class="alert alert-dismissible alert-danger">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Login Failed</strong> check your spelling
                            </div>
                        </div>';
                    } 
            ?>
            
        </form>
    </div>
        
   
</div>
</body>
</html>
