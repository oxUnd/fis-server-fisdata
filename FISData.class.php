<?php

abstract class FISData {
    public $datatype;


    public function getDatatype() {
        return $this->datatype;
    }

    protected function existDataFile($id) {
        $filepath = Util::normalizePath(WWW_ROOT . '/test/' . preg_replace('/\.[a-z]{2,6}$/i', '.' . $this->getDatatype(), $id));
        if (is_file($filepath)) {
            return $filepath;
        }
        return false;
    }

    /**
     * @param $tmpl 当前渲染模板路径
     */
    protected function getId($tmpl) {
        $root = Util::normalizePath(WWW_ROOT . 'template');
        $id = str_replace($root, '', Util::normalizePath($tmpl));
        return $id;
    }

    public function getCookieId() {
        $cookie_id = $_COOKIE['FIS_DEBUG_DATA_ID'];
        if ($cookie_id) {
            $cookie_id = trim($cookie_id);
            if ($cookie_id !== '') {
                $arr = explode('|', $cookie_id);
                if (trim($arr[0]) == $this->datatype) {
                    $cookie_id = $arr[1];
                }
            }
        } else {
            $cookie_id = '';
        }
        return $cookie_id;
    }

    public function getData($tmpl) {}

    public function get($post) {
        $filepath = $post['path'];
        if (!is_file($filepath)) {
            echo "";
            return;
        }
        echo file_get_contents($filepath);
    }

    public function save($post) {
        $file = $post['path'];
        $dir = dirname($file);
        if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
            echo '{"message": "填写的路径无法创建，请重新填写！", "code": 1}';
            exit(1);
        }
        if (!is_file($file) && false === file_put_contents($file, '')) {
            echo '{"message": "填写的路径无法创建，请重新填写！", "code": 1}';
            exit(1);
        }
        $data = $post['data'];
        file_put_contents($file, $data);
        echo '{"message": "保存成功", "code": 0}';
    }

    public function getDataList($tmpl) {}
    public function getCurrentFilePath(){}
}
