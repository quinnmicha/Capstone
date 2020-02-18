
function addFunction(){
    // Get the modal
    var modal = document.getElementById("addModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal
    modal.style.display = "block";


    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    };
}

function orderFunction(){

    var th = document.getElementById("numSelectTh");
    var td = document.getElementsByClassName("numSelectTd");

    // When the user clicks on the button, display the selector
    th.style.display = "table-cell";
    
    var x = 0;
    for(x = 0; x < td.length; x++){
        td[x].style.display = "table-cell";
    }
    
}

function closeOrderModal(){
    var modal = document.getElementById("confirmOrderModal");
    modal.style.display = "none";
}

function confirmOrder(){
    // Get the modal
    var modal = document.getElementById("confirmOrderModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[2];

    // When the user clicks on the button, open the modal
    modal.style.display = "block";
    
    //Loops through the number pickers
    var output="";
    $("input[name=quantity").each(function(index){
        
        if($(this).val()>1){
            output+="<tr>";
            output+='<td>' + $(this).data("name") + '</td>';
            output+='<td>' + $(this).val() + '</td>';
            output+='</tr>';
            $("#purchaseConfirmOutput").html(output);
            $.post( "../InventoryManager/Model/purchase.php", { id: $(this).data("idItem"), unitPrice: $(this).data("unitPrice"), purchaseAmount: $(this).val() } );
        }
        
    });

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    };
}

function closeConfirmOrder(){
    var modal = document.getElementById("confirmOrderModal");
    var th = document.getElementById("numSelectTh");
    var td = document.getElementsByClassName("numSelectTd");
    
    modal.style.display = "none";
    th.style.display = "none";
    for(var x = 0; x < td.length; x++){
        td[x].style.display = "none";
    }
}

function deleteFunction(){

    var th = document.getElementById("delSelectTh");
    var td = document.getElementsByClassName("delSelectTd");

    // When the user clicks on the button, display the selector
    th.style.display = "table-cell";
    
    var x = 0;
    for(x = 0; x < td.length; x++){
        td[x].style.display = "table-cell";
    }
    
}

function closeDelModal(){
    var modal = document.getElementById("confirmDelModal");
    modal.style.display = "none";
}

function confirmDel(){
    // Get the modal
    var modal = document.getElementById("confirmDelModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[3];

    // When the user clicks on the button, open the modal
    modal.style.display = "block";


    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    };
}

function closeConfirmDel(){
    var modal = document.getElementById("confirmDelModal");
    var th = document.getElementById("delSelectTh");
    var td = document.getElementsByClassName("delSelectTd");
    
    modal.style.display = "none";
    th.style.display = "none";
    for(var x = 0; x < td.length; x++){
        td[x].style.display = "none";
    }
}

function editFunction(){
    // Get the modal
    var modal = document.getElementById("editModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[1];

    // When the user clicks on the button, open the modal
    modal.style.display = "block";


    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    };
}

function outputForPurchaseConf(){
    
}
