<?php

require_once __DIR__ . '/Request.class.php';

/**
 * An implementation of the Request class that expects $_SERVER data fields.
 */
class ServerRequest extends Request {

    /**
     * Extracts data from the $_COOKIE array.
     * @param arrat $fields Datafields to be filled and expected.
     * @return string/Array Extracted data.
     * @throws Exception Missing required field.
     */
    public function extract($fields = NULL) {
        if ($fields) {
            $data = Array();

            foreach ($fields as $field => $required) {
                $data[$field] = isset($_SERVER[$field]) ? $_SERVER[$field] : NULL;

                if ($data[$field] === null && $required) {
                    throw new Exception('Missing required field: ' . $field);
                }
            }

            return $data;
        }

        return $_SERVER;
    }

    /**
     * Extracts data from the $_SERVER array, but uses a first level field to specialise
     * a deeper level of extraction.
     * @param array $fields Datafields to be filled and expected.
     * @return string/Array Extracted data.
     * @throws Exception Missing required field.
     */
    public function extract2($fieldLevel1, $fields = NULL) {
        if ($fieldLevel1 && $fields) {
            $data = Array();

            if(isset($_SERVER[$fieldLevel1][$field])){
                foreach ($fields as $field => $required) {
                    $data[$field] = isset($_SERVER[$fieldLevel1][$field]) ? $_SERVER[$fieldLevel1][$field] : NULL;

                    if ($data[$field] === null && $required) {
                        throw new Exception('Missing required field: ' . $field);
                    }
                }

                return $data;
            }
        }

        return $_SERVER;
    }

}
