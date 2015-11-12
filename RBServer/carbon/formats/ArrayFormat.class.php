<?php

require_once __dir__ . '/Format.class.php';
require_once __dir__ . '/../functions/converters.functions.php';

/**
 * An implementation of the Format class where the presentation is in JSON Pretty format.
 */
class ArrayFormat extends Format {

    /**
     * Presents the data in Array format.
     */
    public function present() {
        print_r($this->response->convertToArray());
    }
}
