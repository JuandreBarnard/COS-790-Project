<?php

require_once __DIR__ . '/../../../src/api/api.inc.php';
require_once __dir__ . '/../../../src/account/account.php';

try{
    // 1. Open DB.
    $db = $config->getDefaultDatabase()->open();
    
    $user = [
        'firstname' => Request::REQUIRED,
        'lastname' => Request::REQUIRED,
        'displayname' => Request::REQUIRED,
        'email' => Request::REQUIRED,
        'password' => Request::REQUIRED,
        'type' => Request::REQUIRED,
        'gcmregid' => Request::REQUIRED
    ];

    $request = new StandardRequest();
    $user = $request->extract($user);
    $user = arrayToJSONObject($user);

    // 5. Get Email Data
    $response = registerUser($db, $user);
} catch (Exception $ex) {
    $response = new ExceptionResponse($ex);
}

$response = new JSONPrettyFormat($response);
$response->present();
