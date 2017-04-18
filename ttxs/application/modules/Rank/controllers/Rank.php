<?php
class RankController extends Yaf_Controller_Abstract{
    public $actions = array(
        'rankinfo' => 'actions/rank/rank/Rankinfo.php',
        'othergraderank' => 'actions/rank/rank/Othergraderank.php',
    );
}
