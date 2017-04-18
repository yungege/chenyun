<?php
/**
 * 点赞用户列表
 */

class Service_Sport_Sport_UpuserlistModel extends BasePageService {

    const PAGESIZE = 16;

    protected $shareModel;
    protected $userModel;

    protected $reqData;
    
    public function __construct() {
        $this->upModel = Dao_UpModel::getInstance();
        $this->userModel = Dao_UserModel::getInstance();
    }

    protected function __declare() {
        $this->declareLogin = false;
    }

    protected function __execute($req) {
        $req = $req[strtolower(REQUEST_METHOD)];
        $uriPath = parse_url($_SERVER['REQUEST_URI'])['path'];
        preg_match_all('/upuserlist\/(\w+)/', $uriPath, $match);
        $shareId = $match[1][0];
        if(empty($shareId))
            return [];

        if(empty($req['pn']) || !is_numeric($req['pn']))
            $req['pn'] = 1;

        $options['limit'] = self::PAGESIZE;
        $options['offset'] = ($req['pn'] - 1) * self::PAGESIZE;

        if(empty($req['orderBy']))
            $req['orderBy'] = 'createtime';

        if(empty($req['sort']) || in_array($req['sort'], [-1,1]))
            $req['sort'] = -1;

        $options['sort'] = [$req['orderBy'] => $req['sort']];

        $userIds = $this->upModel->getUpUserListById($shareId, ['upperid'], $options);
        if(empty($userIds))
            return [];
        $userIds = array_column($userIds, 'upperid');
        return $this->userModel->batchGetUserInfoByUserids(
            $userIds, ['username','iconurl']);
    }

}