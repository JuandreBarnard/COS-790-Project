function submitDelivery(){
    deliveryMan = $('#deliveryMan').val();
    deliveryCode = $('#deliveryCode').val();
    lattitude = $('#lattitude').val();
    longitude = $('#longitude').val();
    
    $.post("../api/private/restaurant/create_delivery.api.php", { 
        delivery_man_id: deliveryMan,
        order_number: deliveryCode,
        lattitude: lattitude,
        longitude: longitude
    })
    .done(function( data ) {
        console.log(data);
        if(data.type === "SUCCESS"){
            $("#submit-button").html(data.message);
            $("#submit-button").removeClass("btn-primary");
            $("#submit-button").addClass("btn-success");
            
            $('#deliveryMan').val(0);
            $('#deliveryCode').val("");
            $('#lattitude').val("");
            $('#longitude').val("");
            
            location.reload();
        }
        else{
            
        }
    });
}

function deleteDelivery(delivery_id){
    $.post("../api/private/restaurant/delete_delivery.api.php", { 
        delivery_id: delivery_id
    })
    .done(function( data ) {
        console.log(data);
        if(data.type === "SUCCESS"){
            location.reload();
        }
        else{
            
        }
    });
}