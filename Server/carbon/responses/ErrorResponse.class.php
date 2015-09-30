<?php

require_once __DIR__ . '/Response.class.php';

/**
 * Implementation of the Response class that deals with Error handling.
 */
class ErrorResponse extends Response {

    /**
     * ErrorResponse constructor.
     * @param string $message Error message to be returned.
     * @param Any $data Data that is passed along with the message.
     */
    public function __construct($message, $data = NULL) {
        parent::__construct(Response::ERROR, $message, $data);
    }

}
