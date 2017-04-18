<?php
class Dao_ExercisedelayModel extends Db_Mongodb {
    
    protected $table = 'exercisedelay';

    protected $fields = [
        'type' => 0,                      // 锻炼项目类型
        'projectid' => [],                 // 锻炼项目id信息
        'homeworkid' => '',                // 作业的ID
        'userid' => '',                    // 用户id信息
        'originaltime' => 0,              // 计划时间
        'modifiedtime' => 0,              // 调整后的时间
        'state' => 0,                     // 状态信息:0-未完成状态;1-已完成状态;2-非有效状态
        'isdelay' => 0,                   //1-延期作业,2-补作业
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