<?php
function smarty_modifier_unit($number) {
   
    if ($number < 1000) {
        return $number;
    }
    else if ($number >= 1000 && $number < 10000) {
        $f_number = $number / 1000;
        return substr((string)$f_number, 0, 1) . '千';
    }
    else if ($number >= 10000 && $number < 100000) {
        $f_number = $number / 10000;
        return substr((string)$f_number, 0, 1) . '万';
    }
    else if ($number >= 100000 && $number < 1000000) {
        $f_number = $number / 10000;
        return substr((string)$f_number, 0, 2) . '万';
    }
    else if ($number >= 1000000 && $number < 10000000) {
        $f_number = $number / 10000;
        return substr((string)$f_number, 0, 3) . '万';
    }
    else if ($number >= 10000000 && $number < 100000000) {
        $f_number = $number / 10000;
        return substr((string)$f_number, 0, 4) . '万';
    }
    else if ($number >= 100000000) {
        return ceil($number / 100000000) . "亿+";
    }
} 

?>