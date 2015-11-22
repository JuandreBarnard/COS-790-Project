package com.cos790.internetofthings.restaurantbuddy;


public interface ApplicationConstants {

    // Php Application URL to store Reg ID created
    //static final String APP_SERVER_URL = "http://10.0.2.1/test/gcm.php?shareRegId=true";
    static final String APP_SERVER_LOGIN = "http://restaurantbuddy.ddns.net:8080/RBServer/api/private/account/login.api.php";
    static final String APP_SERVER_REGISTER = "http://restaurantbuddy.ddns.net:8080/RBServer/api/private/account/register.api.php";
    static final String APP_SERVER_all_restaurant = "http://restaurantbuddy.ddns.net:8080/RBServer/api/private/restaurant/get_all_restaurants.api.php";
    static final String APP_SERVER_by_id = "http://restaurantbuddy.ddns.net:8080/RBServer/api/private/restaurant/get_by_id.api.php";
    static final String APP_SERVER_user_places = "http://restaurantbuddy.ddns.net:8080/RBServer/api/private/restaurant/get_user_places.api.php";
    static final String APP_SERVER_user_by_id = "http://restaurantbuddy.ddns.net:8080/RBServer/api/private/users/get_user_by_id.api.php";
    static final String APP_SERVER_get_user_by_email = "http://restaurantbuddy.ddns.net:8080/RBServer/api/private/users/get_user_by_email.api.php";
    static final String APP_SERVER_create_user = "http://restaurantbuddy.ddns.net:8080/RBServer/api/private/users/create_user.api.php";
    static final String APP_SERVER_create_user_place = "http://restaurantbuddy.ddns.net:8080/RBServer/api/private/restaurant/create_user_place.api.php";
    static final String APP_SERVER_delete_user_place = "http://restaurantbuddy.ddns.net:8080/RBServer/api/private/restaurant/delete_user_place.api.php";
    static final String APP_SERVER_submit_gps = "http://restaurantbuddy.ddns.net:8080/RBServer/api/private/restaurant/submit_gps.api.php";
    static final String APP_SERVER_get_delivery_man_gps = "http://restaurantbuddy.ddns.net:8080/RBServer/api/private/restaurant/get_delivery_man_gps.api.php";
    // Google Project Number create_user.api.php
    static final String GOOGLE_PROJ_ID = "golden-cosmos-112605";
    // Message Key
    static final String MSG_KEY = "m";
}

