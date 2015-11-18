<?php

require_once __DIR__ . '/../../../carbon/core.ini.php';
require_once __DIR__ . '/../../../carbon/requests/requests.inc.php';
require_once __DIR__ . '/../../../carbon/responses/responses.inc.php';
require_once __DIR__ . '/../../../carbon/formats/formats.inc.php';
require_once __DIR__ . '/../../../src/restaurant/restaurant.php';

try{
    $db = $config->getDefaultDatabase()->open();
    
    $relUserPlace = [
        'user_id' => Request::REQUIRED,
        'restaurant_id' => Request::REQUIRED
    ];

    $request = new StandardRequest();
    $relUserPlace = $request->extract($relUserPlace);
    $relUserPlace = arrayToJSONObject($relUserPlace);

    $response = createUserPlace($db, $relUserPlace->user_id, $relUserPlace->restaurant_id);
} catch (Exception $ex) {
    $response = new ExceptionResponse($ex);
}

$response = new JSONPrettyFormat($response);
$response->present();
