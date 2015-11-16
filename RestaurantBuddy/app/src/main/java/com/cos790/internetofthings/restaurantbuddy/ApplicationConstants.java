package com.cos790.internetofthings.restaurantbuddy;


public interface ApplicationConstants {

    // Php Application URL to store Reg ID created
    //static final String APP_SERVER_URL = "http://10.0.2.1/test/gcm.php?shareRegId=true";
    static final String APP_SERVER_LOGIN = "http://restaurantbuddy.ddns.net:8080/RBServer/api/private/account/login.api.php";
    static final String APP_SERVER_REGISTER = "http://restaurantbuddy.ddns.net:8080/RBServer/api/private/account/register.api.php";
    static final String APP_SERVER_all_restaurant = "http://restaurantbuddy.ddns.net:8080/RBServer/api/private/restaurant/get_all_restaurant.api.php";
    static final String APP_SERVER_by_id = "http://restaurantbuddy.ddns.net:8080/RBServer/api/private/restaurant/get_by_id.api.php";
    static final String APP_SERVER_user_places = "http://restaurantbuddy.ddns.net:8080/RBServer/api/private/restaurant/get_user_places.api.php";
    static final String APP_SERVER_user_by_id = "http://restaurantbuddy.ddns.net:8080/RBServer/api/private/users/get_user_by_id.api.php";
    //static final String APP_SERVER_URL = "http://localhost/test/gcm.php?shareRegId=true";
    // Google Project Number
    static final String GOOGLE_PROJ_ID = "golden-cosmos-112605";
    // Message Key
    static final String MSG_KEY = "m";
}

