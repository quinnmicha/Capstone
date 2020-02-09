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
    /*var_dump($username);
    var_dump($password);
    var_dump($usertype);*/
}

/*if($_SESSION['submit'] == 'Register'){
        header('Location: register.php');
    }*/
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
  

</head>
<body>
    
<div class="container">
    <div>
            <div class="block1">
                    
            </div>
            <div class="block2">
                    
            </div>
    </div>
    
    <div class="row nav" style="margin-top: 2%;">
        
        <div class="nav-item col-sm-2" style="text-align: center; margin-top: 1%;">
            <a href="manager_home.php" class="">Home</a>
        </div>
        <div class="nav-item col-sm-2" style="text-align: center; margin-top: 1%;">
            <a href="register.php" class="">Add User</a>
        </div>
        <div class="form col-sm-4">
            <form>
                <div class="form-row">
                    <div class="col-9">
                        <input class="form-control" type="search" placeholder="Search Inventory" aria-label="Search">
                    </div>
                    <div class="col-3">
                        <button class="btn btn-outline-success" style="border-color: #5380b7; color: #5380b7; background-color: white;" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="nav-item col-sm-2" style="text-align: center; margin-top: 1%;">
            <a href="reports.php" class="">Reports</a>
        </div>
        <div class="nav-item col-sm-2" style="text-align: center; margin-top: 1%;">
            <a href="index.php" class="">Log Out</a>
        </div>      
    </div>
    
    <div style="text-align: center; margin-top: 2%;">
        <h2>Liquor Store Inventory</h2>
    </div>
    
    <div class="row justify-content-around" style="margin-top: 2%;">
        <div class="col-sm-offset-1 col-sm-3">
            <div class="card card-border">
                <div class="card-header">
                    <h4>Best Selling</h4>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">Cras justo odio</li>
                  <li class="list-group-item">Dapibus ac facilisis in</li>
                  <li class="list-group-item">Vestibulum at eros</li>
                </ul>
            </div>
        </div>
        <div class="col-sm-offset-1 col-sm-3">
           
            <div class="card card-border">
                <div class="card-header">
                    <h4>Low Inventory</h4>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">Cras justo odio</li>
                  <li class="list-group-item">Dapibus ac facilisis in</li>
                  <li class="list-group-item">Vestibulum at eros</li>
                </ul>
            </div>
        </div>
        <div class=" col-sm-offset-1 col-sm-3">
            
            <div class="card card-border">
                <div class="card-header">
                    <h4>Recent Sales</h4>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">Cras justo odio</li>
                  <li class="list-group-item">Dapibus ac facilisis in</li>
                  <li class="list-group-item">Vestibulum at eros</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="row" style="margin-top: 2%;">
        <h4>Inventory</h4>
  
        <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th></th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>


                <?php// foreach ($movies as $row): ?>
                    <tr>
                        <td><?php //echo $row['id']; ?>a</td>
                        <td><input type="hidden" name="i-d" value="<?php //echo $row['id'] ?>" /></td>
                        <td><?php// echo $row['MovieName']; ?>b</td>
                        <td><?php// echo $row['ReleaseDate']; ?>c</td>
                        <td><?php// echo $row['Description']; ?>d</td>
                        <td><?php// echo $row['Image']; ?>e</td>
                        <td><a class="btn" style="color:#5380b7; border-color: #5380b7;"href="edit.php?id=<?php// echo $row['id']; ?>">Edit</a></td>
                    </tr>
                <?php// endforeach; ?>
                </tbody>
            </table>

            <br />
            <!--<a href="admin_home.php">Home</a>-->
            <a href="#">Home</a>
        </div>
   
</div>
</body>
</html>

