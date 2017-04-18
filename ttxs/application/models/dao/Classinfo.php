<?php
class Dao_ClassinfoModel extends Db_Mongodb {
    
    protected $table = 'classinfo';

    protected $fields = [
        'name' => '',                   // 班级名称
        'schoolname' => '',             // 学校名称
        'schoolid' => '',               // 学校id号
        'createtime' => 0,             // 信息创建时间
        'admissiontime' => 0,          // 班级入学时间
        'grade' => '',                  // 年级
        'classno' => '',                // 班级编号
        'malemembersid' => [],          // 男生成员id信息
        'femalemembersid' => [],        // 女生成员id信息
        'gymteacherid' => [],           // 管理体育老师id号
        'studentno' => 0,              // 学生总数量
        'pushtime' => [],               // 推送时间
        'exerciseproject' => [],        // 锻炼项目信息:[{type(锻炼类型),exerciseid(锻炼项目id),createtime(锻炼项目创建时间),endtime(项目截止时间),weekdoneno(周计划锻炼次数)}......]
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

    /**
     * 根据id获取班级信息
     * @Author    422909231@qq.com
     * @DateTime  2017-04-11
     * @copyright [copyright]
     * @param     string           $classId [description]
     * @param     array            $fields  [description]
     * @return    [type]                    [description]
     */
    public function getClassInfoByClassId(string $classId, $fields = []){
        $where = [
            '_id' => $classId,
        ];

        $fields = $this->filterFields($fields);

        if(!empty($fields)){
            $options['projection'] = $fields;
        }

        return $this->queryOne($where, $options);
    }

    public function getClassListByClassIds(array $classIds, $fields = [], $options = []){
        $newOptions = [];
        $where = [
            '_id' => ['$in' => $classIds],
        ];

        $fields = $this->filterFields($fields);
        if(!empty($fields)){
            $newOptions['projection'] = $fields;
        }

        $newOptions['limit'] = $options['limit'] ? (int)$options['limit'] : 20;
        $newOptions['skip'] = $options['offset'] ? (int)$options['offset'] : 0;
        if(!empty($options['sort']))
            $newOptions['sort'] = $options['sort'];

        return $this->query($where, $newOptions);
    }
}