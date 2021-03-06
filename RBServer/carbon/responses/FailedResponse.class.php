<?php

require_once __DIR__ . '/Response.class.php';

/**
 * Implementation of the Response class that deals with Failed attemps handling.
 */
class FailedResponse extends Response {

    /**
     * FailedResponse constructor.
     * @param string $message Failed Attempt message to be returned.
     * @param Any $data Data that is passed along with the message.
     */
    public function __construct($message, $data = NULL) {
        parent::__construct(Response::FAILED, $message, $data);
    }

}
