<?php

require_once __DIR__ . '/../responses/responses.inc.php';

/**
 * Abstract format class.
 */
abstract class Format {

    /**
     * @var Response Response object.
     */
    protected $response = NULL;

    /**
     * Format constructor.
     * @param Response $response The response to be formatted.
     */
    public function __construct(Response $response) {
        $this->response = $response;
    }

    /**
     * Abstract presentor function.
     */
    public abstract function present();
}
