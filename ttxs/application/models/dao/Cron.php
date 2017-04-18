<?php
class Dao_CronModel extends Db_Mongodb {

    const ARTICLE_ZONE_UNAUDIT = 0;          //未审核区
    const ARTICLE_ZONE_GABBAGE = 1;          //回收站区
    const ARTICLE_ZONE_SAFE = 2;             //安全区
    const ARTICLE_ZONE_EXCELLENT = 3;        //初审精华区
    const ARTICLE_ZONE_PUBLISH_PENDING = 4;  //待发布区
    const ARTICLE_ZONE_PUBLISHED = 5;        //已发布区
    
    protected $table = 'cron';

    protected $fields = [
        'articleid' => '',                //文章id信息
        'userid' => '',                   //用户id信息
        'crontime' => 0,                 //计划时间
        'zoneinfo' => 0,                 //目标zone信息
        'isdone' => 0,                   //是否完成计划
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