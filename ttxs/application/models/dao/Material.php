<?php
class Dao_MaterialModel extends Db_Mongodb {
    
    protected $table = 'material';

    protected $fields = [
        'type' => '',
        'groupid' => '',
        'url' => '',
        'title' => '',
        'tag' => [],
        'remark' => [],
        'isdeleted' => 0,
        'style' => '',
        'createtime' => 0,
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