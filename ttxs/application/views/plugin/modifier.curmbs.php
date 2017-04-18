<?php
function smarty_modifier_curmbs($str) {
    $ret = array();
    $str = explode(',', $str);
    foreach ($str as $key => $val) {
        $tmp = array();
        $val = str_replace('[', '', $val);
        $val = str_replace(']', '', $val);
        foreach (explode(';', $val) as $k => $p) {
            $p = explode('=', $p);
            $tmp[$p[0]] = $p[1];
        }

        array_push($ret, $tmp);
    }
    
    return $ret;
} 

?>