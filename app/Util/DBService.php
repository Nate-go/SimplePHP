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
        $array = get_object_vars($data);
        $id = $array['id'];
        unset($array['id']);
        $updateFields = '';
        $separator = '';

        foreach ($array as $key => $value) {
            $updateFields .= $separator . "$key = " . addslashes($value) . "";
            $separator = ', ';
        }

        return [$id, $updateFields];
    }
}