<?php

class FISJSONData extends FISData {
    public function __construct() {
        $this->datatype = 'json';
    }

    private function getFile($tmpl) {
        $root = Util::normalizePath(WWW_ROOT . 'template');
        $id = str_replace($root, '', Util::normalizePath($tmpl));

        return Util::normalizePath(WWW_ROOT . '/test/' . preg_replace('/\.[a-z]{2,6}$/i', '.json', $id));
    }

    public function getData($tmpl) {
        $file = $this->getFile($tmpl);
        $ret = array();
        if (is_file($file)) {
            $ret = json_decode(file_get_contents($file), true);
            if ($ret === null) {
                $ret = array();
            }
        }
        return $ret;
    }
    public function getDataList() {}
    public function getCurrentFilePath($tmpl) {
        //以后支持多份测试数据
        return $this->getFile($tmpl);
    }
}