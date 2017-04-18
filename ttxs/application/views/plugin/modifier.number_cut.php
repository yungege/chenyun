<?php

function smarty_modifier_number_cut($str) {
    $str = (string)$str;
    $count = 7 - strlen($str);

    $b = '';
    for ($i = 0; $i < $count; $i++) {
        $b .= '0';
    }
    $str = $b . $str;
    $str = str_split($str);
    
    return $str;
}