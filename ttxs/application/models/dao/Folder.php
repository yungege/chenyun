<?php
class Dao_FolderModel extends Db_Mongodb {
    
    protected $table = 'folder';

    protected $fields = [
        'name' => '',
        'userid' => '',
        'type' => 0,
        'articles' => [],
        'opentype' => 0,
        'keywords' => '',
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