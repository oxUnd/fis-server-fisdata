<?php

class FISADOCData extends FISData {
    public function __construct() {
        $this->datatype = 'adoc';
    }

    private function getFile($tmpl) {
        $root = Util::normalizePath(WWW_ROOT . 'template');
        $id = str_replace($root, '', Util::normalizePath($tmpl));
        return Util::normalizePath(WWW_ROOT . '/test/' . preg_replace('/\.[a-z]{2,6}$/i', '.text', $id));
    }

    public function getData($tmpl) {
        return array();
    }

    public function fetchRemoteData($tmpl_id) {
    }

    public function getDataList() {}
    public function getCurrentFilePath($tmpl) {
        //以后支持多份测试数据
        return $this->getFile($tmpl);
    }
}