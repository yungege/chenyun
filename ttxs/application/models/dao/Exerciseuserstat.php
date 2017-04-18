<?php
/**
 * 锻炼统计信息
 */
class Dao_ExerciseuserstatModel extends Db_Mongodb {

    const STATE_TYPE_TOTAL = 0; //总统计
    const STATE_TYPE_MONTH = 1; //月统计
    const STATE_TYPE_WEEK  = 2; //周统计

    protected $table = 'exerciseuserstat';

    protected $fields = [
        'stattype' => 0,                 //统计类型:0-总统计,1-月统计,2-周统计
        'ftype' => 0,                    //0-未完成,1-已完成
        'exertype' => 0,                 //运动类型:1-自定义体育家庭作业(翻转课堂),2-运动处方(根据体质健康测试成绩发布的锻炼信息，身体素质作业),3-跑步,4-兴趣班,5-普通锻炼类型(是身体素质作业和翻转课堂的下属类型)
        'exerciseprogramid' => [],       //锻炼项目id
        'projectid' => [],               //子项目id
        'userid' => '',                  //用户id
        'planexerno' => 0,               //计划需要锻炼次数
        'semester' => '',                //学期信息
        'createtime' => 0,               //项目开始时间
        'starttime' => 0,                //统计开始时间
        'endtime' => 0,                  //统计结束时间
        'planetime' => 0,                //该统计范围内计划锻炼总次数
        'donecount' => 0,                //该统计范围内已经锻炼次数
        'undonecount' => 0,              //该统计范围内未锻炼次数
        'burncalorie' => 0.00,           //该统计范围内总消耗卡路里
        'totletime' => 0,                //该统计范围内总消耗时间
        'originalexerdone' => 0,         //原始锻炼计划锻炼次数
        'date' => [],                    //[year,real_year,month,week]
        'school_id' => '',               //学校id
        'class_id' => '',                //班级id
        'grade' => 0,                    //年级
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

    public function updateById(string $id, array $set){
        $where = [
            '_id' => $id,
        ];

        return $this->update($where, $set);
    }

    /**
     * 聚合卡路里信息 获得班级排名
     * @Author    422909231@qq.com
     * @DateTime  2017-04-10
     * @copyright [copyright]
     * @license   [license]
     * @version   [version]
     * @param     array            $userInfo [description]
     * @param     array            $dateInfo [description]
     * @param     array            $order    排序 默认卡路里倒序
     * @return    array
     */
    public function getUserClassWeekRank(array $userInfo, array $dateInfo, $order = []){
        if(
            empty($userInfo['school_id']) ||
            empty($userInfo['class_id']) ||
            empty($dateInfo['year']) ||
            empty($dateInfo['week'])
            ){
            return [];
        }

        $where = [
            'stattype' => self::STATE_TYPE_WEEK,
            'school_id' => $userInfo['school_id'],
            'grade' => $userInfo['grade'], 
            'class_id' => $userInfo['class_id'],
            'date.year' => $dateInfo['year'],
            'date.week' => $dateInfo['week'],
        ];

        $fields = [
            '$project' => [
                'userid' => 1,
                'burncalorie' => 1,
            ]
        ];

        $group = [
            '$group' => [
                '_id' => '$userid',
                'sum' => ['$sum' => '$burncalorie'],
            ]
        ];
        $aggregate = [
            ['$match' => $where],
            $fields,
            $group,
            ['$sort' => ['sum' => -1]],
        ];

        return $this->aggregate($aggregate);
    }

    public function getUserGradeWeekRank(array $userInfo, array $dateInfo, $order = []){
        if(
            empty($userInfo['school_id']) ||
            empty($userInfo['grade']) ||
            empty($dateInfo['year']) ||
            empty($dateInfo['week'])
            ){
            return [];
        }

        $where = [
            'stattype' => self::STATE_TYPE_WEEK,
            'school_id' => $userInfo['school_id'],
            'grade' => $userInfo['grade'], 
            'date.year' => $dateInfo['year'],
            'date.week' => $dateInfo['week'],
        ];

        $fields = [
            '$project' => [
                'class_id' => 1,
                'burncalorie' => 1,
            ]
        ];

        $group = [
            '$group' => [
                '_id' => '$class_id',
                'sum' => ['$sum' => '$burncalorie'],
            ]
        ];

        // 聚合二次分组
        $sGroup = [
            '$group' => [
                '_id' =>'$sum',
                'class' => ['$addToSet' => '$_id']
            ]
        ];

        $aggregate = [
            ['$match' => $where],
            $fields,
            $group,
            $sGroup,
            ['$sort' => ['_id' => -1]],
        ];

        return $this->aggregate($aggregate);
    }

    public function getUserBasicStatis(array $where){
        $fields = [
            '$project' => [
                'userid' => 1,
                'burncalorie' => 1,
                'totletime' => 1,
            ]
        ];

        $group = [
            '$group' => [
                '_id' => '$userid',
                'burncalorie' => ['$sum' => '$burncalorie'],
                'totletime'   => ['$sum' => '$totletime'],
            ]
        ];

        $aggregate = [
            ['$match' => $where],
            $fields,
            $group
        ];

        return $this->aggregate($aggregate);
    }

}