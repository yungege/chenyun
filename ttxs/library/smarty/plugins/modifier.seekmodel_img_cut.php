<?php

function smarty_modifier_seekmodel_img_cut($url) {
    $url = explode("@", $url);
    return $url[0];
} 

?>