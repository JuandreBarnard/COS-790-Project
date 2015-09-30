<?php

require_once __DIR__ . '/Response.class.php';

/**
 * Implementation of the Response class that deals with Warning responses.
 */
class WarningResponse extends Response {

    /**
     * WarningResponse constructor.
     * @param string $message Warning message to be returned.
     * @param Any $data Data that is passed along with the message.
     */
    public function __construct($message, $data = NULL) {
        parent::__construct(Response::WARNING, $message, $data);
    }

}
