<?php

function smarty_modifier_model_link($str) {
	$dayinji_model_preg = '/(http\:\/\/)?www\.dayinji\.ren\/model\/\d*\.html/';
	preg_match_all($dayinji_model_preg, $str, $model_url_matches);

	$urls = $model_url_matches[0];

	foreach ($urls as $key => $val) {
		if (strpos($val, 'http://') > -1) {
			$_url = str_replace('http://', '', $val);
			$str = str_replace($val, $_url, $str);
			$urls[$key] = $_url;
		}
	}

	$urls = array_unique($urls);

	foreach ($urls as $key => $val) {
		preg_match('/\d+/', $val, $mid);
		
		$shift = explode($val, $str); 
		$count = count($shift);
		$link = '<a href="http://' . $val . '" target="_blank" class="dayinji-model-link" data-model-view-id="' . $mid[0] . '">' . $val . '</a>';

		$str = '';
		foreach ($shift as $_key => $_val) {
			$str .= $_val;
			if ($_key != $count - 1) {
				$str .= $link;
			}
		}
	}
	
	return $str;
}