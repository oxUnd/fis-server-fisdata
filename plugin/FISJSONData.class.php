<?php

class FISJSONData extends FISData {
    public function __construct() {
        $this->datatype = 'json';
    }

    private function getFile($tmpl) {
        $id = $this->getId($tmpl);
        $info = pathinfo($id);
        if ($cookie_id = $this->getCookieId()) {
            $tmp_id = $info['dirname'] . '/' .$info['filename'] .'/'. $cookie_id;
            $filepath = $this->existDataFile($tmp_id);
        } else if (($list = $this->getDataList($tmpl))) {
            $tmp_id = current($list); //first
            $filepath = $this->existDataFile($tmp_id);
        }
        if (false === $filepath) {
            $filepath = Util::normalizePath(WWW_ROOT . '/test/' . preg_replace('/\.[a-z]{2,6}$/i', '.json', $id));
        }
        return $filepath;
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