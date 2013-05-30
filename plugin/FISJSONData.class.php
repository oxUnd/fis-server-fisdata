<?php

class FISJSONData extends FISData {
    public function __construct() {
        $this->datatype = 'json';
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

    public function getDataList($tmpl) {
        $id = $this->getId($tmpl);
        $info = pathinfo($id);
        $test_dir = Util::normalizePath(WWW_ROOT . '/test/' . $info['dirname'] . '/' . $info['filename']);
        $files = Util::find($test_dir, '/' . $info['filename'] . '_\d+\.json/i');
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