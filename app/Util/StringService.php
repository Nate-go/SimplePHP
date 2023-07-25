<?php
namespace App\Util;
class StringService{

    public static function getClassName($str) {

        $list = explode("\\", $str);
        $matches = self::exploedByUpperCase($list[count($list) - 1]);
        return isset($matches[0]) ? $matches[0] : null;
    }

    public static function exploedByUpperCase($str){
        $pattern = '/(?=[A-Z])/';
        $words = preg_split($pattern, $str, -1, PREG_SPLIT_NO_EMPTY);

        return $words;
    }

    public static function pluralize($word) {
        // Các quy tắc sử dụng thêm "s" để biến từ đơn thành số nhiều
        $plural_rules = array(
            '/(quiz)$/i'               => '\1zes',    // ví dụ: quiz -> quizzes
            '/(matr|vert|ind)(ix|ex)$/i' => '\1ices',   // ví dụ: matrix -> matrices
            '/(x|ch|ss|sh)$/i'         => '\1es',     // ví dụ: box -> boxes, glass -> glasses
            '/([^aeiouy]|qu)y$/i'      => '\1ies',    // ví dụ: cherry -> cherries
            '/(hive)$/i'               => '\1s',      // ví dụ: hive -> hives
            '/(?:([^f])fe|([lr])f)$/i' => '\1\2ves',  // ví dụ: wife -> wives, wolf -> wolves
            '/(shea|lea|loa|thie)f$/i' => '\1ves',    // ví dụ: sheaf -> sheaves
            '/sis$/i'                  => 'ses',      // ví dụ: basis -> bases
            '/([ti])um$/i'             => '\1a',      // ví dụ: datum -> data
            '/(buffal|tomat)o$/i'      => '\1oes',    // ví dụ: buffalo -> buffaloes, tomato -> tomatoes
            '/(bu)s$/i'                => '\1ses',    // ví dụ: bus -> buses
            '/(alias|status)$/i'       => '\1es',     // ví dụ: alias -> aliases
            '/(octop|vir)us$/i'        => '\1i',      // ví dụ: octopus -> octopi, virus -> viruses
            '/(ax|test)is$/i'          => '\1es',     // ví dụ: axis -> axes, testis -> testes
            '/s$/'                     => 's',        // các từ kết thúc bằng "s" không đổi (ví dụ: cats)
            '/$/'                      => 's',        // các từ còn lại thêm "s" (ví dụ: cat -> cats)
        );
    
        foreach ($plural_rules as $rule => $replacement) {
            if (preg_match($rule, $word)) {
                return preg_replace($rule, $replacement, $word);
            }
        }
    
        return $word;
    }

    public static function getPath($class){
        [$model, $folder] = StringService::exploedByUpperCase($class);

        $folder = StringService::pluralize($folder);

        return ROOT_PATH . '\\' . $folder . '\\' . $class . '.php'; 
    }
}