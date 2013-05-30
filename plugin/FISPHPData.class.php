<?php

class FISPHPData extends FISData {
    public function __construct() {
        $this->datatype = 'php';
    }

    /**
     * 获取选定的数据文件路径
     * @param $tmpl
     * @return bool|string
     */
    private function getFile($tmpl) {
        $id = $this->getId($tmpl);
        $info = pathinfo($id);
        //特定数据
        if ($cookie_id = $this->getCookieId()) {
            $tmp_id = $info['dirname'] . '/' .$info['filename'] .'/'. $cookie_id;
            $filepath = $this->existDataFile($tmp_id);
        } else if (($list = $this->getDataList($tmpl))) {
            //当前提供多份数据
            $tmp_id = current($list); //first
            $filepath = $this->existDataFile($tmp_id);
        }
        if (false === $filepath) {
            //没有多份数据时，默认数据路径
            $filepath = Util::normalizePath(WWW_ROOT . '/test/' . preg_replace('/\.[a-z]{2,6}$/i', '.php', $id));
        }
        return $filepath;
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
