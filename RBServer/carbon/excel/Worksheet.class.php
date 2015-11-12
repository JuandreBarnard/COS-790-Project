<?php

require_once __DIR__ . '/HeadersRow.class.php';
require_once __DIR__ . '/StandardRow.class.php';

/**
 * Excel worksheet wrapper class.
 */
class Worksheet {

    /**
     * @var string Worksheet title. 
     */
    private $title = NULL;

    /**
     * @var Array Worksheet headers. 
     */
    private $headers = NULL;

    /**
     * @var Arrays Worksheet row data. 
     */
    private $rows = NULL;

    /**
     * Worksheet constructor.
     * @param string $title Worksheet title.
     * @param Array $data Worksheet data.
     */
    public function __construct($title, $data) {
        $this->title = $title;
        $header_flag = false;

        foreach ($data as $row) {
            if (!$header_flag) {
                $this->headers = new HeadersRow($row);
                $header_flag = true;
            }

            $this->rows[] = new StandardRow($row);
        }
    }

    /**
     * Exports the worksheet.
     * @return string Exported worksheet.
     */
    public function export() {
        $temp = "";
        $temp .= "<Worksheet ss:Name=\"" . $this->title . "\">\n";
        $temp .= "<Names>\n";
        $temp .= "<NamedRange ss:Name=\"filter\" ss:RefersTo=\"=R1:R1\" ss:Hidden=\"1\"/>\n";
        $temp .= "</Names>\n";
        $temp .= "<Table>\n";
        $temp .= "<Column ss:Index=\"1\" ss:AutoFitWidth=\"0\" ss:Width=\"110\"/>\n";

        $temp.= $this->headers->export();

        foreach ($this->rows as $row) {
            $temp .= $row->export();
        }

        $temp .= "</Table>\n";
        $temp .= "<AutoFilter x:Range=\"R1:R1\" xmlns=\"urn:schemas-microsoft-com:office:excel\"></AutoFilter>\n";
        $temp .= "</Worksheet>\n";

        return $temp;
    }

    /**
     * Data getter.
     * @return Any Cell data.
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Data setter.
     * @param Any $data Cell data.
     */
    public function setData($data) {
        $this->data = $data;
    }

}
