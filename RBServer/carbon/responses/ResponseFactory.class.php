<?php

require_once __DIR__ . '/Response.class.php';
require_once __DIR__ . '/SuccessResponse.class.php';
require_once __DIR__ . '/WarningResponse.class.php';
require_once __DIR__ . '/ErrorResponse.class.php';
require_once __DIR__ . '/FailedResponse.class.php';
require_once __DIR__ . '/ExceptionResponse.class.php';

/**
 * Factory class to parse and return responses.
 */
class ResponseFactory{
    /**
     * Builds a response from JSON String.
     * @param string $response Response string.
     * @return Response
     */
    public function getResponseFromJSONString($response){
        $response = json_decode($response);
        return $this->getResponse($response);
    }
    
    /**
     * Builds a response from JSON Object.
     * @param JSONObject $response Response object.
     * @return Response
     */
    public function getResponseFromJSONObject($response){
        return $this->getResponse($response);
    }
    
    /* Builds a response from an array.
     * @param array $response Response array.
     * @return Response
     */
    public function getResponseFromArray($response){
        $response = arrayToJSONObject($response);
        return $this->getResponse($response);
    }
    
    /**
     * Parses and constructs respective response.
     * @param JSONObject $response Response object;
     * @return Response
     */
    private function getResponse($response){
        switch($response->type){
            case Response::SUCCESS : return new SuccessResponse($response->message, $response->data);
            case Response::WARNING : return new WarningResponse($response->message, $response->data);
            case Response::ERROR : return new ErrorResponse($response->message, $response->data);
            case Response::FAILED : return new FailedResponse($response->message, $response->data);
            case Response::EXCEPTION : {
                $setExceptionTrace = false;
                
                $data = Array(
                    'exception_message' => $response->data->exception_message,
                    'exception_line' => $response->data->exception_line,
                    'exception_file' => $response->data->exception_file
                );
                
                if(isset($response->data->exception_trace)){
                    $setExceptionTrace = true;
                    $data['exception_trace'] = $response->data->exception_trace;
                }
                
                $data = arrayToJSONObject($data);
                
                $ex = new Exception($data->exception_message, $setExceptionTrace);
                return new ExceptionResponse($ex);
            }
            default: return NULL;
        }
    }
}

