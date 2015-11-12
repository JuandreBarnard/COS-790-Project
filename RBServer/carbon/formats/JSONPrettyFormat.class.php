<?php

require_once __DIR__ . '/Format.class.php';
require_once __DIR__ . '/../functions/converters.functions.php';

/**
 * An implementation of the Format class where the presentation is in JSON Pretty format.
 */
class JSONPrettyFormat extends Format {

    /**
     * Presents the data in JSONPretty format.
     */
    public function present() {
        header('Content-type: application/json');
        print($this->response->convertToJSONPrettyString());
    }

}
