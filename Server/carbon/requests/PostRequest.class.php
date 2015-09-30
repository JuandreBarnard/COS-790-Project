<?php

require_once __DIR__ . '/Request.class.php';

/**
 * An implementation of the Request class that expects $_POST data fields.
 */
class PostRequest extends Request {

    /**
     * Extracts data from the $_POST array.
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
                    $data[$field] = filter_input(INPUT_POST, $field);

                    if ($data[$field] === null && $required) {
                        throw new Exception('Missing required field: ' . $field);
                    }
                }

                return $data;
            }

            return filter_input_array(INPUT_POST);
        }
    }
    
    /**
     * Extracts data from the $_POST array, but uses a first level field to specialise
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
                $data = Array();

                if(isset($postdata[$fieldLevel1])){
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
                $data = Array();

                if(isset($_POST[$fieldLevel1])){
                    foreach ($fields as $field => $required) {
                        $data[$field] = isset($_POST[$fieldLevel1][$field]) ? $_POST[$fieldLevel1][$field] : NULL;

                        if ($data[$field] === null && $required) {
                            throw new Exception('Missing required field: ' . $field);
                        }
                    }

                    return $data;
                }
            }

            return filter_input_array(INPUT_POST);
        }
    }

}
