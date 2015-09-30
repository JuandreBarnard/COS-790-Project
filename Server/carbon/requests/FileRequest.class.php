<?php

require_once __DIR__ . '/Request.class.php';

/**
 * An implementation of the Request class that expects $_FILES data fields.
 */
class FileRequest extends Request {

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
                $data[$field] = isset($_FILES[$field]) ? $_FILES[$field] : NULL;

                if ($data[$field] === null && $required) {
                    throw new Exception('Missing required field: ' . $field);
                }
            }

            return $data;
        }

        return $_FILES;
    }

    /**
     * Extracts data from the $_FILES array, but uses a first level field to specialise
     * a deeper level of extraction.
     * @param array $fields Datafields to be filled and expected.
     * @return string/Array Extracted data.
     * @throws Exception Missing required field.
     */
    public function extract2($fieldLevel1, $fields = NULL) {
        if ($fieldLevel1 && $fields) {
            $data = Array();

            if(isset($_FILES[$fieldLevel1][$field])){
                foreach ($fields as $field => $required) {
                    $data[$field] = isset($_FILES[$fieldLevel1][$field]) ? $_FILES[$fieldLevel1][$field] : NULL;

                    if ($data[$field] === null && $required) {
                        throw new Exception('Missing required field: ' . $field);
                    }
                }

                return $data;
            }
        }

        return $_FILES;
    }

}
