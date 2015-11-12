<?php

require_once __dir__ . '/Format.class.php';
require_once __dir__ . '/../functions/converters.functions.php';

/**
 * An implementation of the Format class where the presentation is in JSON Pretty format.
 */
class HTTPQueryFormat extends Format {

    /**
     * Presents the data in HTTP query format.
     */
    public function present() {
        print_r(http_build_query($this->response->convertToArray()));
    }
}
