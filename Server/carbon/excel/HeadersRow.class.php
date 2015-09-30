<?php

require_once __DIR__ . '/Row.class.php';
require_once __DIR__ . '/Cell.class.php';

/**
 * Implementation of Row specifically for headers.
 */
class HeadersRow extends Row {

    /**
     * HeadersRow constructor.
     * @param Array $cells Cells and their data.
     */
    public function __construct($cells) {
        foreach ($cells as $column => $cell) {
            $this->cells[] = new Cell($column);
        }
    }

    /**
     * Exports the Header row.
     * @param boolean $filtered Filter flag.
     * @return string Exported Header row.
     */
    public function export($filtered = Cell::FILTER_ENABLED) {
        $temp = "<Row>\n";

        foreach ($this->cells as $cell) {
            $temp .= $cell->exportWithStyle("cell_yellow", $filtered);
        }

        $temp .= "</Row>\n";

        return $temp;
    }

}
