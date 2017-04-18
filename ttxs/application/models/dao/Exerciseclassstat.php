<?php
class Dao_ExerciseclassstatModel extends Db_Mongodb {

    protected $table = 'exerciseclassstat';

    protected $fields = [
        'stattype' => 0,                 //统计类型:0-总统计,1-月统计,2-周统计
        'ftype' => 0,                    //0-未完成,1-已完成
        'exertype' => 0,                 //运动类型:1-自定义体育家庭作业,2-运动处方(根据体质健康测试成绩发布的锻炼信息),3-跑步,4-兴趣班
        'exerciseprogramid' => [],        //锻炼项目id
        'classid' => '',                  //班级id号
        'planexerno' => 0,               //计划需要锻炼次数
        'semester' => '',                 //学期信息
        'createtime' => 0,               //项目开始时间
        'starttime' => 0,                //开始时间
        'endtime' => 0,                  //结束时间
        'exerdonecount' => 0,            //班级学生作业完成总次数
        'donecount' => 0,                //已经参加学生人数
        'undonecount' => 0,              //未参加学生人数
        'doneuserid' => [],               //已经按时完成学生id号数组
        'undoneuserid' => [],             //未按时完成学生id号数组
        'needdoneno' => '',               //该运动作业还需要锻炼多少次
        'studentsdonecount' => [],        // 学生锻炼次数统计(userid-学生id,gender-学生性别,donecount-本周之前学生锻炼次数,exercisedonecount-该作业学生有效锻炼次数,weekendtime-本周之前的周截止日期)
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