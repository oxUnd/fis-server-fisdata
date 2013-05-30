<?php

class FISADOCData extends FISData {

    private $adoc_data_path;

    public function __construct() {
        $this->datatype = 'adoc';
        $this->adoc_data_path = WWW_ROOT . '/test/data/';
    }

    protected function getId() {
        $uri = $_SERVER['REQUEST_URI'];
        if (($p = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $p);
        }
        $uris = explode('/', $uri);
        if (isset($uris[1]) && $uris[1] !== '') {
            unset($uris[0]);
            $id = implode('_', $uris);
        }
        return $id;
    }

    protected function getFile($tmpl) {
        $root = Util::normalizePath(WWW_ROOT . 'template');
        $id = str_replace($root, '', Util::normalizePath($tmpl));
        return Util::normalizePath(WWW_ROOT . '/test/' . preg_replace('/\.[a-z]{2,6}$/i', '.text', $id));
    }

    private function parseAdocFile($filepath) {
        $content = file_get_contents($filepath);
        require_once(LIBS_ROOT . 'JsonPro' . DIRECTORY_SEPARATOR . 'genInterface.php');
        $genHandle = new genInterface();
        $genHandle->setPath($this->adoc_data_path);
        $genHandle->genCaseData($content);
    }

    public function getData($tmpl) {
        $id = $this->getId();
        if (!$id) {
            $this->parseAdocFile($this->getFile($tmpl));
        }
        $data_path = Util::normalizePath($this->adoc_data_path . $id . '.php');
        if (!is_file($data_path)) {
            return array();
        }
        ob_start();
        require_once($data_path);
        $data = ob_get_clean();
        $data = json_decode($data, true);
        $render_data = array();
        if ($cookie_id = $this->getCookieId()) {
            $render_data = $data[$cookie_id];
        } else {
            $render_data = current($data);
        }
        return $render_data;
    }

    public function fetchRemoteData($tmpl_id) {
    }

    public function getDataList($tmpl) {
        $id = $this->getId();
        if (!$id) {
            $this->parseAdocFile($this->getFile($tmpl));
        }
        $data_path = Util::normalizePath($this->adoc_data_path . $id . 'HTML.php');
        if (!is_file($data_path)) {
            return array();
        }
        ob_start();
        require_once($data_path);
        $data = ob_get_clean();
        $data = json_decode($data, true);
        return $data;
    }

    public function getCurrentFilePath($tmpl) {
        //以后支持多份测试数据
        return $this->getFile($tmpl);
    }
}