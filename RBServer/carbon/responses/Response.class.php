<?php

require_once __DIR__ . '/../functions/converters.functions.php';

/**
 * Response handler class.
 */
abstract class Response {

    /**
     * @var string Response message.
     */
    private $message = NULL;

    /**
     * @var Any Response return data. 
     */
    private $data = NULL;

    /**
     * @var string Response type. 
     */
    private $type = NULL;

    /**
     * Success response type.
     */
    const SUCCESS = "SUCCESS";

    /**
     * Warning response type.
     */
    const WARNING = "WARNING";

    /**
     * Error response type.
     */
    const ERROR = "ERROR";

    /**
     * Failed response type.
     */
    const FAILED = "FAILED";

    /**
     * Exception response type.
     */
    const EXCEPTION = "EXCEPTION";

    /**
     * Response constructor.
     * @param string $type Response type.
     * @param string Response message.
     * @param Any Response return data. 
     */
    public function __construct($type, $message, $data) {
        $this->type = $type;
        $this->message = $message;
        $this->data = $data;
    }
    
    /**
     * Converts the Response to a JSONObject.
     * @return Object Converted response.
     */
    public function convertToArray() {
        $data = [
            'type' => $this->type,
            'message' => $this->message,
            'data' => $this->data
        ];

        return $data;
    }

    /**
     * Converts the Response to a JSONObject.
     * @return Object Converted response.
     */
    public function convertToJSONObject() {
        $data = [
            'type' => $this->type,
            'message' => $this->message,
            'data' => $this->data
        ];

        return arrayToJSONObject($data);
    }

    /**
     * Converts the Response to a JSON String.
     * @return string Converted Response.
     */
    public function convertToJSONString() {
        $data = [
            'type' => $this->type,
            'message' => $this->message,
            'data' => $this->data
        ];

        return arrayToJSONString($data);
    }

    /**
     * Converts the Response to a JSON PRETTY String.
     * @return string Converted Response.
     */
    public function convertToJSONPrettyString() {
        $data = [
            'type' => $this->type,
            'message' => $this->message,
            'data' => $this->data
        ];

        return arrayToJSONPrettyString($data);
    }

    /**
     * Message getter.
     * @return string Response message.
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * Data getter.
     * @return Any Response return data.
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Type getter.
     * @return string Response type.
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Message setter.
     * @param string $message Response message.
     */
    public function setMessage($message) {
        $this->message = $message;
    }

    /**
     * Data setter.
     * @param Any $data Response return data.
     */
    public function setData($data) {
        $this->data = $data;
    }

    /**
     * Type setter.
     * @param string $type Response type.
     */
    public function setType($type) {
        $this->type = $type;
    }

}
