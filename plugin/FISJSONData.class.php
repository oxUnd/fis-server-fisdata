<?php

class FISJSONData extends FISData {
    public function __construct() {
        $this->datatype = 'json';
    }

    public function getData($tmpl) {
        $file = $this->getFile($tmpl);
        $ret = array();
        if (is_file($file)) {
            $content = file_get_contents($file);
            if (!Util::isUtf8($content)) {
                $this->encoding = 'gbk';
            }
            $ret = json_decode(Util::convertToUtf8($content), true);
            if ($ret === null) {
                $ret = array();
            }
        }
        return $ret;
    }
}
