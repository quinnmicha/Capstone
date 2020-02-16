
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
    var span = document.getElementsByClassName("close")[2];

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