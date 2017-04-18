<?php
/**
 * 获取排名信息
 */

class Service_Rank_Rank_RankinfoModel extends BasePageService {

	protected $rankModel;
	protected $userModel;
    protected $classModel;

	protected static $rankType = [
        1 => '上周年级排名',  
		2 => '上周班级排名',
	];
	protected $reqData;
    protected $userInfo;
    protected $dateInfo;
    
    public function __construct() {
    	$this->userModel = Dao_UserModel::getInstance();
    	$this->rankModel = Dao_ExerciseuserstatModel::getInstance();
        $this->classModel = Dao_ClassinfoModel::getInstance();
    }

    protected function __declare() {
        // $this->declareLogin = true;
    }

    protected function __execute($req) {
        if(false === $this->__checkParams($req))
            return [];

        switch ($this->reqData['type']) {
            case '1':
                return $this->_getGradeRank();
                break;
            
            default:
                return $this->_getClassRank();
                break;
        }

	}

    /**
     * 参数校验
     * @Author    422909231@qq.com
     * @DateTime  2017-04-10
     * @param     [type]           $req [description]
     * @return    [type]                [description]
     */
    private function __checkParams($req){
    	$this->reqData = $req[strtolower(REQUEST_METHOD)];
    	if(empty($this->reqData['type']) || 
    		!in_array($this->reqData['type'], array_keys(self::$rankType))){
    		$this->reqData['type'] = 1;
    	}

        $this->dateInfo = Tools::getYmw(strtotime('-7 day'));
        $userInfo = $this->userModel->getUserInfoByUserId(
            $this->reqData['client_set']['uid'],
            ['_id','username','nickname','iconurl','schoolinfo','grade','classinfo']
            );

        if(empty($userInfo))
            return false;

        $this->userInfo = [
            'user_id'   => $userInfo['_id'],
            'username'  => $userInfo['username'],
            'nickname'  => $userInfo['nickname'],
            'iconurl'   => $userInfo['iconurl'],
            'school_id' => $userInfo['schoolinfo']['schoolid'],
            'school_name' => $userInfo['schoolinfo']['schoolname'],
            'class_id'  => $userInfo['classinfo']['classid'],
            'class_name' => $userInfo['classinfo']['classname'],
            'grade'     => $userInfo['grade'],
        ];
        return true;
    }

    // 上周班级排名
    protected function _getClassRank(){
        $list = $this->rankModel->getUserClassWeekRank($this->userInfo, $this->dateInfo);
        if(empty($list))
            return [];

        $highRang = [];
        foreach ($list as $row) {
            // 补充我的个人锻炼信息
            if($this->userInfo['user_id'] == $row['_id']){
                $myRank = [
                    'user_id' => $this->userInfo['user_id'],
                    'username' => $this->userInfo['username'],
                    'nickname' => $this->userInfo['nickname'],
                    'iconurl' => (string)$this->userInfo['iconurl'],
                    'burncalorie' => (float)$row['sum'],
                ];
            }

            // 补充前三名学生信息
            $r = (string)$row['sum'];
            $f = substr($r, 0, -2);
            if($f != 0 && strlen($r) >= 3){
                $firstNum = (int)$f * 100;
                if(empty($highRang)){
                    $endNum = ((int)$f+1) * 100;
                }
                else{
                    $endNum = $firstNum + 99;
                }
                $highRang[$firstNum . '-' . $endNum][] = $row['_id'];
            }
            else{
                $highRang['0-99'][] = $row['_id'];
            }
        }

        $highRang = array_splice($highRang, 0, 3);
        if(empty($highRang))
            return [];

        foreach ($highRang as $key => &$row) {
            $userInfo = $this->userModel->batchGetUserInfoByUserids(
                $row,
                ['_id','username','nickname','iconurl'],
                0,0
                );
            $row = $userInfo;
        }

        return [
            'rankList' => $highRang,
            'myRank' => $myRank,
        ];
    }

    // 上周年级排名
    protected function _getGradeRank(){
        $list = $this->rankModel->getUserGradeWeekRank($this->userInfo, $this->dateInfo);
        if(empty($list))
            return [];

        foreach ($list as $key => &$row) {
            $row['burncalorie'] = $row['_id'];

            // 补充我的班级锻炼信息
            if(in_array($this->userInfo['class_id'], $row['class'])){
                $myRank = [
                    'class_id' => $this->userInfo['class_id'],
                    'class_name' => $this->userInfo['class_name'],
                    'burncalorie' => $row['burncalorie'],
                ];
            }
        }

        $highRang = array_splice($list, 0, 3);
        if(empty($highRang))
            return [];

        // 补充学校班级信息
        foreach ($highRang as &$row) {
            unset($row['_id']);
            $classInfo = $this->classModel->getClassListByClassIds($row['class'],['name']);
            $row['class'] = (array)$classInfo;
        }

        return [
            'schoolInfo' => [
                'school_id' => $this->userInfo['school_id'],
                'school_name' => $this->userInfo['school_name'],
            ],
            'myRank' => $myRank,
            'rankList' => $highRang,
        ];
    }

}