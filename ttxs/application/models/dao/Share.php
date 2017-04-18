<?php
/**
 * 作业锻炼分享
 */

class Dao_ShareModel extends Db_Mongodb {

    const SHARE_TYPE_SYSTEM = 1; //提交作业系统自动分享
    const SHARE_TYPE_USER   = 2; //提交作业后用户主动分享
    
    protected $table = 'share';

    protected $fields = [
        'user_id'   => '',
        'school_id' => '',
        'grade'     => 0,
        'class_id'  => '',
        'share_type'    => 1,   //1-系统分享，2-用户主动分享
        'program_type'  => 0,   //锻炼类型:1-体育作业(翻转课堂),2-运动处方(身体素质作业),3-跑步,4-兴趣班,5-普通锻炼项目...
        'training_type' => 0,   //所属锻炼项目类型类型编号：1-跳绳运动，2-俯卧撑运动，3-高抬腿运动(编号内容会再调整)
        'training_id'   => '',  //锻炼项目的id号
        'training_name' => '',  //项目名称
        'burncalories' => 0.00, //卡路里
        'up_num'    => 0,       //点赞用户数
        'imgs'      => [],      //图片url数组
        'work_id'   => '',      //分享作业的ID
        'ctime'     => 0,       //分享时间
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

    public function getShareInfoById(string $_id, $fields = []){
        $where = [
            '_id' => $_id,
        ];
        $fields = $this->filterFields($fields);
        if(!empty($fields))
            $options['projection'] = $fields;

        return $this->queryOne($where, $options);
    }

    /**
     * 分页获取分享信息
     * @Author    422909231@qq.com
     * @DateTime  2017-04-12
     * @copyright [copyright]
     * @param     array             $match
     * @param     array             $fields
     * @param     array             $options
     * orderBy sort limit offset
     * @return    array
     */
    public function getShareList(array $match, array $fields, $options = []){
        $newOptions = [];
        $fields = $this->filterFields($fields);

        if(!empty($options['orderBy']))
            $newOptions['sort'] = [$options['orderBy'] => (int)($options['sort'] ? : -1)];

        $newOptions['limit'] = $options['limit'] ? : 10;
        $newOptions['skip'] = $options['offset'] ? : 0;
        $newOptions['projection'] = empty($fields) ? $this->fields : $fields;
    
        return $this->query($match, $newOptions);
    }

    public function updateUpCountById(string $_id, int $num = 1, $sympol = '+'){
        $where = [
            '_id' => $_id,
        ];

        $num = (int)($sympol === '+' ? $num : -$num);

        $update = [
            '$inc' => ['up_num' => $num],
        ];

        return $this->update($where, $update);
    }

}