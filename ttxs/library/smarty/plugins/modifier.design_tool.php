<?php
function smarty_modifier_design_tool($str) {
    $str = explode(',', $str);
    return count($str) > 0 ? $str : null;
} 

?>