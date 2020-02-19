<?php

include_once __DIR__. "/Model/includes/functions.php";
include __DIR__ . '/Model/model_inventory.php';

session_start();

if( isset($_SESSION["usertype"])){
    if($_SESSION["usertype"]=="admin"){
        $salesWeek = getWeekSale();//Most recent week in sales table
        $currentWeek = getWeek();//Most recent week in purchasing table
        $bestSelling = getBestSellingLastWeek($salesWeek['week']);//Pulls the most beers sold in the most recent week ordered by most sold
        if($salesWeek['week']===$currentWeek['week']){//Increases the current week only if there is already sales for the week
            $currentWeek['week']++;
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
        }
        $inventory = getInventoryOrderedLow();
        
        
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
  <title>Log In</title>
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
                        <input class="form-control" type="search" placeholder="Search Inventory" aria-label="Search">
                    </div>
                    <div class="col-3">
                        <button class="btn btn-outline-success" style="border-color: #5380b7; color: #5380b7; background-color: white;" type="submit">Search</button>
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
    
    <!--
    <div style="text-align: center; margin-top: 2%;">
        <h2>Liquor Store Inventory</h2>
    </div>
    -->
    <div class="row justify-content-around" style="margin-top: 6%;">
        <div class="col-sm-offset-1 col-sm-3">
            <div class="card card-border">
                <div class="card-header">
                    <h4>Best Selling</h4>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <!-- Trigger the modal with a button -->
                            <button type="button" class="reg-btn display" onclick="displayFunction()"><?php echo $bestSelling[0]['name']; ?></button>

                            <!-- Modal -->
                            <div class="modal" id="displayModal0">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div>
                                       <span class="closeModal">&times;</span> 
                                    </div>
                                    <div style="text-align: center;">
                                        <p>Some text in the Modal..</p>
                                    </div>                                   
                                </div>           
                            </div>
                    </li>
                    <li class="list-group-item"><?php echo $bestSelling[1]['name']; ?></li>
                    <li class="list-group-item"><?php echo $bestSelling[2]['name']; ?></li>
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
    
    <div class="row justify-content-between" style="margin-top: 4%;">
        <div class="col-3">
            <h3 style="margin-bottom: 0%;">Inventory</h3>
        </div>
        <div id="orderDiv" class="col-3 btn-lg" style="padding:0%; height:100%; display:none;">
            <button class="d-block m-auto" type="button" id="orderBtn" style="color:#5380b7; border-color: #5380b7; border-radius: 7%; background-color: white;" onclick="confirmOrder()">Purchase</button>
        </div>
        <div class="col-3" style="text-align: right;">
            
                <!--Add Button-->
                <button type="button" id="addBtn" class="btn-lg fas fa-plus" style="color:#5380b7; border-color: #5380b7; background-color: white;" onclick="addFunction()"></button>

                <div id="addModal" class="modal">

                  <div class="modal-content">
                      <div>
                          <span class="close">&times;</span>
                      </div>
                      <form action="manager_home.php" method="post">
                            <div class="modal-body container-fluid">
                                <div class="form-group">
                                    <div class="form-row">
                                        <input type="hidden" name="action" value ="addItem">
                                        <label class="control-label" for="itemName">Item Name:</label>
                                        <input type="text" class="form-control" style="border-color: #5380b7;" id="itemName" placeholder="Enter Item Name" name="itemName" >
                                        <div class="invalid-feedback">Please type your User Name.</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <label class="control-label" for="unitCost">Unit Cost:</label>        
                                        <input type="text" class="form-control" style="border-color: #5380b7;" id="unitCost" placeholder='Enter Unit Cost example: 4.50' name="unitCost" >
                                        <div class="invalid-feedback">Please enter a unit price. Only use numbers and one decimal point</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <label class="control-label" for="salesPrice">Sales Price:</label>        
                                        <input type="text" class="form-control" style="border-color: #5380b7;" id="salesPrice" placeholder="Enter Sales Price example: 7.50" name="salesPrice" >
                                        <div class="invalid-feedback">Please enter a sales price. Only use numbers and one decimal point</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <label class="control-label" for="parAmount">Par Amount:</label>        
                                        <input type="text" class="form-control" style="border-color: #5380b7;" id="parAmount" placeholder="Enter Par Amount example: 24" name="parAmount" >
                                        <div class="invalid-feedback">Please enter your Par Amount as a whole number.</div>
                                    </div>
                                </div>					
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" onclick='return checkData()' id="submitAdd">Add Item</button>
                                    <script type="text/javascript" src="Model/addItemModal.js"></script>
                            </div>
			</form>
                  </div>

                </div>
                
                <!--Purchase Button-->
                <button type="button" id="purchaseBtn" class="btn-lg fas fa-shopping-cart" style="color:#5380b7; border-color: #5380b7; background-color: white;" onclick="orderFunction()"></button>

                <!--Delete Button-->
                <button type="button" id="deleteBtn" class="btn-lg fas fa-trash-alt" style="color:#5380b7; border-color: #5380b7; background-color: white;" onclick="deleteFunction()"></button>        
        </div>
    </div>
    <div class="row" style="margin-top: 2%;">
        <table class="table" id="invTable">
                <thead class="thead-light-blue">
                    <tr>
                        <th style="text-align: center; display:none;">ID</th>
                        <th></th>
                        <th>Name</th>
                        <th>Unit Price</th>
                        <th>Sales Price</th>
                        <th>Par Amount</th>
                        <th>Current Amount</th>
                        <th id="numSelectTh">Purchase Amount</th>
                        <th id="delSelectTh">
                            
                        </th>
                    </tr>
                </thead>
                <tbody>


                <?php foreach ($inventory as $item): ?>
                    <?php //To set proper row colors
                        $color='';//default nothing if amount above par
                        if($item['amount']<$item['parAmount']){
                            if($item['amount']===0){//This is to catch error
                                $color = 'table-danger';//bootstrap background color red
                            }
                            else if(($item['amount']/$item['parAmount']*100)<50){
                                $color = 'table-danger';//bootstrap background color red
                            }
                            else{
                                $color = 'table-warning';//boostrap background color yellow
                            }
                        }
                    ?>
                    <tr class="<?php echo $color; ?>">
                        <td><input type="hidden" name="i-d" value="<?php echo $item['idItem'] ?>" /></td>
                        <td style="text-align: left;">
                            <!-- Trigger the modal with a button -->
                            <button type="button" id="editBtn" class="reg-btn" onclick="editFunction()"><?php echo$item['name'] ?></button>

                            <!-- Modal -->
                            <div class="modal" id="editModal">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div>
                                       <span class="close">&times;</span> 
                                    </div>
                                    <div style="text-align: center;">
                                        <p>Some text in the Modal..</p>
                                    </div>                                   
                                </div>           
                            </div>
                        </td>
                        <td>$<?php echo number_format($item['unitPrice'], 2) ?></td>
                        <td>$<?php echo number_format($item['salesPrice'], 2) ?></td>
                        <td><?php echo$item['parAmount'] ?></td>
                        <td><?php echo$item['amount'] ?></td>
                        <td class="numSelectTd">
                            <input class="d-block m-auto" type="number" data-id-item="<?php echo $item['idItem'] ?>" data-name="<?php echo$item['name'] ?>" data-unit-price="<?php echo number_format($item['unitPrice'], 2) ?>" data-current-amount="<?php echo$item['amount'] ?>" id="quantity" name="quantity" min="1" max="25">
                            
                        
                            <div id="confirmOrderModal" class="modal">

                                <div class="modal-content">
                                    <div>
                                      <span class="close">&times;</span>
                                    </div>
                                    <form action="manager_home.php" method="POST">
                                        <input type="hidden" name="action" value ="purchaseItem">
                                        <table class="table" id="invTable">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Purchase</th>
                                                </tr>
                                            </thead>

                                            <tbody id="purchaseConfirmOutput">

                                            </tbody>

                                        </table>
                                        <div style="text-align: center;">
                                          <div>
                                              <button type="submit">Confirm</button>
                                              <button type='button' onclick='closeOrderModal()'>Cancel</button>
                                          </div>
                                        </div>  
                                    </form>

                                </div>

                          </div>
                        </td>
                        <td class="delSelectTd">
                            <button type="button" id="delIcon" class="btn- far fa-trash-alt" style="color:#5380b7; border-color: #5380b7; border-radius: 10%; background-color: white;" onclick="confirmDel()"></button>
                            
                            <div id="confirmDelModal" class="modal">

                            <div class="modal-content">
                                <div>
                                  <span class="close">&times;</span>
                                </div>
    
                                <div style="text-align: center;">
                                  <div>
                                      <p>Are you sure you want to delete this item?</p>
                                  </div>
                                  <div>
                                      <button type="button" onclick="closeConfirmDel()">Confirm</button>
                                      <button type='button' onclick='closeDelModal()'>Cancel</button>
                                  </div>
                                </div>    
                              
                            </div>

                          </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
   
</div>
</body>
</html>

