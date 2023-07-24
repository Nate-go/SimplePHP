<?php
namespace App\Util;
class StringService{

    public static function getClassName($str) {

        $list = explode("\\", $str);
        preg_match('/[A-Z][a-z]*/', $list[count($list) - 1], $matches);
        return isset($matches[0]) ? $matches[0] : null;
    }
}