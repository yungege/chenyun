<?php
function smarty_modifier_size($size) { 
    // var_dump($size);
    $g = floor($size / 1024 / 1024 / 1024);

    if ($g == 0) {
        $m = floor($size / 1024 / 1024);

        if ($m == 0) {
            return floor($size / 1024) . 'KB';
        }
        else {
            return $m . 'MB';
        }
    }
    else {
        return $g . 'GB';
    }
} 

?>