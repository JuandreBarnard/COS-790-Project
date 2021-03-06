<?php

require_once __DIR__ . '/../../../carbon/core.ini.php';
require_once __DIR__ . '/../../../carbon/requests/requests.inc.php';
require_once __DIR__ . '/../../../carbon/responses/responses.inc.php';
require_once __DIR__ . '/../../../carbon/formats/formats.inc.php';
require_once __DIR__ . '/../../../src/account/account.php';

try{
    $db = $config->getDefaultDatabase()->open();
    
    $user = [
        'id' => Request::REQUIRED
    ];

    $request = new StandardRequest();
    $user = $request->extract($user);
    $user = arrayToJSONObject($user);

    $response = getUserById($db, $user->id);
} catch (Exception $ex) {
    $response = new ExceptionResponse($ex);
}

$response = new JSONPrettyFormat($response);
$response->present();
