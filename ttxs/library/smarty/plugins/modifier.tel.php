<?php
function smarty_modifier_tel ($str) {
	$str = substr($str, 0, 3).'****'.substr($str, 7, 4);
	return $str;
}