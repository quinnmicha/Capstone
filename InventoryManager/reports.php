<?php

include_once __DIR__. "/Model/includes/functions.php";
include __DIR__ . '/Model/model_inventory.php';

session_start();

if( isset($_SESSION["usertype"])){
    if($_SESSION["usertype"]=="admin"){
        //Gets the most recent week from the sales and increments
        $salesWeek = getWeekSale();//Most recent week in sales table
        $currentWeek = getWeek();//Most recent week in purchasing table
        if($salesWeek['week']===$currentWeek['week']){//Increases the current week only if there is already sales for the week
            $currentWeek['week']++;
        }
        
        $inventory = getInventoryOrderedLow();//Pull ordered Inventory
        //Setting the Cards
        //
        //Set Low inventory card
        $lowInventory= array();
        for($i=0;$i<3;$i++){
            if ($inventory[$i]['orderAmount']<100){
                array_push($lowInventory, $inventory[$i]['name']);
            }
            else{
                array_push($lowInventory, '');//adds empty string to array incase less than three items are low
            }
        }
        //Sets the best selling Card
        $bestSelling = getBestSellingLastWeek($salesWeek['week']);//Pulls the most beers sold in the most recent week ordered by most sold
        $count = count($bestSelling); //Pulls back 1 if 1
        if(count($bestSelling)<3){
            $count;
            $bestSelling += [ $count => ['name' => ""]];
            $count++;
            $bestSelling += [ $count => ['name' => ""]];
        }
        //Sets the Highest Profit Card
        $highestProfit = getHighestProfitLastWeek($salesWeek['week']);
        if(count($highestProfit)<3){
            $count;
            $highestProfit += [ $count => ['name' => "", 'totalProfit' => ""]];
            $count++;
            $highestProfit += [ $count => ['name' => "", 'totalProfit' => ""]];
        }
        
        if(isPostRequest()){
            $action = filter_input(INPUT_POST, 'action');               //Checks if the POST is for the adding an Item
            if($action === 'addItem'){
                $itemName = filter_input(INPUT_POST, 'itemName');
                $unitCost = filter_input(INPUT_POST, 'unitCost');
                $salesPrice = filter_input(INPUT_POST, 'salesPrice');
                $parAmount = filter_input(INPUT_POST, 'parAmount');
                addItem($itemName, $unitCost, $parAmount, $salesPrice);
            }
            else if($action === 'purchaseItem'){
                $count = count($_SESSION["itemId"]);
                if($count>0){
                    for( $i=0; $i<$count; $i++){
                        $answer = purchaseItem($_SESSION["itemId"][$i], $_SESSION["unitPrice"][$i], $_SESSION["purchaseAmount"][$i], $currentWeek['week']);
                    }
                }
                $_SESSION["itemId"] = array();
                $_SESSION["unitPrice"] = array();
                $_SESSION["purchaseAmount"] = array();
            }
            else if ($action === 'editItem'){
                $itemId = filter_input(INPUT_POST, 'idEdit');
                $itemName = filter_input(INPUT_POST, 'itemNameEdit');
                $amount = filter_input(INPUT_POST, 'amountEdit');
                $unitCost = filter_input(INPUT_POST, 'unitCostEdit');
                $salesPrice = filter_input(INPUT_POST, 'salesPriceEdit');
                $parAmount = filter_input(INPUT_POST, 'parAmountEdit');
                updateItem($itemId, $itemName, $amount, $unitCost, $salesPrice, $parAmount);
            }
            else if ($action === 'delItem'){
                $itemId = filter_input(INPUT_POST, 'idDel');
                deleteItem($itemId);
            }
        }
        
        
        
    }
    else{
        header('Location: ../InventoryManager/index.php');
    }
}
else{
        header('Location: ../InventoryManager/index.php');
    }

/*if($_SESSION['submit'] == 'Register'){
        header('Location: register.php');
    }*/
?>

<html lang="en">
<head>
  <title>Reports</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css">
  <link rel="stylesheet" href="Design/design.css">
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script type="text/javascript" src="Model/modal.js"></script>

</head>
<body>
    
<?php include __DIR__.'/model/navbar.php';?>    
<div class="container">
    
    <div class="row nav" style="margin-top: 1%;">
        
        <div class="nav-item col-sm-2" style="margin-top: 1%;">
            <a href="manager_home.php"><b>Home</b></a>
        </div>
        <div class="nav-item col-sm-2" style="margin-top: 1%;">
            <a href="register.php"><b>Add User</b></a>
        </div>
        <div class="form col-sm-4">
            <form>
                <div class="form-row">
                    <div class="col-9">
                        <input class="form-control" type="hidden" placeholder="Search Inventory" aria-label="Search">
                    </div>
                    <div class="col-3">
                        <input class="btn btn-outline-success" style="border-color: #5380b7; color: #5380b7; background-color: white;" type="hidden" value="search">
                    </div>
                </div>
            </form>
        </div>
        <div class="nav-item col-sm-2" style="text-align: right; margin-top: 1%;">
            <a href="reports.php"><b>Reports</b></a>
        </div>
        <div class="nav-item col-sm-2" style="text-align: right; margin-top: 1%;">
            <a href="index.php?action=false"><b>Log Out</b></a>
        </div>      
    </div>
    
    
   <!--/header ----------------------------------------------------------------> 
   
   
   
   
</div>
</body>
</html>

