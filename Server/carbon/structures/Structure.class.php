<?php

/**
 * A wrapper object that stores structures in string format.
 */
abstract Class Structure {

    /**
     * @var string Structure data in string format. 
     */
    private $structureString = '';

    /**
     * Structure constructor.
     * @param string $structureString Structure data in string format. 
     */
    public function __construct($structureString = NULL) {
        $this->structureString = $structureString;
    }

    /**
     * Structure getter.
     * @return string Structure.
     */
    public function getStructure() {
        return $this->structureString;
    }

}
