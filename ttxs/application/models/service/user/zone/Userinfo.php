<?php
class Service_User_Zone_UserinfoModel extends BasePageService {

    protected $userModel;
    protected $sessionModel;

    protected $reqData;
    protected $uid;

    public function __construct() {
        $this->userModel = Dao_UserModel::getInstance();
        $this->sessionModel = Dao_SessionModel::getInstance();
    }

    protected function __declare() {

    }

    protected function __execute($req) {
        $this->reqData = $req[strtolower(REQUEST_METHOD)];
        $this->uid = $this->reqData['client_set']['uid'];

        switch (strtolower(REQUEST_METHOD)) {
            case 'get':
                return $this->getUserInfo();
                break;
            case 'post':
                return $this->updateUserInfo();
                break;
            default:
                # code...
                break;
        }
    }

    /**
     * 获取用户基本信息 get
     * @Author    422909231@qq.com
     * @DateTime  2017-04-17
     * @version   [version]
     * @return    []
     */
    protected function getUserInfo(){
        $userdata = $this->userModel->getUserInfoByUserId($this->uid);
        if(empty($userdata)){
            $this->errNo = USER_GET_FAILED;
            return [];
        }

        $value['uid']       = (string)$userdata['_id'];
        $value['nickname']  = $userdata['nickname'];
        $value['avator']    = $userdata['iconurl'];
        $value['gender']    = $userdata['sex'];
        $value['phone']     = $userdata['mobileno'];
        $value['address']   = $userdata['address'];
        $value['profile']   = $userdata['profile'];
        $value['relation']  = $userdata['parentrelationship'];
        $value['parentname'] = $userdata['parentname'];
        $value['birthday']  = $userdata['birthday'];

        return $value;
    }

    /**
     * 修改个人信息 post
     * @Author    422909231@qq.com
     * @DateTime  2017-04-17
     * @return    []
     */
    protected function updateUserInfo(){
        $update = [];

        $filter = new Sensitive_SensitiveWordFilter();
        if(!empty($this->reqData['nickname'])){
            if($filter->filter($this->reqData['nickname'], 1)){
                $this->errNo = USER_NAME_SENSITIVE;
                return;
            }else{
                $update['nickname'] = htmlspecialchars($this->reqData['nickname']);
                $this->sessionModel->updateSessionByUserid($this->uid, ['nickname'=>$update['nickname']]);
            }
        }
        if(!empty($this->reqData['avator'])){
            $update['iconurl'] = $this->reqData['avator'];
        }
        if(!empty($this->reqData['phone'])){
            $update['mobileno'] = (int)$this->reqData['phone'];
            $phonedata = $this->userModel->getUserInfoByMobile($update['mobileno'], ['_id']);
            if(!empty($phonedata)){
                $this->errNo = PHONENUM_HAS_EXIST;
                return;
            }
        }
        if(!empty($this->reqData['parentname'])){
            $update['parentname'] = $this->reqData['parentname'];
        }
        if(!empty($this->reqData['profile'])){
            $update['profile'] = $this->reqData['profile'];
        }
        if(!empty($this->reqData['relation'])){
            $update['parentrelationship'] = $this->reqData['relation'];
        }
        if(!empty($this->reqData['birthday'])){
            $update['birthday'] = $this->reqData['birthday'];
        }
        if(!empty($this->reqData['address'])){
            $update['address'] = $this->reqData['address'];
        }

        $res = $this->userModel->updateUserInfoByUserid($this->uid, $update);
        if(false === $res)
            $this->errNo = USER_MODIFY_FAILED;
        
        return;
    }
}
