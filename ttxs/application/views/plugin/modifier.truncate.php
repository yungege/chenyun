<?php
function smarty_modifier_truncate($string, $length = 80, $etc = '...', $break_words = false, $middle = false) {
    if ($length == 0)
        return '';

    if (SMARTY_MBSTRING /* ^phpunit */&&empty($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'])/* phpunit$ */) {
        if (mb_strlen($string, SMARTY_RESOURCE_CHAR_SET) > $length) {
            $length -= min($length, mb_strlen($etc, SMARTY_RESOURCE_CHAR_SET));
            if (!$break_words && !$middle) {
                $string = preg_replace('/\s+?(\S+)?$/u', '', mb_substr($string, 0, $length + 1, SMARTY_RESOURCE_CHAR_SET));
            } 
            if (!$middle) {
                return mb_substr($string, 0, $length, SMARTY_RESOURCE_CHAR_SET) . $etc;
            }
            return mb_substr($string, 0, $length / 2, SMARTY_RESOURCE_CHAR_SET) . $etc . mb_substr($string, - $length / 2, $length, SMARTY_RESOURCE_CHAR_SET);
        }
        return $string;
    }
    
    // no MBString fallback
    if (isset($string[$length])) {
        $length -= min($length, strlen($etc));
        if (!$break_words && !$middle) {
            $string = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length + 1));
        } 
        if (!$middle) {
            return substr($string, 0, $length) . $etc;
        }
        return substr($string, 0, $length / 2) . $etc . substr($string, - $length / 2);
    }
    return $string;
} 

?>