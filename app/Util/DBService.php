<?php
namespace App\Util;
class DBService {
    public static function getInsertQuery($data) {

        $array = $data->getListVariable();
        $id = $array['id'];
        unset($array['id']);
        $fields = '';
        $values = '';
        $separator = '';

        foreach ($array as $key => $value) {
            $fields .= $separator . $key;
            if(is_string($value) and $value !== 'null') {
                $values .= $separator . "'" . addslashes($value) . "'";
            } else {
                $values .= $separator . addslashes($value);
            }
            $separator = ', ';
        }
        return [$id, $fields, $values];
    }

    public static function getUpdateQuery($data) {
        $array = $data->getListVariable();
        $id = $array['id'];
        unset($array['id']);
        unset($array['createTime']);
        if(array_key_exists('parentId', $array)) {
            unset($array['parentId']);
        }
        $updateFields = '';
        $separator = '';

        foreach ($array as $key => $value) {
            if(is_string($value) and $value !== 'null') {
                $updateFields .= $separator . "$key = '" . addslashes($value) . "'";
            } else {
                $updateFields .= $separator . "$key = " . addslashes($value) . "";
            }
            $separator = ', ';
        }
        

        return [$id, $updateFields];
    }
}