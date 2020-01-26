<?php
    include('db.php');
    
    //Takes in user and pass, hashes pass, and comes back true or false
    function Login($user, $pass) {
        global $db;
        $pass = sha1($pass);
        echo $pass;
        $dbLogin = false;
        $stmt = $db->prepare("SELECT username, password, `group` FROM login_inventory WHERE user = :user && password = :pass");   
        
        $binds = array(
                    ":user" => $user,
                    ":pass" => $pass
                );
 
        if ( $stmt->execute($binds) && $stmt->rowCount() > 0 ) {
             $dbLogin = true;
                        
         }
         return ($dbLogin);
    }
    
    //registers user after js confirms it is correct
    function register($user, $pass, $group){
        global $db;
        $pass = sha1($pass);
        $success = false;
        $stmt= $db->prepare("INSERT INTO login_inventory (username, password, `group`) VALUES (:user, :pass, :group)");
        
        $binds = array(
            ":user" => $user,
            ":pass" => $pass,
            ":group" => $group
        );
        
        if ($stmt->execute($binds) && $stmt->rowCount() >0){
            $success = true;
        }
        return ($success);
    }
    
    //checks if Post request
    function isPostRequest() {
        return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' );
    }
    //checks if Get request
    function isGetRequest() {
        return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'GET' );
    }
    
    $test= register('test','test','admin');
    echo $test;
?>