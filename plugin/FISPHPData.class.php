<?php

class FISPHPData extends FISData {
    public function __construct() {
        $this->datatype = 'php';
    }

    public function getData($tmpl) {
        $file = $this->getFile($tmpl);
        $ret = array();
        if (is_file($file)) {
            require($file);
            if (!Util::isUtf8(var_export($fis_data, true))) {
                $this->encoding = 'gbk';
            }
            $ret = $fis_data;
        }
        return $ret;
    }
}
