<?php
class Dao_VersioncontrolModel extends Db_Mongodb {
    
    protected $table = 'versioncontrol';

    protected $fields = [
        'createtime' => 0,      // 版本创建时间
        'type' => 0,            // 0-IOS;1-Android
        'versionno' => 0,       // 版本号
        'version' => '',        // 版本
        'description' => '',    // 描述信息
        'downloadurl' => '',    // 下载地址
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