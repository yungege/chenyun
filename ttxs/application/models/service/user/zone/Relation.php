<?php
class Service_User_Zone_RelationModel extends BasePageService {

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
        switch (strtolower(REQUEST_METHOD)) {
            case 'get':
                return $this->getRelation($req);
                break;
            case 'post':
                $res = $this->addRelation($req);
                return;
                break;
            case 'delete':
                $res = $this->delRelation($req);
                return;
                break;
            default:
                # code...
                break;
        }
        
    }

    /**
     * 获取关联家长信息
     * @Author    422909231@qq.com
     * @DateTime  2017-04-18
     * @version   V0.7
     * @param     [type]           $req [description]
     * @return    [type]                [description]
     */
    protected function getRelation($req){
        $uId = $req['get']['client_set']['uid'];
        if(empty($uId))
            return [];

        $userData = $this->userModel
            ->getUserInfoByUserId($uId, ['parentinfo']);
        if(empty($userData['parentinfo']))
            return [];
        $res = [];
        foreach($userData['parentinfo'] as $parentinfo){
            $res['parentInfo'][] = [
                'relation' => $parentinfo['parentrelation'],
                'parentName' => $parentinfo['parentname'],
                'phone' => $parentinfo['phone']
            ];
        }
        
        return $res;
    }

    /**
     * 添加家长信息
     * @Author    422909231@qq.com
     * @DateTime  2017-04-18
     * @version   V0.7
     * @param     [type]           $req [description]
     */
    protected function addRelation($req){
        $postData = $req['post'];
        $uId = $postData['client_set']['uid'];
        if(empty($uId)){
            $this->errNo = USER_MODIFY_FAILED;
            return false;
        }
        $relation = (int)$postData['relation'];
        $parentname = htmlspecialchars($postData['parentName']);
        $phone = (int)$postData['phone'];

        if(empty($relation) || empty($parentname) || !preg_match("/^1\d{10}$/", $phone)){
            $this->errNo = USER_MODIFY_FAILED;
            return false;
        }

        $userdata = $this->userModel
            ->getUserInfoByUserId($uId, ['mobileno','parentinfo']);

        if(empty($userdata)){
            $this->errNo = USER_MODIFY_FAILED;
            return false;
        }

        // 判断该用户是否已经添加了该手机号
        if(!empty($userdata['parentinfo'])){
            foreach ($userdata['parentinfo'] as $row) {
                if($phone == $row['phone']){
                    $this->errNo = USER_EXIST_PHONE;
                    return false;
                }
            }
        }

        $insertParent = [
            'phone' => $phone,
            'parentrelation' => $relation,
            'parentname' => $parentname,
        ];
        if(!is_array($userdata['mobileno']) && !empty($userdata['mobileno'])){
            // 号码转成数组 兼容旧版本写法
            $mobileArr = [$userdata['mobileno'], $phone];
            $userdata['mobileno'] = $mobileArr;
            $userdata['parentinfo'][] = $insertParent;
        }elseif(!is_array($userdata['mobileno']) && empty($userdata['mobileno'])){
            $userdata['mobileno'] = [$phone];
            $userdata['parentinfo'][] = $insertParent;
        }else{
            $userdata['mobileno'][] = $phone;
            $userdata['parentinfo'][] = $insertParent;
        }
        unset($userdata['_id']);

        $res = $this->userModel->updateUserInfoByUserid($uId, $userdata);
        if(false === $res)
            $this->errNo = USER_MODIFY_FAILED;

        return $res;
    }

    /**
     * 删除关联家长信息
     * @Author    422909231@qq.com
     * @DateTime  2017-04-18
     * @version   V0.7
     * @param     [type]           $req [description]
     * @return
     */
    protected function delRelation($req){
        $uId = $req['delete']['client_set']['uid'];
        $phone = (int)$req['delete']['phone'];
        if(empty($uId) || !preg_match("/^1\d{10}$/", $phone)){
            $this->errNo = USER_MODIFY_FAILED;
            return false;
        }
        $userdata = $this->userModel
            ->getUserInfoByUserId($uId, ['ssoid','mobileno','parentinfo']);
        if(empty($userdata['ssoid']) && empty($userdata['mobileno'])){
            $this->errNo = USER_FORBID_MODIFY;
            return false;
        }

        $mobilenos = array();
        foreach((array)$userdata['mobileno'] as $mobileno){
            if($mobileno != $phone){
                $mobilenos[] = $mobileno;
            }
        }
        $userdata['mobileno'] = $mobilenos;

        $parentinfos = array();
        foreach($userdata['parentinfo'] as $parentinfo){
            if($parentinfo['phone'] != $phone){
                $parentinfos[] = $parentinfo;
            }
        }
        $userdata['parentinfo'] = $parentinfos;

        unset($userdata['_id'], $userdata['ssoid']);

        $res = $this->userModel->updateUserInfoByUserid($uId, $userdata);
        if(false === $res)
            $this->errNo = USER_MODIFY_FAILED;

        return $res;
    }

}