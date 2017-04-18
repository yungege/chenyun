<?php
class SportController extends Yaf_Controller_Abstract{
    public $actions = array(
        'banner'     => 'actions/sport/sport/Banner.php',
        'share'      => 'actions/sport/sport/Share.php',
        'up'         => 'actions/sport/sport/Up.php',
        'upuserlist' => 'actions/sport/sport/Upuserlist.php',
    );
}
