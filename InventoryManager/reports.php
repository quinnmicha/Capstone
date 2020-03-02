<?php

include_once __DIR__. "/Model/includes/functions.php";
include __DIR__ . '/Model/model_inventory.php';

session_start();

if( isset($_SESSION["usertype"])){
    if($_SESSION["usertype"]=="admin"){
        //Gets the most recent week from the sales and purchasing table
        $salesWeek = getWeekSale();//Most recent week in sales table
        $purchaseWeek = getWeek();//Most recent week in purchasing table
        if($salesWeek['week']>$purchaseWeek['week']){
            $currentWeek = $salesWeek['week'];
        }
        else{
            $currentWeek = $purchaseWeek['week'];
        }
        //
        
        if(isPostRequest()){
            $action = filter_input(INPUT_POST, 'action');               //Checks if the POST is for the adding an Item
            if($action === "thisWeek"){
                $_SESSION["graphWeek"]= $currentWeek;
                $_SESSION["graphType"]= "bar";
            }
            else if($action === "lastWeek"){
                $_SESSION["graphWeek"]= $currentWeek - 1;
                $_SESSION["graphType"]= "bar";
            }
            else if($action === "YTD"){
                $_SESSION["graphWeek"]= "YTD";
                $_SESSION["graphType"]= "line";
            }
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>

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
                        <input class="form-control" type="text" placeholder="Search Inventory" aria-label="Search">
                    </div>
                    <div class="col-3">
                        <input class="btn btn-outline-success" style="border-color: #5380b7; color: #5380b7; background-color: white;" type="submit" value="search">
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
   <div class="row justify-content-center" style="margin-top: 6%;"><h1>Reports</h1></div>
   <div class="row justify-content-start" style="margin-top: 4%;">
       <div class="col-2">
           <form action="reports.php" method="get">
               <input type="hidden" name="action" value="YTD" />
               <button class="btn btn-outline-success" id="YTD" style="border-color: #5380b7; color: #5380b7; background-color: white; width: 100%;" type="submit">YTD</button>
           </form>
       </div>
       <div class="col-2">
           <form action="reports.php" method="get">
               <input type="hidden" name="action" value="thisWeek" />
               <button class="btn btn-outline-success" id="thisWeek" data-week="<?php echo $currentWeek;?>" style="border-color: #5380b7; color: #5380b7; background-color: white; width: 100%;" type="submit">This Week</button>
           </form>
       </div>
       <div class="col-2">        
           <form action="reports.php" method="get">
               <input type="hidden" name="action" value="lastWeek" />
               <button class="btn btn-outline-success" id="lastWeek" style="border-color: #5380b7; color: #5380b7; background-color: white; width: 100%;" type="submit">Last Week</button>
           </form>
       </div>
       
       
       
   </div>
   
   
   
    <canvas class="mt-4" id="barGraph" width="400" height="100"></canvas><!--bar-->
    <canvas class="mt-4" id="lineGraph" width="400" height="100"></canvas><!--line-->
   
   <div class="row" style="margin-top: 4%;">
        <table class="table" id="invTable">
                <thead class="thead-light-blue">
                    <tr>
                        <th style="text-align: center; display:none;">ID</th>
                        <th></th>
                        <th><button type="button" class="sort-btn" onclick="sortBy(1)">Name</button></th>
                        <th><button type="button" class="sort-btn" onclick="sortBy(2)">Unit Price</button></th>
                        <th><button type="button" class="sort-btn" onclick="sortBy(3)">Sales Price</button></th>
                        <th><button type="button" class="sort-btn" onclick="sortBy(4)">Par Amount</button></th>
                        <th><button type="button" class="sort-btn" onclick="sortBy(5)">Current Amount</button></th>
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
                            else if(($item['amount']/$item['parAmount']*100)<50){//Yellow if 50% or above, Red if bellow 50%
                                $color = 'table-danger';//bootstrap background color red
                            }
                            else{
                                $color = 'table-warning';//boostrap background color yellow
                            }
                        }
                    ?>
                    <tr id="colorRow" class="<?php echo $color; ?>">
                        <td><input type="hidden" name="i-d" value="<?php echo $item['idItem'] ?>" /></td>
                        <td style="text-align: left;">
                            <!-- Trigger the modal with a button -->
                            <button type="button" id="editBtn" class="reg-btn editBtn" data-id-item="<?php echo $item['idItem'] ?>" data-name="<?php echo$item['name'] ?>" data-sales-price="<?php echo number_format($item['salesPrice'], 2);?>" data-unit-price="<?php echo number_format($item['unitPrice'], 2) ?>" data-current-amount="<?php echo$item['amount'] ?>" data-par-amount="<?php echo$item['parAmount'] ?>" onclick="editFunction()"><?php echo$item['name'] ?></button>
                            <script>
                            //editFunction Script
                            $(".editBtn").click(function(){
                                id = $(this).data('idItem');
                                name = $(this).data("name");
                                unitCost = $(this).data("unitPrice");
                                salesCost = $(this).data("salesPrice");
                                currentAmount = $(this).data("currentAmount");
                                parAmount = $(this).data("parAmount");
                                console.log($(this).data("name"));

                                //Sets the modal info with the current info
                                $("#idEdit").val(id);
                                $("#itemNameEdit").val(name);
                                $("#amountEdit").val(currentAmount);
                                $("#unitCostEdit").val(unitCost);
                                $("#salesPriceEdit").val(salesCost);
                                $("#parAmountEdit").val(parAmount);

                            });
                            </script>
                            <!-- Modal -->
                            <div class="modal" id="editModal">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div>
                                       <span class="close" style="display: none;">&times;</span> 
                                    </div>
                                    <form action="manager_home.php" method="POST">
                                        <div class="modal-body container-fluid">
                                            <div class="form-group">
                                                <div class="form-row">
                                                    <input type="hidden" name="action" value ="editItem">
                                                    <input type="hidden" id="idEdit" name="idEdit" value="">
                                                    <label class="control-label" for="itemNameEdit">Item Name:</label>
                                                    <input type="text" class="form-control" style="border-color: #5380b7;" id="itemNameEdit" value=""  name="itemNameEdit" >
                                                    <div class="invalid-feedback">Please type the item's name.</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-row">
                                                    <label class="control-label" for="amountEdit">Current Amount in Inventory:</label>        
                                                    <input type="text" class="form-control" style="border-color: #5380b7;" id="amountEdit"  value=""  name="amountEdit" >
                                                    <div class="invalid-feedback">Please enter your Current Inventory Amount as a whole number.</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-row">
                                                    <label class="control-label" for="unitCostEdit">Unit Cost:</label>        
                                                    <input type="text" class="form-control" style="border-color: #5380b7;" id="unitCostEdit"  name="unitCostEdit" >
                                                    <div class="invalid-feedback">Please enter a unit price. Only use numbers and one decimal point</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-row">
                                                    <label class="control-label" for="salesPriceEdit">Sales Price:</label>        
                                                    <input type="text" class="form-control" style="border-color: #5380b7;" id="salesPriceEdit" name="salesPriceEdit" >
                                                    <div class="invalid-feedback">Please enter a sales price. Only use numbers and one decimal point</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-row">
                                                    <label class="control-label" for="parAmountEdit">Par Amount:</label>        
                                                    <input type="text" class="form-control" style="border-color: #5380b7;" id="parAmountEdit" name="parAmountEdit" >
                                                    <div class="invalid-feedback">Please enter your Par Amount as a whole number.</div>
                                                </div>
                                            </div>					
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success" onclick='return checkDataEdit()' id="submitEdit">Submit Changes</button>
                                                
                                        </div>
                                    </form>                                   
                                </div>           
                            </div>
                        </td>
                        <td>$<?php echo number_format($item['unitPrice'], 2) ?></td>
                        <td>$<?php echo number_format($item['salesPrice'], 2) ?></td>
                        <td><?php echo$item['parAmount'] ?></td>
                        <td><?php echo$item['amount'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
   <script>
      
   </script>
   <script>
     //Show Individual week bar graph
        function displayWeek(week){
           $.get("../InventoryManager/ajaxProfitByWeek.php", { week: week}, function (data) {
            profitData = $.parseJSON(data);
             console.log(profitData);
             
             var ctx = document.getElementById('lastWeek').getContext('2d');
             var myChart = new Chart(ctx, {
                 type: 'bar',
                 data: {
                   labels: ['expenses', 'revenue'],
                   datasets: [
                    {
                       label: ['expenses', 'revenue'],
                       data: [profitData[0][0], profitData[1][0]],
                       backgroundColor: ['rgba(240, 41, 41, 0.5)','rgba(77, 240, 41, 0.5)']
                    }
                    ]
                },
                 options: {
                    maintainAspectRatio: false,
                   legend: { display: false },
                   title: {
                     display: true,
                     text: 'Last Week Report: Week ' + profitData[2][0] 
                   },
                   scales: {
                         yAxes: [{
                             ticks: {
                                 beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            });
       });   
    
           $.get("../InventoryManager/ajaxProfitYTD.php", function (data) {
            profitData = $.parseJSON(data);
             console.log(profitData);
             var week =[];
             var profit =[];
             var color =[];
             totalProfit=0;
             for(i in profitData[0]){
                 week.push(profitData[0][i]);
             }
             for(i in profitData[1]){
                //.toFixed kept throwing an error on neitServer
                profit.push(parseFloat(profitData[1][i]).toFixed(2));
                //Bellow is the fix without .toFixed
                //profit.push(profitData[1][i]);
                 totalProfit+=profit[i];
             }
             if (totalProfit>0){
                     console.log(profit[i]);
                     color.push('rgba(77, 240, 41, 0.5)');
                 }
                 else{
                     color.push('rgba(240, 41, 41, 0.5)');
                 }
             var ctx = document.getElementById('lineGraph').getContext('2d');
             var myChart = new Chart(ctx, {
                 type: 'line',
                 data: {
                   labels: week,
                   datasets: [
                    {
                       label: "profit",
                       data: profit,
                       backgroundColor: color,
                    }
                    ]
                },
                 options: {
                    maintainAspectRatio: false,
                   legend: { display: false },
                   title: {
                     display: true,
                     text: 'Weekly Profit'
                   },
                   scales: {
                         yAxes: [{
                             ticks: {
                                 beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            });
       });
   </script>
   
   
</div>
</body>
</html>

