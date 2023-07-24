<?php
namespace App\Util;
class DBService {
    public static function getInsert($data) {

        $arr = get_object_vars($data);
        $id = $arr['id'];
        unset($arr['id']);
        $fields = '';
        $values = '';
        $separator = '';

        foreach ($arr as $key => $value) {
            $fields .= $separator . $key;
            if(is_string($value)) {
                $values .= $separator . "'" . addslashes($value) . "'";
            } else {
                $values .= $separator . addslashes($value);
            }
            $separator = ', ';
        }

        return ['id' => $id, 'fields' => $fields, 'values' => $values];
        
    }

    public static function getUpdate($data) {
        $arr = get_object_vars($data);
        $id = $arr['id'];
        unset($arr['id']);
        $updateFields = '';
        $separator = '';

        foreach ($arr as $key => $value) {
            $updateFields .= $separator . "$key = " . addslashes($value) . "";
            $separator = ', ';
        }

        return ['id' => $id, 'updateFields' => $updateFields];
    }
}