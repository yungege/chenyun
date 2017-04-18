<?php
function smarty_modifier_time ($uptime) {
	$now =  strtotime(now);
	$interval = floor(($now - $uptime) / (3600*24));

	// 不足一天的返回小时
	if ($interval == 0) {
		$inhour = floor(($now - $uptime) / 3600);

		// 不足1小时返回分钟
		if ($inhour == 0) {
			$inmin = floor(($now - $uptime) / 60);

			// 不足1分钟返回刚刚
			if ($inmin == 0){
				return "刚刚";
			}
			else {
				return $inmin."分钟前";
			}
		}
		else {
			return $inhour.'小时前';
		}
	}
	else {
		return $interval.'天前';
	}
}