<?php

/**
 * Abstract row class, which stores row information.
 */
abstract class Row {

    /**
     * @var Array Cells. 
     */
    private $cells = NULL;

    /**
     * Abstract export function that exports Row data.
     */
    public abstract function export();

    /**
     * Cells getter.
     * @return Array Cells.
     */
    public function getCells() {
        return $this->cells;
    }

    /**
     * Cells setter.
     * @param Array $cells Cells.
     */
    public function setCells($cells) {
        $this->cells = $cells;
    }

}
