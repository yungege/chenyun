<?php
/**
 * 点赞信息
 */

class Service_Sport_Sport_UpModel extends BasePageService {

    protected $upModel;
    protected $userModel;

    protected $reqData;
    protected $userInfo;
    
    public function __construct() {
        $this->upModel = Dao_UpModel::getInstance();
        $this->userModel = Dao_UserModel::getInstance();
    }

    protected function __declare() {
        // $this->declareLogin = false;
    }

    protected function __execute($req) {
        $uid = $req[strtolower(REQUEST_METHOD)]['client_set']['uid'];
        $uriPath = parse_url($_SERVER['REQUEST_URI'])['path'];
        preg_match_all('/up\/(\w+)/', $uriPath, $match);
        $shareId = $match[1][0]; // 分享动态ID
        if(empty($shareId)){
            $this->errNo = UP_ERROR_IDNEED_SPORT;
            return;
        }

        switch (strtolower(REQUEST_METHOD)) {
            case 'post':
                $res = $this->upModel->upByUid($shareId, $uid);
                if(false === $res)
                    $this->errNo = UP_OPTION_FAILED;
                break;

            case 'delete':
                $res = $this->upModel->cancelUpByUid($shareId, $uid);
                if(false === $res)
                    $this->errNo = UP_CANCEL_ERROR_IDNEED;
                break;

            default:
                # code...
                break;
        }
        
        return;
    }

}