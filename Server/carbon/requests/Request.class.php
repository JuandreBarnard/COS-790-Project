<?php

/**
 * An abstraction of the Request handler.
 */
abstract class Request {

    /**
     * A datafield is required.
     */
    const REQUIRED = true;

    /**
     * Datafield is not required.
     */
    const NOT_REQUIRED = false;

    /**
     * Abstract extractor function.
     */
    public abstract function extract($fields = NULL);
    
    /**
     * Abstract extractor function for base field
     */
    public abstract function extract2($fieldLevel1, $fields = NULL);
}
