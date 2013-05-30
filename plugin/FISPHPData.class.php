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
            $ret = $fis_data;
        }
        return $ret;
    }

    public function getDataList($tmpl) {
        $id = $this->getId($tmpl);
        $info = pathinfo($id);
        $test_dir = Util::normalizePath(WWW_ROOT . '/test/' . $info['dirname'] . '/' . $info['filename']);
        $files = Util::find($test_dir, '/' . $info['filename'] . '_\d+\.php/i');
        if ($files) {
            foreach ($files as $k => $filepath) {
                $files[str_replace($test_dir . '/', '', $filepath)] = $filepath;
                unset($files[$k]);
            }
        }
        return $files;
    }

    public function getCurrentFilePath($tmpl) {
        //以后支持多份测试数据
        return $this->getFile($tmpl);
    }
}
