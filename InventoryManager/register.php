<?php

include_once __DIR__. "/Model/includes/functions.php";
//include_once __DIR__. "/../Model/model_movies.php";

//session_start();
/*
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
    //var_dump($username);
   // var_dump($password);
//}


    
?>   
<html lang="en">
<head>
  <title>Log In</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="Design/design.css">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <!--<script type="text/javascript" src='../InventoryManager/Model/validation.js'></script>-->
</head>
<body>
<?php include __DIR__.'/model/navbar.php';?>

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
        <form class="form-horizontal" action="register.php" method="post">
            <div class="form-group">
                <label class="control-label col-sm-offset-1 col-sm-2" for="user name">User Name:</label>
                <div class="col-sm-6">          
                    <input type="text" class="form-control" id="username" placeholder="Enter User Name" name="username" >
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-offset-1 col-sm-2" for="password">Password:</label>
                <div class="col-sm-6">          
                    <input type="text" class="form-control" id="password" placeholder="Enter Password" name="password" >
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-offset-1 col-sm-2" for="confirm_password">Confirm Password:</label>
                <div class="col-sm-6">          
                    <input type="text" class="form-control is-invalid" id="confirm_password" placeholder="Confirm Password" name="confirm_password" >
                </div>
            </div>
            <div class="form-group">        
                <div class="col-sm-offset-4 col-sm-8">
                    <button type="submit" name="submit" onclick='return checkData()' value="Register" class="col-sm-offset-2 col-sm-2 btn btn-default btn-lg">Sign Up</button>
                </div>
            </div>    
        </form>
    </div>
    <div class="footer row align-items-end">
        <script>
            var user = $("username");
            var pass = $("#password");
            var confPass = $("#confirm_password");
            var all = (user, pass, confPass);
            $("input").blur( function() {
                if($(this).val()===""){
                    $(this).addClass('form-control is-invalid');
                }
              });
            function checkData(){
                
            }
        </script>
            
    </div>
        
   
</div>
</body>
</html>    
    
