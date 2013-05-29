<?php

class Util {
    /**
     * 格式化路径字符串
     *
     * * replace "\" to "/"
     * * replace contiguous "/" to one "/"
     * * replace "a/b/../c" to "a/c"
     * * remove "/./"
     * * remove "/" at the end.
     *
     * @static
     * @param string $path 路径字符串（路径存在与否）
     * @return string
     */
    public static function normalizePath($path) {
        $normal_path = preg_replace(
            array('/[\/\\\\]+/', '/\/\.\//', '/^\.\/|\/\.$/', '/\/$/'),
            array('/', '/', '', ''),
            $path
        );
        $path = $normal_path;
        do {
            $normal_path = $path;
            $path = preg_replace('/[^\\/\\.]+\\/\\.\\.(?:\\/|$)/', '', $normal_path);
        } while ($path != $normal_path);
        $path = preg_replace('/\/$/', '', $path);
        return $path;
    }

}