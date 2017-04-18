<?php
class Dao_ExerciseactionModel extends Db_Mongodb {
    
    protected $table = 'exerciseaction';

    protected $fields = [
        'name' => '',                 // 动作名称
        'typeno' => 0,               // 所属动作类型编号：1-计时锻炼，2-计组数锻炼，3-节拍锻炼，4-休息
        'exercisesiteno' => 0,       // 锻炼部位编号：1-胸部, 2-背部, 3-肩部, 4-手臂, 5-颈部, 6-腹部, 7-腰部, 8-臀部, 9-腿部, 10-全身训练
        'equipment' => 0,            // 有无器械：0-无器械，1-有器械
        'actiongroupno' => 0,        // 动作组数
        'equipmenttype' => 0,        // 器械类型:(后续补充)
        'equipmentname' => '',        // 器械名称
        'img' => [],                  // 动作相关图片地址
        'detaildecs' => '',           // 动作介绍详情页图片地址
        'coverimg' => '',             // 动作封面图片
        'video' => [],                // 动作视频地址数组
        'audio' => [],                // 动作音频地址数组
        'createtime' => 0,           // 创建时间
        'createor' => '',             // 创建者
        'describe' => '',             // 动作描述内容
        'calorie' => 0.00,              // 卡路里/次
        'level' => 0,                // 动作难度级别:0-不及格,1-及格,2-良,3-优秀
        'physicalquality' => 0,      // 对应身体素质:0-耐力素质，1-上肢力量，2-腹肌耐力，3-柔韧素质，4-速度素质，5-下肢力量, 6-综合素质
        'singletime' => 0,           // 完成单次动作计划所需时间(单位:秒)
        'sex' => '',                  // 项目适用的性别:male\female\both
        'vfilesize' => '',            // 视频文件大小(单位:MB)
        'gradedifficulty' => [],      // 年级难度[{grade(年级编号,小学:11-16,初中:21-23,高中31-33,大学:41-44),difficulty(难度:0-一般难度,1-中等难度,2-高级难度)}]
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