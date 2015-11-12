<?php

require_once __DIR__ . '/Worksheet.class.php';

/**
 * An implementation of an excel document exporter.
 */
class ExcelDocument {

    /**
     * @var string Excel document filename. 
     */
    private $filename = NULL;
    
    /**
     * @var Array Styles and formats.
     */
    private $styles = NULL;

    /**
     * @var Array Excel document worksheets.
     */
    private $worksheets = NULL;

    /**
     * ExcelDocument constructor.
     * @param string $filename Document filename.
     */
    public function __construct($filename) {
        $this->filename = $this->removeExtensions($filename);
    }

    /**
     * Adds a new worksheet to the document.
     * @param string $title worksheet title.
     * @param Array $data Worksheet data.
     */
    public function addWorksheet($title, $data) {
        $this->worksheets[] = new Worksheet($title, $data);
    }

    /**
     * Removes any xls[x] extension that the user might add by him/herself.
     * @param string $filename Document filename before extension is removed.
     * @return string Formatted document filename.
     */
    private function removeExtensions($filename) {
        $parts = preg_split("/\./", $filename);

        $temp = $parts[0];
        $size = count($parts);

        for ($i = 1; $i < $size - 1; $i++) {
            $temp .= ".";
            $temp .= $parts[$i];
        }

        return $temp;
    }

    /**
     * Prepares the page for Excel file download.
     */
    private function setPageHeaders() {
        header("Content-Disposition: inline; filename=" . $this->filename . "");
        header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    }

    /**
     * Sets up the document headers.
     * @return string Document headers.
     */
    private function getFileHeader() {
        $header = "";
        $header .= "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
        $header .= "<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"";
        $header .= " xmlns:x=\"urn:schemas-microsoft-com:office:excel\"";
        $header .= " xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"";
        $header .= " xmlns:html=\"http://www.w3.org/TR/REC-html40\">\n";

        return $header;
    }
    
    private function getStyles(){
        $styles = "";
        $styles .= "<Styles>\n";
        $styles .= "<Style ss:ID=\"cell_yellow\"><Interior ss:Color=\"#FFFF00\" ss:Pattern=\"Solid\"/></Style>\n";
        $styles .= "</Styles>\n";

        return $styles;
    }

    /**
     * Sets up the document footers.
     * @return string Document footers.
     */
    private function getFileFooter() {
        $footer = "</Workbook>";
        return $footer;
    }

    /**
     * Exports the Excel document for download.
     */
    public function download() {
        $this->setPageHeaders();
        print $this->getFileHeader();

        foreach ($this->worksheets as $worksheet) {
            print $worksheet->export();
        }

        print $this->getFileFooter();
    }

    /**
     * Exports the Excel document as an instance.
     * @return string Excel document raw.
     */
    public function export() {
        $temp = "";
        $temp .= $this->getFileHeader();
        $temp .= $this->getStyles();

        foreach ($this->worksheets as $worksheet) {
            $temp .= $worksheet->export();
        }

        $temp .= $this->getFileFooter();
        return $temp;
    }

    /**
     * Writes the exported Excel document to a location.
     * @param string $path Directory to which to write to.
     * @return string Full written file path.
     */
    public function writeToLocation($path) {
        $data = $this->export();

        $filepointer = fopen($path . $this->filename . '.xls', 'w');
        fwrite($filepointer, $data);
        fclose($filepointer);

        return $path . $this->filename . '.xls';
    }

}
