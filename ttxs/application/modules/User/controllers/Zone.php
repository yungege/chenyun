<?php
class ZoneController extends Yaf_Controller_Abstract{
    public $actions = array(
        'userinfo'          => 'actions/user/zone/Userinfo.php',
        'trainstatistics'   => 'actions/user/zone/TrainStatistics.php',
        'trainhistory'      => 'actions/user/zone/TrainHistory.php',
        'myhealthrecords'   => 'actions/user/zone/MyHealthRecords.php',
        'relation'          => 'actions/user/zone/Relation.php',
    );
}