<?php
class Service_User_Login_LoginModel extends BasePageService {

	protected $userModel;
	protected $sessionModel;
    protected $physicalfitnesstestModel;

	protected $reqData;
	protected $resData;

	protected static $platform = [
        0 => 'phone',
        1 => 'wx',
        2 => 'qq',
    ];

    public function __construct() {
		$this->userModel = Dao_UserModel::getInstance();
        $this->sessionModel = Dao_SessionModel::getInstance();
        $this->physicalfitnesstestModel = Dao_PhysicalfitnesstestModel::getInstance();
    }

    protected function __declare() {
    	// 关闭登录验证
        $this->declareLogin = false;
    }

    protected function __execute($req) {
        // $this->declareLogin = true;
        // if($this->_checkLogin($req) === true)
        //     return;

        $res = $this->__checkParams($req);
        if(false === $res){
			return;
        }

        switch ($this->reqData['platform']) {
        	case 'wx':
        		$this->__wechatOrQQLogin(Dao_UserModel::SSO_SOURCE_WEIXIN_APP);
        		break;

        	case 'qq':
        		$this->__wechatOrQQLogin(Dao_UserModel::SSO_SOURCE_QQ_APP);
        		break;
        	
        	default:
        		$this->__phoneLogin();
        		break;
        }

        return $this->resData;
	}

    private function __checkParams($req){
    	$this->reqData = $req[strtolower(REQUEST_METHOD)];
		if(
			empty($this->reqData['platform']) || 
			!in_array($this->reqData['platform'], array_values(self::$platform))){
			$this->errNo = USER_PLATFORM_EMPTY;
			return false;
		}

		if($this->reqData['platform'] == 'qq' || $this->reqData['platform'] == 'wx'){
			if(empty($this->reqData['open_id'])){
				return false;
			}
		}
		else{
			if(empty($this->reqData['phone'])){
				$this->errNo = USER_UA_PW_ERROR;
				return false;
			}
		}

		return true;
    }

