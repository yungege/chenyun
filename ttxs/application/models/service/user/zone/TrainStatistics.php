<?php
class Service_User_Zone_TrainStatisticsModel extends BasePageService {

    protected $trainingdoneModel;
    protected $exerciseuserstatModel;
    protected $shareModel;

    public function __construct() {
        $this->trainingdoneModel = Dao_TrainingdoneModel::getInstance();
        $this->exerciseuserstatModel = Dao_ExerciseuserstatModel::getInstance();
        $this->shareModel = Dao_ShareModel::getInstance();
    }

    protected function __declare() {

    }

    protected function __execute($req) {
        $res = [];
        $uId = $req[strtolower(REQUEST_METHOD)]['client_set']['uid'];

        // 锻炼总次数
        $tMap['userid'] = $uId;
        $tMap['type'] = array('in',array(3,5));
        $trainCount = $this->trainingdoneModel->count([
            'userid' => $uId,
            'type' => ['$in' => [3,5]],
            ]);
        
        $sMap = [
            'stattype' => Dao_ExerciseuserstatModel::STATE_TYPE_TOTAL,
            'userid' => $uId,
            'exertype' => ['$in' => [1,2,3]],
        ];

        $statData = $this->exerciseuserstatModel->getUserBasicStatis($sMap)[0];
        if(!empty($statData)){
            $res['totalCalorie'] = $statData['burncalorie'];
            $res['trainingInterval'] = $statData['totletime'];
        }
        else{
            $res['totalCalorie'] = 0;
            $res['trainingInterval'] = 0;
        }

        $res['trainingCount'] = $trainCount;
        $res['shareCount'] = $this->shareModel->count([
            'user_id' => $uId,
            'share_type' => Dao_ShareModel::SHARE_TYPE_USER,
            ]);
        return $res;
    }

}
