function updateRestaurant(restaurantId){
    restaurantName = $('#restaurantName').val();
    restaurantDescription = $('#restaurantDesc').val();
    restaurantStreet = $('#restaurantStreet').val();
    restaurantCity = $('#restaurantCity').val();
    restaurantProvince = $('#restaurantProvince').val();
    restaurantCountry = $('#restaurantCountry').val();
    lattitude = $('#lattitude').val();
    longitude = $('#longitude').val();
    
    $.post("../api/private/restaurant/update_restaurant.api.php", { 
        id: restaurantId,
        restaurantName: restaurantName,
        restaurantDesc: restaurantDescription,
        restaurantStreet: restaurantStreet,
        restaurantCity: restaurantCity,
        restaurantProvince: restaurantProvince,
        restaurantCountry: restaurantCountry,
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

function deleteDeliveryMan(user_id, restaurant_id){
    $.post("../api/private/restaurant/delete_delivery_man.api.php", { 
        user_id: user_id,
        restaurant_id: restaurant_id
    })
    .done(function( data ) {
        if(data.type === "SUCCESS"){
            location.reload();
        }
        else{
            
        }
    });
}

function addDeliveryMan(restaurant_id){
    fullname = $("#fullname").val();
    email = $("#email").val();
    password = $("#password").val();
    $.post("../api/private/restaurant/add_delivery_man.api.php", { 
        fullname: fullname,
        email: email,
        password: password,
        restaurant_id: restaurant_id
    })
    .done(function( data ) {
        if(data.type === "SUCCESS"){
            location.reload();
        }
        else{
            
        }
    });
}