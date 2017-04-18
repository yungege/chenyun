<?php
class Dao_TopicModel extends Db_Mongodb {
    
    protected $table = 'topic';

    protected $fields = [
        'name' => '',
        'summary' => '',
        'type' => '',
        'columninfo' => [],
        'imageurl' => '',
        'createrid' => 0,
        'zone' => 0,
        'createtime' => 0,
        'isdeleted' => 0,
        'ispublished' => 0,
        'remark' => [],
        'revise' => [],
        'statisticsinfo' => [],
        'articleinfo' => [],
	];

    protected function __construct(){
        parent::__construct();
    }

    /**
     * 获得实例
     * @param string $confkey
     * @return mongodb
     */
    public static function getInstance() {

        if(!self::$instance instanceof self){
            self::$instance = new self();
        }

        return self::$instance;
    }
}