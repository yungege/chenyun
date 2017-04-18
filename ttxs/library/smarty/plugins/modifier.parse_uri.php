<?php
function smarty_modifier_parse_uri($req, $key, $del1, $del2, $del3) {
    $ret = array();

    if ($key) {
        unset($req[$key]);
    }

    // 非翻页全部从1开始
    if ($key != 'pn') {
        $req['pn'] = 1;
    }

    foreach ($req as $key => $val) {
    	if ($del1 && $del1 == $key) {
    		continue;
    	}
    	if ($del2 && $del2 == $key) {
    		continue;
    	}
        if ($del3 && $del3 == $key) {
            continue;
        }
    	
    	// 防止中文 编码问题
        array_push($ret, $key . '=' . urlencode($val)); 
    }

    return count($req) == 0 ? '' : implode('&', $ret) . '&';
} 

?>