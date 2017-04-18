<?php
class Dao_TransmitModel extends Db_Mongodb {
    
    protected $table = 'transmit';

    protected $fields = [
        'articleid' => '',      //文章id
        'topic' => '',          //话题
        'column' => '',         //栏目
        'transmiterid' => '',   //转发人id
        'transmitername' => '', //转发人昵称
        'transmittype' => 0,   //转发类型
        'tranmittime' => 0,    //转发时间
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