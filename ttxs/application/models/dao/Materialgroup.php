<?php
class Dao_MaterialgroupModel extends Db_Mongodb {
    
    protected $table = 'materialgroup';

    protected $fields = [
        'mname' => '',
        'type' => '',
        'columnid' => '',
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