<?php

require_once __DIR__ . '/../../../carbon/core.ini.php';
require_once __DIR__ . '/../../../carbon/requests/requests.inc.php';
require_once __DIR__ . '/../../../carbon/responses/responses.inc.php';
require_once __DIR__ . '/../../../carbon/formats/formats.inc.php';
require_once __DIR__ . '/../../../src/restaurant/restaurant.php';

try{
    $db = $config->getDefaultDatabase()->open();
    
    $restaurant = [
        'id' => Request::REQUIRED
    ];

    $request = new StandardRequest();
    $restaurant = $request->extract($restaurant);
    $restaurant = arrayToJSONObject($restaurant);

    $response = getRestaurantById($db, $restaurant->id);
} catch (Exception $ex) {
    $response = new ExceptionResponse($ex);
}

$response = new JSONPrettyFormat($response);
$response->present();
