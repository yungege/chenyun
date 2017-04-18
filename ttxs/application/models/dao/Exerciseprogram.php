<?php
class Dao_ExerciseprogramModel extends Db_Mongodb {
    
    protected $table = 'exerciseprogram';

    protected $fields = [
        'scopetype' => 0,            // 项目类型:0-全部,1-自定义体育家庭作业（翻转课堂）,2-运动处方(根据体质健康测试成绩发布的锻炼信息，身体素质教育),3-跑步,4-兴趣班,5-普通锻炼项目（1,2中可包含5）......
        'recommend' => 0,            // 是否是系统推荐:0-不推荐,1-推荐
        'exertype' => '',             // 所属锻炼项目类型类型编号(scopetype = 5)：1-跑步运动，2-普通锻炼(编号内容会再调整)
        'classinfo' => [],            // 班级信息:[classid,......]
        'coverimg' => '',             // 项目封面
        'schoolinfo' => '',           // 学校信息id号
        'name' => '',                 // 运动项目/体育作业的名称
        'describe' => '',             // 备注/小贴士等信息
        'weekfrequency' => 0,        // 周锻炼频次(scopetype = 5/2)
        'defaultexertime' => [],      // 默认/老师分配周锻炼时间:["1","3","5"],分别表示周一\周三\周五
        'timeofeach' => 0,           // 每次锻炼总时间（单位：秒）
        'exerproject' => [],          // 体育作业所包含的"运动项目的id号":[exerciseprogramid,......]
        'actioninfo' => [],           // 动作信息(scopetype = 5/2):[{part(节数,例如第一节),actionid(动作的id号),actiontime(动作总时长),calorie(动作总消耗卡路里),actiongroupno(动作组数)}......]
        'createtime' => 0,           // 创建时间
        'creatorinfo' => [],          // 创建者基本信息:{creatorid(创建者id),creatorname(创建者姓名)}
        'starttime' => 0,            // 开始时间
        'deadlinetime' => 0,         // 结束时间
        'gender' => '',               // 适合性别
        'partcno' => 0,              // 总节数(scopetype = 5/2)
        'participantscount' => 0,    // 总参与人数
        'totalexertimes' => 0,       // 总需要锻炼次数
        'actionno' => 0,             // 总的动作个数
        'calorie' => 0,         // 总计划消耗卡路里
        'strength' => 0,             // 项目强度(scopetype = 5/2): 0-不及格,1-及格,2-中等,3-良,4-优
        'equipment',            // 有无器械(scopetype = 5/2)：0-无器械，1-有器械
        'exercisesiteno' => 0,       // 锻炼部位编号(scopetype = 5/2)：1-胸部, 2-背部, 3-肩部, 4-手臂, 5-颈部, 6-腹部, 7-腰部, 8-臀部, 9-腿部, 10-全身训练
        'valid' => 0,                // 该锻炼类型是否有效:0-无效,1-有效
        'coverimg' => '',             // 封面图片
        'gradedifficulty' => [],      // 年级难度[{grade(年级编号,小学:11-16,初中:21-23,高中31-33,大学:41-44),difficulty(难度:0-一般难度,1-中等难度,2-高级难度)}]
        'vfilesize' => '',            // 项目视频文件总大小(单位:MB)
        'weekdoneno' => 0,           // 周计划锻炼次数
        'makeuplimit' => 0,          // 补作业的时间限制
        'homeworkrequire' => '',      // 作业要求要求
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