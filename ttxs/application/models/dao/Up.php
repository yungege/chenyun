<?php
class Dao_UpModel extends Db_Mongodb {

    const TARGET_TYPE_DYNAMIC = 1; //动态
    const TARGET_TYPE_ARTICLE = 2; //文章
    const TARGET_TYPE_COMMENT = 3; //评论
    
    protected $table = 'up';

    protected $fields = [
        'targetid' => '',                               // 目标id: 动态/文章/评论
        'type' => 0,                                    // 目标类型 1-动态,2-文章,3-评论
        'uppeeid' => '',                                // 被赞人id
        'upperid' => '',                                // 赞的人id
        'createtime' => 0,                              // 赞的时间
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
     * 点赞操作，每个用户只能操作一次
     * @Author    422909231@qq.com
     * @DateTime  2017-04-12
     * @copyright [copyright]
     * @param     string           $_id
     * @param     string           $userId
     * @return    bool
     */
    public function upByUid(string $_id, string $userId){
        $shareModel = Dao_ShareModel::getInstance();
        $shareInfo = $shareModel->getShareInfoById($_id, ['user_id']);
        if(empty($shareInfo))
            return false;

        // 已经点赞
        if(false !== $this->judgeUserHasUped(
            self::TARGET_TYPE_DYNAMIC,$_id,$userId)){
            return false;
        }
            
        $data = [
            'targetid' => $_id,
            'type' => self::TARGET_TYPE_DYNAMIC,
            'uppeeid' => $shareInfo['user_id'],
            'upperid' => $userId,
            'createtime' => time(),
        ];

        $res = $this->insert($data);
        if(false === $res)
            return false;

        $shareModel->updateUpCountById($shareInfo['_id'], 1, '+');
        return true;
    }

    /**
     * 取消点赞操作，每个用户只能操作一次
     * @Author    422909231@qq.com
     * @DateTime  2017-04-12
     * @copyright [copyright]
     * @param     string           $_id
     * @param     string           $userId
     * @return    bool
     */
    public function cancelUpByUid(string $_id, string $userId){
        $shareModel = Dao_ShareModel::getInstance();
        $shareInfo = $shareModel->getShareInfoById($_id, ['user_id','up_num']);
        if(empty($shareInfo))
            return false;

        // 没有点过赞
        $upId = $this->judgeUserHasUped(
            self::TARGET_TYPE_DYNAMIC,$_id,$userId);
        if(false === $upId)
            return false;

        $res = $this->delete(['_id' => $upId]);
        if(false === $res)
            return false;

        // 不能小于0
        if($shareInfo['up_num'] > 0)
            $shareModel->updateUpCountById($shareInfo['_id'], 1, '-');

        return true;
    }

    /**
     * 分页获取点赞用户
     * @Author    422909231@qq.com
     * @DateTime  2017-04-13
     * @copyright [copyright]
     * @param     string           $_id     [description]
     * @param     array            $fields  [description]
     * @param     array            $options [description]
     * @return    [type]                    [description]
     */
    public function getUpUserListById(string $_id, $fields = [], array $options){
        $newOptions = [];
        $where = [
            'targetid' => $_id,
        ];

        $fields = $this->filterFields($fields);
        if(!empty($fields))
            $newOptions['projection'] = $fields;

        $newOptions['limit'] = $options['limit'] ? (int)$options['limit'] : 20;
        $newOptions['skip'] = (int) $options['offset'];

        if(!empty($options['sort']))
            $newOptions['sort'] = $options['sort'];

        return $this->query($where, $newOptions);
    }

    /**
     * 判断当前用户是否点过赞 是:返回点赞_id 否 false
     * @Author    422909231@qq.com
     * @DateTime  2017-04-13
     * @copyright [copyright]
     * @param     int              $type   [description]
     * @param     string           $_id    [description]
     * @param     string           $userId [description]
     * @return    [type]                   [description]
     */
    public function judgeUserHasUped(int $type, string $_id, string $userId){
        $where = [
            'type' => $type,
            'targetid' => $_id,
            'upperid' => $userId
        ];

        $upInfo = $this->queryOne(
            ['type' => $type, 'targetid' => $_id, 'upperid' => $userId],
            ['projection' => ['_id' => 1],'limit' => 1]
            );

        if(empty($upInfo)){
            return false;
        }
        else{
            return $upInfo['_id'];
        }
    }
}