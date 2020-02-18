$(document).ready(function(){
    $("#itemName").blur(function() {
        if($(this).val()!=""){
          $(this).addClass('is-valid');
          $(this).removeClass('is-invalid');
        }
        else{
          $(this).addClass('is-invalid');
          $(this).removeClass('is-valid');
        }
    });
    $("#unitCost").blur(function() {
        if((parseFloat($(this).val())>=parseFloat('0.01')) && ($(this).val()!="")){
          $(this).addClass('is-valid');
          $(this).removeClass('is-invalid');
        }
        else{
          $(this).addClass('is-invalid');
          $(this).removeClass('is-valid');
        }
    });
    $("#salesPrice").blur(function() {
        if((parseFloat($(this).val())>=parseFloat('0.01')) && ($(this).val()!="")){
          $(this).addClass('is-valid');
          $(this).removeClass('is-invalid');
        }
        else{
          $(this).addClass('is-invalid');
          $(this).removeClass('is-valid');
        }
    });
    $("#parAmount").blur(function() {
        if((parseInt($(this).val())>=parseInt('1')) && ($(this).val()!="")){
          $(this).addClass('is-valid');
          $(this).removeClass('is-invalid');
        }
        else{
          $(this).addClass('is-invalid');
          $(this).removeClass('is-valid');
        }
    });
    /*$("#submitAdd").click (function (e) {
        var name = $("input[name='name']").val();
        alert(name);
        $.post ("vote.php", {characterId: $(this).data("characterId")}, function (data) {
            //location.reload(true);
        })
    });*/
});


//Returns true if validated
function checkData(){
    var errorCheck = 0;
    if($("#itemName").val()===""){
        errorCheck++;
    }
    if((parseFloat($("#unitCost").val())>=parseFloat('0.01')) && ($("#unitCost").val()!="")){}
    else{
        errorCheck++;
    }
    if((parseFloat($("#salesPrice").val())>=parseFloat('0.01')) && ($("#salesPrice").val()!="")){}
    else{
        errorCheck++;
    }
    if((parseFloat($("#parAmount").val())>=parseFloat('0.01')) && ($("#parAmount").val()!="")){}
    else{
        errorCheck++;
    }
    
    if(errorCheck>0){
        return false;
        }
    else{ return true; }
  }


