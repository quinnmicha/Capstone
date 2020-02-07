<?php
    include('db.php');
    
    //Takes in user and pass, hashes pass
    //Pulls back idUser, username, and group for SESSION
    //Comes back false if fail
    function Login($user, $pass) {
        global $db;
        $pass = sha1($pass);
        $stmt = $db->prepare("SELECT idUser, username, `group` FROM login_inventory WHERE username = :user && password = :pass");   
        
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
    
    //Deletes item from the inventory table
    function deleteItem($idItem){
        global $db;
        
        $stmt=$db->prepare("DELETE FROM inventory WHERE idItem = :idItem");
        
        $binds = array(
            ":idItem" => $idItem
        );
        $result = false;
        if($stmt->execute($binds) && $stmt->rowCount()>0){
            $result = true;
        }
        return $result;
    }
    
    //Will return the most recent week from the purchasing table
    //Must be adjusted on the website to increase weeks for purchasing
    //Returns an array of one int (the max week in the purchasing table)
    //Returns 1 if no purchases
    //Returns null if db doesn't connect
    function getWeek(){
        global $db;
        
        $stmt=$db->prepare("SELECT MAX(week) AS 'week' from purchases");
        
        if($stmt->execute() && $stmt->rowCount()>0){
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            if(empty($results)){
                $results = ['week' => 1];
            }
            return $results;
        }
        else{
            return null;
        }
    }
    
    //Pulls the amount of a certain item for adding or subtracting
    //may not need this function....
    function getAmount($idItem){
        global $db;
        
        $stmt=$db->prepare("SELECT amount FROM inventory WHERE idItem = :idItem");
        
        $binds= array(
            ":idItem"=> $idItem
        );
        
        $results=[];
        if($stmt->execute($binds) && $stmt->rowCount()>0){
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            return $results;
        }
        else{
            return false;
        }
        
    }
    
    /*
    ## getRecentSaleId returns an array ##
    $recentSale= getRecentSaleId();
    $test =getRecentSale($recentSale['idSale']);  << must access value like this
    var_dump($test);
     */
    //Pulls the most recent Sale id for invoice table
    function getRecentSaleId(){
        global $db;
        
        $stmt=$db->prepare("SELECT MAX(idSale) AS 'idSale' from sales"); //<<sets column name from MAX(idSale) to idSale
        
        $results=[];
        if($stmt->execute() && $stmt->rowCount()>0){
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        else{
            $results = false;
        }
        return $results;
    }
    
    
    //Pulls sales data off idSale from sales table
    function getRecentSale($idSale){
        global $db;
        
        $stmt=$db->prepare("SELECT * FROM sales WHERE idSale = :idSale");
        
        $binds = array(
            ":idSale"=>$idSale
        );
        
        $results=[];
        if($stmt->execute($binds) && $stmt->rowCount()>0){
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        else{
            $results = false;
        }
        return $results;
    }
    
    //Pulls most recent purchase id for connecting the invoice table
    function getRecentPurchaseId(){
        global $db;
        
        $stmt=$db->prepare("SELECT MAX(idPurchase)AS idPurchase from purchases");
        
        $results=[];
        if($stmt->execute() && $stmt->rowCount()>0){
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        else{
            $results = false;
        }
        return $results;
    }
    
    //Purchases ITEM
    //adds item to purchases table
    //returns 1 if true 0 if false
    function purchaseItem($idItem, $cost, $amount, $week){ //Seems to be no add() so maybe pull the new amount from the website or call an updateItem()
        global $db;
        
        $stmt=$db->prepare("INSERT INTO purchases (week, idItem, amount, money) VALUES (:week, :idItem, :amount, :money)");
        
        $binds= array (
            ":week" => $week,
            ":idItem" => $idItem,
            ":amount" => $amount,
            ":money" => $cost
        );
        
        if($stmt->execute($binds) && $stmt->rowCount()>0){
            //Run another function on the website to update invoice and inventory table
            return true;
        }
        else{
            return false;
        }
    }
    
    function sellItem($idItem, $money, $amount, $week, $idUser){ //Seems to be no add() so maybe pull the new amount from the website or call an updateItem()
        global $db;
        
        $stmt=$db->prepare("INSERT INTO sales (week, idUser, idItem, amount, money) VALUES (:week, :idUser, :idItem, :amount, :money)");
        
        $binds= array (
            ":week" => $week,
            ":idItem" => $idItem,
            ":amount" => $amount,
            ":idUser" => $idUser,
            ":money" => $money
        );
        
        if($stmt->execute($binds) && $stmt->rowCount()>0){
            //Run another function on the website to update invoice and inventory table
            return true;
        }
        else{
            return false;
        }
    }
    
    //Adds income to the invoices table
    //Pulls the Recent idSale and then adds rect to the invoices table
    function addIncome($week, $money){
        global $db;
        
        $get = getRecentSaleId();
        $idSale=$get['idSale'];
        $stmt =$db->prepare("INSERT INTO invoices (week, revenue, idSale) VALUES (:week, :revenue, :idSale)");
        
        $binds= array(
            ":week"=> $week,
            ":revenue"=> $money,
            ":idSale"=>$idSale
        );
        if($stmt->execute($binds) && $stmt->rowCount()>0){
            return true;
        }
        else{
            return false;
        }
    }
    
    //Adds expense to the invoices table
    //Pulls the Recent idPurchase and then adds rect to the invoices table
    function addExpense($week, $money){
        global $db;
        
        $get = getRecentPurchaseId();
        $idPurchase=$get['idPurchase'];
        $stmt =$db->prepare("INSERT INTO invoices (week, expense, idPurchase) VALUES (:week, :expense, :idPurchase)");
        
        $binds= array(
            ":week"=> $week,
            ":expense"=> $money,
            ":idPurchase"=>$idPurchase
        );
        if($stmt->execute($binds) && $stmt->rowCount()>0){
            return true;
        }
        else{
            return false;
        }
    }
    
    //Pulls the most recent week from purchases table
    //Returns the profit of that week in an array
    //Can be modulated to get Profit of anyweek
    function getProfitLastWeek(){
        global $db;
        
        $get = getWeek();//Pulls most recent week from purchasing table
        $week = $get['week'];
        
        $stmt=$db->prepare("SELECT SUM(revenue) - SUM(expense) AS 'profit' FROM invoices WHERE week = :week");
        
        $binds=array(
            ":week"=>$week
        );
        $results= false;
        if($stmt->execute($binds) && $stmt->rowCount()>0){
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $results;
    }
    
    function getProfitYTD(){
        global $db;
        
        $stmt=$db->prepare("SELECT SUM(revenue) - SUM(expense) AS 'profit' FROM invoices");
        
        $results=false;
        if($stmt->execute() && $stmt->rowCount()>0){
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $results;
    }
    
    //checks if Post request
    function isPostRequest() {
        return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' );
    }
    //checks if Get request
    function isGetRequest() {
        return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'GET' );
    }
    
    $test = getProfitYTD();
    echo $test['profit'];
    
?>