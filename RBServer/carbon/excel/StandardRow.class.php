<?php

require_once __DIR__ . '/Row.class.php';
require_once __DIR__ . '/Cell.class.php';

/**
 * Implementation of Row specifically for normal cells.
 */
class StandardRow extends Row {

    /**
     * StandardRow constructor.
     * @param Array $cells Cells and their data.
     */
    public function __construct($cells) {
        foreach ($cells as $column => $cell) {
            $this->cells[] = new Cell($cell);
        }
    }

    /**
     * Exports the Standard row.
     * @return string Exported Standard row.
     */
    public function export() {
        $temp = "<Row>\n";

        foreach ($this->cells as $cell) {
            $temp .= $cell->export();
        }

        $temp .= "</Row>\n";

        return $temp;
    }

}
