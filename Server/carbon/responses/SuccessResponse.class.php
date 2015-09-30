<?php

require_once __DIR__ . '/Response.class.php';

/**
 * Implementation of the Response class that deals with Successful responses.
 */
class SuccessResponse extends Response {

    /**
     * SuccessResponse constructor.
     * @param string $message Success message to be returned.
     * @param Any $data Data that is passed along with the message.
     */
    public function __construct($message, $data = NULL) {
        parent::__construct(Response::SUCCESS, $message, $data);
    }

}
