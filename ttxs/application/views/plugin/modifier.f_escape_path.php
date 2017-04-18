<?php
/**
 * 这个解释一下，因为用了parse_uri 所以这个基本没用
 * 但是为了防止以后参数出现中文这个就没删除，以后如果出现这种情况直接在uri里面加处理逻辑就可以
 * 以后特殊情况特殊处理
 */
function smarty_modifier_f_escape_path($string, $esc_type = 'uri'){

	switch ($esc_type) {
        case 'urlpathinfo':
            return str_replace('%3A',':',str_replace('%2F','/',rawurlencode($string)));
        case 'url':
            return rawurlencode($string);
        case 'uri':
        	return $string;
        default:
            return $string;
    }

}
