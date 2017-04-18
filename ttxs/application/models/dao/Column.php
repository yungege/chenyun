<?php
class Dao_ColumnModel extends Db_Mongodb {
    
    protected $table = 'column';

    protected $fields = [
        'createid' => '',
        'name' => '',
        'type' => '',
        'createtime' => 0,
        'summary' => '',
        'isdeleted' => 0,
        'popbox' => 0,
        'articlesum' => 0,
        'icon' => '',
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