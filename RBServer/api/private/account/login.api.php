<?php

require_once __DIR__ . '/../../../carbon/core.ini.php';
require_once __DIR__ . '/../../../carbon/requests/requests.inc.php';
require_once __DIR__ . '/../../../carbon/responses/responses.inc.php';
require_once __DIR__ . '/../../../carbon/formats/formats.inc.php';
require_once __DIR__ . '/../../../src/account/account.php';

try{
    // 1. Open DB.
    $db = $config->getDefaultDatabase()->open();
    
    $user = [
        'email' => Request::REQUIRED,
        'password' => Request::REQUIRED
    ];

    $request = new StandardRequest();
    $user = $request->extract($user);
    $user = arrayToJSONObject($user);

    // 5. Try user login
    $response = loginUser($db, $user);
} catch (Exception $ex) {
    $response = new ExceptionResponse($ex);
}

$response = new JSONPrettyFormat($response);
$response->present();