    private function __wechatOrQQLogin($ssoSource){
    	$ssoId = $this->reqData['open_id'];
        $userInfo = $this->userModel->getUserInfoBySsoid((string)$ssoId)[0];

        if(empty($userInfo))
        {
        	$this->errNo = USER_USER_NON_EXSIT;
            return false;
        }

        $client = $this->reqData['client_set'];
        $key = Tools::grante_key();
        $token = md5($userInfo['_id'] . $key);
        $sessionInfo = $this->sessionModel->getSessionInfoByUserid((string)$userInfo['_id'])[0];

        if(!empty($sessionInfo)){
            $sessionInfo['key'] = $key;
            $sessionInfo['lastoperationtime'] = time();
            $sessionInfo['ssoid'] = $ssoId;

            $this->sessionModel->updateSessionByUserid((string)$userInfo['_id'], $sessionInfo);

            $data = [
            	'devicetoken' 	=> $client['devicetoken'],
            	'deviceid' 		=> $client['dv'],
            	'versions' 		=> $client['v'],
            	'clientsource' 	=> $client['pt'],
                'source'        => self::$platform[$ssoSource],
            ];
            $this->userModel->updateUserInfoByUserid((string)$userInfo['_id'], $data);
           
            $physicalfitnesstestdata = $this->physicalfitnesstestModel
            	->getPhyInfoByUserid((string)$userInfo['_id'])[0];

            $weighttesttime = 0;
            $heighttesttime = 0;

            foreach($physicalfitnesstestdata['bodyshape'] as $bodyshape){
                if(($bodyshape['testtime'] >= $weighttesttime) && (!empty($bodyshape['weightvalue']))){
                    $weighttesttime = $bodyshape['testtime'];
                    $weightvalue = $bodyshape['weightvalue'];
                }
                if(($bodyshape['testtime'] >= $heighttesttime) && (!empty($bodyshape['heightvalue']))){
                    $heighttesttime = $bodyshape['testtime'];
                    $heightvalue = $bodyshape['heightvalue'];
                }
            }

            $this->resData = [
            	'heightvalue' 	=> $heightvalue,
            	'weightvalue' 	=> $weightvalue,
            	'birthday' 		=> $userInfo['birthday'],
            	'uid' 			=> $sessionInfo['userid'],
            	'sid' 			=> $token,
            	'avator'	 	=> $userInfo['iconurl'],
            	'type' 			=> $userInfo['type'],
            	'nickname' 		=> $sessionInfo['nickname'],
            	'isfirst' 		=> 'NO',
            	'lastsubmittime' => (int)$userInfo['lastsubmittime'],
            	'phone' 		=> $userInfo['mobileno'],
            	'gender' 		=> $userInfo['sex'],
            	'address' 		=> $userInfo['address'],
            	'profile' 		=> $userInfo['profile'],
            	'relation' 		=> empty($userInfo['parentrelationship']) ? 7 : $userInfo['parentrelationship'],
            	'parentname' 	=> $userInfo['parentname'],
                'relationUsers' => $this->getRelationAccount($userInfo['mobileno']),
            ];

            return true;
        }
        else
        {
        	$session = [
        		'userid' 	=> (string)$userInfo['_id'],
        		'nickname' 	=> $userInfo['nickname'],
        		'username' 	=> $userInfo['username'],
        		'ssoid' 	=> $userInfo['ssoid'],
        		'ssosource' => $userInfo['source'],
        		'key' 		=> $key,
        		'lastoperationtime' => time(),
        	];
            $sessionid = (string) $this->sessionModel->insert($session);
            $data = [
            	'devicetoken' 	=> $client['devicetoken'],
            	'deviceid' 		=> $client['dv'],
            	'versions' 		=> $client['v'],
            	'clientsource'	=> $client['pt'],
            	'sessionid' 	=> $sessionid,
                'source'        => self::$platform[$ssoSource],
            ];
            $this->userModel->updateUserInfoByUserid((string)$userInfo['_id'], $data);

            $physicalfitnesstestdata = $this->physicalfitnesstestModel
            	->getPhyInfoByUserid((string)$userInfo['_id'])[0];

            $weighttesttime = 0;
            $heighttesttime = 0;

            foreach($physicalfitnesstestdata['bodyshape'] as $bodyshape){
                if(($bodyshape['testtime'] > $weighttesttime) && (!empty($bodyshape['weightvalue']))){
                    $weighttesttime = $bodyshape['testtime'];
                    $weightvalue = $bodyshape['weightvalue'];
                }
                if(($bodyshape['testtime'] > $heighttesttime) && (!empty($bodyshape['heightvalue']))){
                    $heighttesttime = $bodyshape['testtime'];
                    $heightvalue = $bodyshape['heightvalue'];
                }
            }

            $this->resData = [
            	'heightvalue' 	=> $heightvalue,
            	'weightvalue' 	=> $weightvalue,
            	'birthday' 		=> $userInfo['birthday'],
            	'uid' 			=> $session['userid'],
            	'sid' 			=> $token,
            	'nickname' 		=> $session['nickname'],
            	'isfirst' 		=> 'NO',
            	'lastsubmittime' => (int)$userInfo['lastsubmittime'],
            	'type' 			=> $userInfo['type'],
            	'gender' 		=> $userInfo['sex'],
            	'avator' 		=> $userInfo['iconurl'],
            	'phone' 		=> $userInfo['mobileno'],
            	'address' 		=> $userInfo['address'],
            	'profile' 		=> $userInfo['profile'],
            	'relation' 		=> empty($userInfo['parentrelationship']) ? 7 : $userInfo['parentrelationship'],
            	'parentname' 	=> $userInfo['parentname'],
                'relationUsers' => $this->getRelationAccount($userInfo['mobileno']),
            ];

            return true;
        }
    }

