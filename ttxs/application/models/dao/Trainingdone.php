<?php
class Dao_TrainingdoneModel extends Db_Mongodb {
    
    protected $table = 'trainingdone';

    protected $fields = [
        'type' => 0,               // 锻炼类型:1-体育作业(翻转课堂),2-运动处方(身体素质作业),3-跑步,4-兴趣班,5-普通锻炼项目...
        'trainingtype' => 0,       // 所属锻炼项目类型类型编号：1-跳绳运动，2-俯卧撑运动，3-高抬腿运动(编号内容会再调整)
        'trainingid' => '',         // 锻炼项目的id号
        'part' => 0,               // 锻炼项目中的节次信息,比如完成了"增肌训练第二节"
        'userid' => '',             // 用户(学生)id号
        'starttime' => 0,          // 开始时间
        'endtime' => 0,            // 结束时间
        'createtime' => 0,         // 创建时间
        'actioncount' => 0,        // 本次锻炼的动作数量
        'burncalories' => 0.00,       // 本次锻炼消耗卡路里
        'commenttext' => '',        // 锻炼感想/评论文本内容
        'commentaudio' => [],       // 锻炼感想/评论音频内容
        'commentvideo' => [],       // 锻炼感想/评论视频内容
        'exciseimg' => [],          // 锻炼监管和感想图片:[{type(图片类型:1-运动监督gif,2-运动感想添加图片),imgurl(图片地址)}......]
        'GPSinfo' => '',            // GPS地理位置信息
        'route' => [],              // 跑步路线
        'distance' => 0,           // 跑步距离
        'averagevelocity' => 0,    // 平均速度
        'pace' => [],               // 配速信息(按照第一公里,第二公里的顺序插入到数组中):[{speed(公里速度),time(时间),calories(消耗卡路里)}......]
        'region' => [],             // 区域{minlat(最小维度),maxlat(最大维度),minlon(最小经度),maxlon(最大经度)}
        'mapurl' => '',             // 地图图片
        'isdelay' => 0,            // 是否是延期作业(1-是，0-不是)
        'originaltime' => 0,       // 作业原始时间
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

    public function getListByPage(array $match, array $fields = [], array $options = []){
        $newOptions = [];
        $fields = $this->filterFields($fields);

        if(!empty($options['orderBy']))
            $newOptions['sort'] = [$options['orderBy'] => (int)($options['sort'] ? : -1)];

        $newOptions['limit'] = $options['limit'] ? : 10;
        $newOptions['skip'] = $options['offset'] ? : 0;
        $newOptions['projection'] = empty($fields) ? $this->fields : $fields;
    
        return $this->query($match, $newOptions);
    }
}