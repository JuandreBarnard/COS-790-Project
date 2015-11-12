<?php

/**
 * Cell wrapper class.
 */
class Cell {

    /**
     * @var Any Cell data. 
     */
    private $data = NULL;
    
    /**
     * Filter enable.
     */
    const FILTER_ENABLED = true;
    
    /**
     * Filter disable.
     */
    const FILTER_DISABLED = false;

    /**
     * Cell constructor.
     * @param Any $data Cell data.
     */
    public function __construct($data) {
        $this->data = $data;
    }

    /**
     * Cleans data from containing < or >.
     * @param string $data Cell data.
     * @return string Cleaned data.
     */
    private function clean($data) {
        $danger = array(
            '<',
            '>'
        );

        return str_replace($danger, '', $data);
    }

    /**
     * Exports cell data.
     * @return string Exported cell data.
     */
    public function export() {
        $temp = "<Cell><Data ss:Type=\"String\">" . utf8_encode($this->clean($this->data)) . "</Data></Cell>\n";
        return $temp;
    }
    
    /**
     * Exports cell data with added style.
     * @param $style_id String Style identifier.
     * @return string Exported cell data.
     */
    public function exportWithStyle($style_id, $filtered = Cell::FILTER_ENABLED) {
        $temp = "";
        $temp .= "<Cell ss:StyleID=\"";
        $temp .= $style_id;
        $temp .= "\">";
        
        if($filtered){
            $temp .= "<NamedCell ss:Name=\"filter\"/>";
        }
        
        $temp .= "<Data ss:Type=\"String\">";
        $temp .= utf8_encode($this->clean($this->data));
        $temp .= "</Data></Cell>\n";
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