    private function __phoneLogin(){
    	$postdata = $this->reqData;

        $password = (int)$postdata['password'];
        $phone = (int)$postdata['phone'];

        $userdata = $this->userModel->getUserInfoByMobile($phone)[0];

        if(empty($userdata)){
        	$this->errNo = USER_USER_NON_EXSIT;
        	return false;
        }

        $client = $postdata['client_set'];
        
        $key = Tools::grante_key();
        $token = md5((string)$userdata['_id'].$key);

        $sessionInfo = $this->sessionModel->getSessionInfoByUserid($userdata['_id'])[0];
        if(!empty($sessionInfo)){
            $datas = [
            	'devicetoken'  => $client['devicetoken'],
            	'deviceid'     => $client['dv'],
            	'versions'     => $client['v'],
                'source'       => 'phone',
            ];
            $this->userModel->updateUserInfoByUserid($userdata['_id'], $datas);

            $sessionInfo['key'] = $key;
            $sessionInfo['lastoperationtime'] = time();
            $sessionInfo['ssoid'] = $phone;
            $this->sessionModel->updateSessionByUserid($userdata['_id'], $sessionInfo);
            
            $physicalfitnesstestdata = $this->physicalfitnesstestModel->getPhyInfoByUserid($userdata['_id']);
            $weighttesttime = 0;
            $heighttesttime = 0;

            foreach($physicalfitnesstestdata['bodyshape'] as $bodyshape){
                if(($bodyshape['testtime'] > $weighttesttime) && (!empty($bodyshape['weightvalue']))){
                    $weighttesttime = $bodyshape['testtime'];
                    $weightvalue = $bodyshape['weightvalue'];
                }
                if(($bodyshape['testtime'] > $heighttesttime) && (!empty($bodyshape['heightvalue']))){
                    $heighttesttime = $bodyshape['testtime'];
                    $heightvalue = $bodyshape['heightvalue'];
                }
            }
            
            $this->resData = [
            	'lastsubmittime' 	=> (int)$userdata['lastsubmittime'],
            	'heightvalue' 		=> $heightvalue,
            	'weightvalue' 		=> $weightvalue,
            	'birthday' 			=> $userdata['birthday'],
            	'uid' 				=> $sessionInfo['userid'],
            	'sid' 				=> $token,
            	'nickname' 			=> $userdata['nickname'],
            	'avator' 			=> $userdata['iconurl'],
            	'gender' 			=> $userdata['sex'],
            	'phone' 			=> $userdata['mobileno'],
            	'address' 			=> $userdata['address'],
            	'profile' 			=> $userdata['profile'],
            	'relation' 			=> empty($userdata['parentrelationship']) ? 7 : $userdata['parentrelationship'],
            	'parentname' 		=> $userdata['parentname'],
            	'isfirst' 			=> 'NO',
            	'ismatch' 			=> empty($userdata['mobileno']) ? 'NO' : 'YES',
            	'type' 				=> $userdata['type'],
                'relationUsers'     => $this->getRelationAccount($userdata['mobileno']),
            ];

            return true;
        }
        else
        {
            $session = [
            	'userid' 	=> $userdata['_id'],
            	'nickname' 	=> $userdata['nickname'],
            	'username' 	=> $userdata['username'],
            	'ssoid'		=> $phone,
            	'ssosource'	=> $userdata['source'],
            	'key'		=> $key,
            	'lastoperationtime'=> time(),
            ];
            $sessionid = $this->sessionModel->insert($session);
            $sessionid = (string)$sessionid;
            $datas = [
            	'devicetoken'  => $client['devicetoken'],
            	'deviceid'     => $client['dv'],
            	'versions'     => $client['v'],
            	'sessionid'    => $sessionid,
                'source'       => 'phone',
            ];
            $this->userModel->updateUserInfoByUserid($userdata['_id'], $datas);

            $physicalfitnesstestdata = $this->physicalfitnesstestModel->getPhyInfoByUserid($userdata['_id']);
            $weighttesttime = 0;
            $heighttesttime = 0;

            foreach($physicalfitnesstestdata['bodyshape'] as $bodyshape){
                if(($bodyshape['testtime'] > $weighttesttime) && (!empty($bodyshape['weightvalue']))){
                    $weighttesttime = $bodyshape['testtime'];
                    $weightvalue = $bodyshape['weightvalue'];
                }
                if(($bodyshape['testtime'] > $heighttesttime) && (!empty($bodyshape['heightvalue']))){
                    $heighttesttime = $bodyshape['testtime'];
                    $heightvalue = $bodyshape['heightvalue'];
                }
            }

            $this->resData = [
            	'heightvalue' 	=> $heightvalue,
            	'weightvalue' 	=> $weightvalue,
            	'birthday' 		=> $userdata['birthday'],
            	'type' 			=> $userdata['type'],
            	'uid' 			=> $session['userid'],
            	'sid' 			=> $token,
            	'lastsubmittime' => (int)$userdata['lastsubmittime'],
            	'nickname' 		=> $userdata['nickname'],
            	'avator' 		=> $userdata['iconurl'],
            	'gender' 		=> $userdata['sex'],
            	'phone' 		=> $userdata['mobileno'],
            	'address' 		=> $userdata['address'],
            	'profile' 		=> $userdata['profile'],
            	'relation' 		=> empty($userdata['parentrelationship']) ? 7 : $userdata['parentrelationship'],
            	'parentname' 	=> $userdata['parentname'],
                'relationUsers' => $this->getRelationAccount($userdata['mobileno']),
            ];
            
            return true;
        } 
    }

    /**
     * 获取手机关联账号列表
     * @Author    422909231@qq.com
     * @DateTime  2017-04-17
     * @version   [version]
     * @param     int              $mobileno [description]
     * @return    [type]                     [description]
     */
    protected function getRelationAccount($mobileno){
        if(empty($mobileno))
            return [];

        $list = $this->userModel->getRelationAccount(
            (int)$mobileno,
            ['username','nickname','iconurl']
            );

        if(empty($list))
            return [];
        $tmp = [];
        foreach ($list as $row) {
            $item['userId'] = $row['_id'];
            $item['avator'] = $row['iconurl'];
            $item['userName'] = $row['username'];
            $item['nickName'] = $row['nickname'];
            $tmp[] = $item;
        }

        return $tmp;
    }
    

}















