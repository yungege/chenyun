<?php
/**
 * 分享信息
 */

class Service_Sport_Sport_ShareModel extends BasePageService {

	protected $shareModel;
    protected $userModel;

    protected $reqData;
    protected $userInfo;

    protected static $type = [
        '1' => '年级动态',
        '2' => '班级动态',
    ];

    protected static $sort = [
        'ctime' => [1,-1],
        'up'    => [1,-1],
    ];

    protected $pagesize = 10;
    protected $first_pagesize = 2;
    
    public function __construct() {
    	$this->shareModel = Dao_ShareModel::getInstance();
        $this->userModel = Dao_UserModel::getInstance();
        $this->upModel = Dao_UpModel::getInstance();
    }

    protected function __declare() {
        // $this->declareLogin = false;
    }

    protected function __execute($req) {
        $this->checkParams($req);

        $this->userInfo = $this->userModel->getUserInfoByUserId(
            $this->reqData['client_set']['uid'],
            ['schoolinfo','classinfo','grade']
            );

        if($this->reqData['type'] == 1){
            $where = [
                'school_id' => $this->userInfo['schoolinfo']['schoolid'],
                'grade' => $this->userInfo['grade'],
            ];
        }
        else{
            $where = [
                'school_id' => $this->userInfo['schoolinfo']['schoolid'],
                'class_id' => $this->userInfo['classinfo']['classid'],
            ];
        }
        $fields = ['user_id','up_num','training_name','burncalories','imgs'];
        $list = $this->shareModel->getShareList(
            $where,
            $fields,
            $this->reqData
            );

        if(empty($list))
            return [];

        $userIds = array_unique(array_column($list, 'user_id'));
        
        $userInfos = $this->userModel->batchGetUserInfoByUserids(
            $userIds, ['username','iconurl']);

        $userInfos = array_column($userInfos, null, '_id');

        foreach ($list as &$row) {
            $isUped = $this->upModel->judgeUserHasUped(
                Dao_UpModel::TARGET_TYPE_DYNAMIC,
                $row['_id'], 
                $this->reqData['client_set']['uid']
                );
            $row['is_up'] = $isUped === false ? 0 : 1;
            $row['username'] = (string)$userInfos[$row['user_id']]['username'];
            $row['iconurl'] = (string)$userInfos[$row['user_id']]['iconurl'];
            
            unset($row['user_id']);
        }

        return $list;
    }

    protected function checkParams($req){
        $reqData = $req[strtolower(REQUEST_METHOD)];

        if(!isset(self::$type[$reqData['type']]))
            $reqData['type'] = 1;

        if(!is_numeric($reqData['pn']) || $reqData['pn'] < 1)
            $reqData['pn'] = 1;

        if(!isset(self::$sort[$reqData['orderBy']]))
            $reqData['orderBy'] = 'ctime';

        if(!in_array($reqData['sort'], self::$sort[$reqData['orderBy']]))
            $reqData['sort'] = -1;

        $this->getPageInfo($reqData['pn'], $reqData);
        $this->reqData = $reqData;
    }

    protected function getPageInfo($pn = 1, &$pageInfo){
        $pn -= 1;

        if($pn > 0){
            $pageInfo['offset'] = ($pn - 1) * $this->pagesize + $this->first_pagesize;
            $pageInfo['limit'] = $this->pagesize;
        }
        else{
            $pageInfo['offset'] = 0;
            $pageInfo['limit'] = $this->first_pagesize;
        }

    }

}