<?php
class Dao_PhysicalfitnesstestModel extends Db_Mongodb {
    
    protected $table = 'physicalfitnesstest';

    protected $fields = [
        'userid' => '',                    // 用户id信息
        'bodyshape' => [],                 // 身体形态[{grade(年级编号,小学:11-16,初中:21-23,高中31-33,大学:41-44),testtime(测试时间),testtype(测试类型:1-正式体测,0-平时训练体测),weightvalue(体重数值,比如78kg),score(身高体重分数),rank(身高体重等级:超重/正常体重/较低体重)}{grade(年级编号,小学:11-16,初中:21-23,高中31-33,大学:41-44),testtime(测试时间),testtype(测试类型:1-正式体测,0-平时训练体测),heightvalue(身高数值,比如178cm),score(身高体重分数),rank(身高体重等级:超重/正常体重/较低体重)}......]
        'bodyfunction' => [],              // 身体机能[{grade(年级编号,小学:11-16,初中:21-23,高中31-33,大学:41-44),testtime(测试时间),testtype(测试类型:1-正式体测,0-平时训练体测),itemnumber(测试项目编号),vitalcapacityvalue(肺活量数值),vitalcwindex(肺活量体重指数),vitalcwscore(肺活量体重分数),vitalcwrank(肺活量体重等级:优秀/良好/及格/不及格)}......]
        'endurance' => [],                 // 耐力项目[{grade(年级编号,小学:11-16,初中:21-23,高中31-33,大学:41-44),testtime(测试时间),testtype(测试类型:1-正式体测,0-平时训练体测),itemnumber(测试项目编号),value(耐力数值),score(耐力分数),rank(耐力等级:优秀/良好/及格/不及格,bodyquality(身体素质:0,1,2,3....))}......]
        'flexibilitystrength' => [],       // 柔韧力量项目[{grade(年级编号,小学:11-16,初中:21-23,高中31-33,大学:41-44),testtime(测试时间),testtype(测试类型:1-正式体测,0-平时训练体测),itemnumber(测试项目编号),value(柔韧力量数值),score(柔韧力量分数),rank(柔韧力量等级:优秀/良好/及格/不及格),bodyquality(身体素质:0,1,2,3....)}......]
        'speeddexterity' => [],            // 速度灵巧项目[{grade(年级编号,小学:11-16,初中:21-23,高中31-33,大学:41-44),testtime(测试时间),testtype(测试类型:1-正式体测,0-平时训练体测),itemnumber(测试项目编号),value(速度灵巧数值),score(速度灵巧分数),rank(速度灵巧等级:优秀/良好/及格/不及格),bodyquality(身体素质:0,1,2,3....)}......]
        'totalscore' => [],                // 总分信息[{grade(年级编号,小学:11-16,初中:21-23,高中31-33,大学:41-44),testtime(测试时间),score(总分数),rank(总分等级:优秀/良好/及格/不及格)}]
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

    public function getPhyInfoByUserid(string $userId){
        $where = [
            'userid' => $userId,
        ];

        return $this->query($where);
    }
}
