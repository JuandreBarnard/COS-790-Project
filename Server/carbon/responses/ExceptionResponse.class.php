<?php

require_once __DIR__ . '/Response.class.php';

/**
 * Implementation of the Response class that deals with Exception handling.
 */
class ExceptionResponse extends Response {

    /**
     * ExceptionResponse Constructor.
     * @param Exception $ex Exception to wrap.
     */
    public function __construct(Exception $ex, $inclStackTrace = true) {
        $data = Array(
            'exception_message' => $ex->getMessage(),
            'exception_line' => $ex->getLine(),
            'exception_file' => $ex->getFile()
        );
        
        if($inclStackTrace){
            //$data['exception_trace'] = $ex->getTrace();
        }

        parent::__construct(Response::EXCEPTION, "Exception was caught.", $data);
    }

}
