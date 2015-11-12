<?php

require_once __DIR__ . '/Request.class.php';

/**
 * An implementation of the Request class that expects $_ENV data fields.
 */
class EnvRequest extends Request {

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
                $data[$field] = filter_input(INPUT_ENV, $field);

                if ($data[$field] === null && $required) {
                    throw new Exception('Missing required field: ' . $field);
                }
            }

            return $data;
        }

        return filter_input_array(INPUT_ENV);
    }

    /**
     * Extracts data from the $_ENV array, but uses a first level field to specialise
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

                if(isset($_ENV[$fieldLevel1])){
                    foreach ($fields as $field => $required) {
                        $data[$field] = isset($_ENV[$fieldLevel1][$field]) ? $_ENV[$fieldLevel1][$field] : NULL;

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
