<?php

require_once __DIR__ . '/Request.class.php';

/**
 * An implementation of the Request class that expects $_SESSION data fields.
 */
class SessionRequest extends Request {

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
                $data[$field] = isset($_SESSION[$field]) ? $_SESSION[$field] : NULL;

                if ($data[$field] === null && $required) {
                    throw new Exception('Missing required field: ' . $field);
                }
            }

            return $data;
        }

        return $_SESSION;
    }

    /**
     * Extracts data from the $_SESSION array, but uses a first level field to specialise
     * a deeper level of extraction.
     * @param array $fields Datafields to be filled and expected.
     * @return string/Array Extracted data.
     * @throws Exception Missing required field.
     */
    public function extract2($fieldLevel1, $fields = NULL) {
        if ($fieldLevel1 && $fields) {
            if(isset($_SESSION[$fieldLevel1])){
                $data = Array();

                foreach ($fields as $field => $required) {
                    $data[$field] = isset($_SESSION[$fieldLevel1][$field]) ? $_SESSION[$fieldLevel1][$field] : NULL;

                    if ($data[$field] === null && $required) {
                        throw new Exception('Missing required field: ' . $field);
                    }
                }

                return $data;
            }
        }

        return $_SESSION;
    }

}
