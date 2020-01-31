<?php
    include('db.php');
    
    //Takes in user and pass, hashes pass
    //Pulls back username and group for SESSION
    //Comes back false if fail
    function Login($user, $pass) {
        global $db;
        $pass = sha1($pass);
        $stmt = $db->prepare("SELECT username, `group` FROM login_inventory WHERE username = :user && password = :pass");   
        
        $binds = array(
                    ":user" => $user,
                    ":pass" => $pass
                );
 
        $results = array();
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return ($results);
        }
        else{
            return false;
        }
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
    
    //Adds an item to the inventory table
    //Sets amount to 0 automatically
    function addItem($itemName, $unitPrice, $parNumber){
        global $db;
        $success=false;
        $stmt=$db->prepare("INSERT INTO inventory (name, amount, unitPrice, parAmount) Values (:itemName, 0, :unitPrice, :parNumber)");
        
        $binds = array(
            ":itemName" => $itemName,
            ":unitPrice" => $unitPrice,
            ":parNumber" => $parNumber
        );
        
        if($stmt->execute($binds) && $stmt->rowCount()>0){
            $success=true;
        }
        return($success);
    }
    
    //Pulls the id name amount price par from inventory table
    function getInventory(){
        global $db;
        
        $stmt=$db->prepare("SELECT idItem, `name`, amount, unitPrice, parAmount FROM inventory");
        
        if($stmt->execute() && $stmt->rowCount()>0){
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return ($results);
        }
        else{
            return false;
        }
    }
    
    //Updates the inventory table
    //Is called within other functions
    function updateItem($idItem, $amount){
        global $db;
        
        $stmt=$db->prepare("UPDATE inventory SET amount = :amount WHERE idItem = :idItem");
        
        $binds = array(
            ":amount" => $amount,
            ":idItem" => $idItem
        );
        
        $result=false;
        if($stmt->execute($binds) && $stmt->rowCount()>0){
            $result=true;
        }
        return $result;
    }
    
    //checks if Post request
    function isPostRequest() {
        return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' );
    }
    //checks if Get request
    function isGetRequest() {
        return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'GET' );
    }
    
    $test=updateItem(2,1);
    echo $test;
?>