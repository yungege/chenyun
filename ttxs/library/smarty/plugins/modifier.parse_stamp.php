<?php
function smarty_modifier_parse_stamp($stamp) {
    $now = time();
    $yearDiffer = floor(($now - $stamp) / (3600 * 24 * 365));

    if ($yearDiffer == 0) {
        $monthDiffer = floor(($now - $stamp) / (3600 * 24 * 30));

        if ($monthDiffer == 0) {
            $dayDiffer = floor(($now - $stamp) / (3600 * 24));

            if ($dayDiffer == 0) {
                $hourDiffer = floor(($now - $stamp) / 3600);

                if ($hourDiffer == 0) {
                    $minuteDiffer = floor(($now - $stamp) / 60);

                    if ($minuteDiffer == 0) {
                        return "刚刚";
                    }
                    else {
                        return $minuteDiffer . '分钟前';
                    }
                }
                else {
                    return $hourDiffer . '小时前';
                }
            }
            else {
                return $dayDiffer . '天前';
            }
        }
        else {
            return $monthDiffer . '个月前';
        }
    }
    else {
        return $yearDiffer . '年前';
    }
} 

?>