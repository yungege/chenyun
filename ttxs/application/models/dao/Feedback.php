<?php
class Dao_FeedbackModel extends Db_Mongodb {
    
    protected $table = 'feedback';

    protected $fields = [
        'createtime' => 0,           // 反馈创建时间
        'userid' => '',               // 反馈用户id
        'username' => '',             // 用户名
        'content' => '',              // 反馈内容
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