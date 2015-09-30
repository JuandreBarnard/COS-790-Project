<?php

require_once __DIR__ . '/Request.class.php';

/**
 * An implementation of the Request class that expects $_REQUEST data fields.
 */
class StandardRequest extends Request {

    /**
     * Extracts data from the $_COOKIE array.
     * @param arrat $fields Datafields to be filled and expected.
     * @return string/Array Extracted data.
     * @throws Exception Missing required field.
     */
    public function extract($fields = NULL) {
        $contentTypes = filter_input(INPUT_SERVER, 'CONTENT_TYPE');
        $contentTypes = explode(';', $contentTypes);

        if(in_array('application/json', $contentTypes)){
            $postdata = file_get_contents('php://input');   
            $postdata = json_decode($postdata, true);
            
            if ($fields) {
                $data = Array();

                foreach ($fields as $field => $required) {
                    $data[$field] = isset($postdata[$field]) ? $postdata[$field] : NULL;

                    if ($data[$field] === null && $required) {
                        throw new Exception('Missing required field: ' . $field);
                    }
                }

                return $data;
            }

            return $postdata;
        }
        else{
            if ($fields) {
                $data = Array();

                foreach ($fields as $field => $required) {
                    $data[$field] = isset($_REQUEST[$field]) ? $_REQUEST[$field] : NULL;

                    if ($data[$field] === null && $required) {
                        throw new Exception('Missing required field: ' . $field);
                    }
                }

                return $data;
            }

            return $_REQUEST;
        }
    }
    
    /**
     * Extracts data from the $_REQUEST array, but uses a first level field to specialise
     * a deeper level of extraction.
     * @param array $fields Datafields to be filled and expected.
     * @return string/Array Extracted data.
     * @throws Exception Missing required field.
     */
    public function extract2($fieldLevel1, $fields = NULL) {
        $contentTypes = filter_input(INPUT_SERVER, 'CONTENT_TYPE');
        $contentTypes = explode(';', $contentTypes);

        if(in_array('application/json', $contentTypes)){
            $postdata = file_get_contents('php://input');   
            $postdata = json_decode($postdata, true);
            
            if ($fieldLevel1 && $fields) {
                if(isset($postdata[$fieldLevel1])){
                    $data = Array();

                    foreach ($fields as $field => $required) {
                        $data[$field] = isset($postdata[$fieldLevel1][$field]) ? $postdata[$fieldLevel1][$field] : NULL;

                        if ($data[$field] === null && $required) {
                            throw new Exception('Missing required field: ' . $field);
                        }
                    }

                    return $data;
                }
            }

            return $postdata;
        }
        else{
            if ($fieldLevel1 && $fields) {
                if(isset($_REQUEST[$fieldLevel1])){
                    $data = Array();

                    foreach ($fields as $field => $required) {
                        $data[$field] = isset($_REQUEST[$fieldLevel1][$field]) ? $_REQUEST[$fieldLevel1][$field] : NULL;

                        if ($data[$field] === null && $required) {
                            throw new Exception('Missing required field: ' . $field);
                        }
                    }

                    return $data;
                }
            }

            return $_REQUEST;
        }
    }
}
