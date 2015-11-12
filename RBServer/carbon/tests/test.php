<?php

require_once __DIR__ . '/../core.ini.php';
require_once __DIR__ . '/../requests/requests.inc.php';
require_once __DIR__ . '/../responses/responses.inc.php';
require_once __DIR__ . '/../formats/formats.inc.php';

try {

    $databases = $config->getDatabases();
    
    foreach($databases as $alias => $db){
        $db->open();
    }
    
    $response = new SuccessResponse('All tests passed.');
} catch (Exception $ex) {
    $response = new ExceptionResponse($ex);
}

$response = new JSONPrettyFormat($response);
$response->present();