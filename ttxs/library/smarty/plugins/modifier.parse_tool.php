<?php
function smarty_modifier_parse_tool($arr, $tool) {
    $arr = explode(',', $arr);

    if (in_array($tool, $arr)) {
        return 'class="active"';
    }
} 

?>