<?php
/**
 * banner 图
 */
class Dao_BannerModel extends Db_Mongodb {
    
    protected $table = 'banner';

    protected $fields = [
        'title' => '',            // 标题
        'creator' => '',          // 创建者
        'creatime' => 0,          // 创建时间
        'h5url' => '',            // H5页面的URL
        'h5content' => '',        // H5内容
        'coverimgurl' => '',      // 封面图片URL
        'starttime' => 0,         // 开始时间
        'endtime' => 0,           // 结束时间
        'access' => [],           // 可访问范围控制(以学校为单位)
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

    public function getBannerList($where = [], $options = []){
        $time = time();
        if(empty($where)){
            $where = [
                'starttime' => ['$lte' => $time],
                'endtime' => ['$gte' => $time],
            ];
        }

        if(empty($options)){
            $options = [
                'limit' => 10,
            ];
        }

        return $this->query($where, $options);
    }
}