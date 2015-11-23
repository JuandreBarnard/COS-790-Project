<?php

require_once __DIR__ . '/../../../carbon/core.ini.php';
require_once __DIR__ . '/../../../carbon/requests/requests.inc.php';
require_once __DIR__ . '/../../../carbon/responses/responses.inc.php';
require_once __DIR__ . '/../../../carbon/formats/formats.inc.php';
require_once __DIR__ . '/../../../src/restaurant/restaurant.php';

try{
    $db = $config->getDefaultDatabase()->open();
    
    $restaurantInfo = [
        'id' => Request::REQUIRED,
        'restaurantName' => Request::REQUIRED,
        'restaurantDesc' => Request::REQUIRED,
        'restaurantStreet' => Request::REQUIRED,
        'restaurantCity' => Request::REQUIRED,
        'restaurantProvince' => Request::REQUIRED,
        'restaurantCountry' => Request::REQUIRED,
        'lattitude' => Request::REQUIRED,
        'longitude' => Request::REQUIRED
    ];

    $request = new StandardRequest();
    $restaurantInfo = $request->extract($restaurantInfo);
    $restaurantInfo = arrayToJSONObject($restaurantInfo);

    $response = updateRestaurant($db, $restaurantInfo);
    
} catch (Exception $ex) {
    $response = new ExceptionResponse($ex);
}

$response = new JSONPrettyFormat($response);
$response->present();
