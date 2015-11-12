<?php

require_once __DIR__ . '/../../../carbon/core.ini.php';
require_once __DIR__ . '/../../../carbon/requests/requests.inc.php';
require_once __DIR__ . '/../../../carbon/responses/responses.inc.php';
require_once __DIR__ . '/../../../carbon/formats/formats.inc.php';
require_once __DIR__ . '/../../../src/restaurant/restaurant.php';

try{
    // 1. Open DB.
    $db = $config->getDefaultDatabase()->open();
    
    $user = [
        'userId' => Request::REQUIRED
    ];

    $request = new StandardRequest();
    $user = $request->extract($user);
    $user = arrayToJSONObject($user);

    // 5. Get User Places
    $response = getUserPlaces($db, $user);
} catch (Exception $ex) {
    $response = new ExceptionResponse($ex);
}

$response = new JSONPrettyFormat($response);
$response->present();
