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
   
   <canvas class="mt-4" id="myChart" width="400" height="400"></canvas>
   <script>
       $(document).ready(function(){
           $.get("ajaxProfitYTD.php", function (data) {
            profitData = $.parseJSON(data);
             //votes = $.parseJSON(votes);
             var week =[];
             var profit =[];
             var color =[];
             totalProfit=0;
             for(i in profitData[0]){
                 week.push(profitData[0][i]);
             }
             for(i in profitData[1]){
                 profit.push(profitData[1][i].toFixed(2));
                 totalProfit+=profit[i];
             }
             if (totalProfit>0){
                     console.log(profit[i]);
                     color.push('rgba(77, 240, 41, 0.5)');
                 }
                 else{
                     color.push('rgba(240, 41, 41, 0.5)');
                 }
             var ctx = document.getElementById('myChart').getContext('2d');
             var myChart = new Chart(ctx, {
                 type: 'line',
                 data: {
                   labels: week,
                   datasets: [
                    {
                       label: "week",
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

