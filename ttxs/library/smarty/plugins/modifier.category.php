<?php
function smarty_modifier_category($c_id, $category) { 
    $c_id = explode('-', $c_id);

    if (!count($c_id)) {
        return false;
    }
    
    $first_level = $c_id[0];
    $second_level = $c_id[1];
    $third_level = $c_id[2];
    $area = "";
    $second_category = null;
    $third_category = null;

    foreach ($category as $key => $val) {
        if ($val['category_id'] == $first_level) {
            $area .= $val['name'];

            if (!!intval($second_level)) {
                $second_category = $val['next_level'];
            }
        }
    }

    if (is_array($second_category)) {
        foreach ($second_category as $key => $val) {
            if ($val['category_id'] == $second_level) {
                $area .= " &gt; " . $val['name'] ;

                if (!!intval($third_level)) {
                    $third_category = $val['next_level'];
                }
            }
        }
    }

    if (is_array($third_category)) {
        foreach ($third_category as $key => $val) {
            if ($val['category_id'] == $third_level) {
                $area .= " &gt; " . $val['name'];
            }
        }
    }
    return $area;
} 

?>