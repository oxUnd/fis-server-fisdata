<?php

abstract class FISData {
    public $datatype;
    public function getData() {}

    public function getDatatype() {
        return $this->datatype;
    }

    public function save($post) {
        $file = $post['path'];
        if (!is_file($file) && false === file_put_contents($file, '')) {
            echo '{"message": "填写的路径无法创建，请重新填写！", "code": 1}';
            exit(1);
        }
        $data = $post['data'];
        file_put_contents($file, $data);
        echo '{"message": "保存成功", "code": 0}';
    }

    public function getDataList() {}
        public function getCurrentFilePath(){}
}
