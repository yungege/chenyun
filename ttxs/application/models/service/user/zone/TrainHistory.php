<?php
class Service_User_Zone_TrainHistoryModel extends BasePageService {

    const PAGESIZE = 10;

    protected $trainingdoneModel;
    protected $exerciseuserstatModel;
    protected $exerciseprogramModel;

    public function __construct() {
        $this->trainingdoneModel = Dao_TrainingdoneModel::getInstance();
        $this->exerciseuserstatModel = Dao_ExerciseuserstatModel::getInstance();
        $this->exerciseprogramModel = Dao_ExerciseprogramModel::getInstance();
    }

    protected function __declare() {

    }

    protected function __execute($req) {
        $data = [];

        $req = $req[strtolower(REQUEST_METHOD)];
        $uId = $req['client_set']['uid'];

        $page = (!isset($req['page']) || !is_numeric($req['page'])) ? 1 : $req['page'];
        $month = (int)$req['month'];
        $data['month'] = $month;

        $firstDay = strtotime(date('Y-m-1', $month));
        $lastDay = strtotime(date('Y-m-t', $month) . ' 23:59:59');

        $this->getCaloriePerMonth($month, $uId, $data);

        $hMap['starttime'] = ['$gte' => $firstDay, '$lte' => $lastDay];
        $hMap['userid'] = $uId;
        $hMap['type'] = array('$in' => array(1,2,3));
        $tCount = $this->trainingdoneModel->count($hMap);
        $data['pageCount'] = ceil($tCount / self::PAGESIZE);
        $data['trainCount'] = $tCount;

        $options = [
            'limit' => self::PAGESIZE,
            'offset' => ($page - 1) * self::PAGESIZE,
            'orderBy' => 'endtime',
            'sort' => -1,
        ];
        $fields = ['type','trainingid','starttime','endtime','burncalories','originaltime'];
        $hDatas = $this->trainingdoneModel->getListByPage($hMap, $fields, $options);
        foreach($hDatas as $hData){
            if($hData['type'] == 1){
                $trainData['pName'] = "翻转课堂";
            }
            else if($hData['type'] == 2){
                $trainData['pName'] = "身体素质锻炼";
            }
            else{
                $trainData['pName'] = "跑步锻炼";
                $trainData['pInterval'] = $hData['endtime'] - $hData['starttime'];
                $trainData['calorie'] = $hData['burncalories'];
                $trainData['originalTime'] = $hData['originaltime'];
                $trainData['pId'] = (string)$hData['_id'];
            }
            $trainData['hId'] = (string)$hData['trainingid'];
            $trainData['originalTime'] = $hData['originaltime'];
            $trainDatas[$hData['starttime']] = $trainData; 
        }

        $pMap['starttime'] = ['$gte' => $firstDay, '$lte' => $lastDay];
        $pMap['userid'] = $uId;
        $pMap['type'] = 5;
        $pOptions = [
            'orderBy' => 'starttime',
            'sort' => -1,
        ];
        $pFields = ['type','trainingid','starttime','endtime','burncalories','originaltime','exciseimg','imginfo'];
        $pDatas = $this->trainingdoneModel->getListByPage($pMap, $pFields, $pOptions);
        foreach($pDatas as $pData){
            if(empty($trainDatas[$pData['starttime']]))
                continue;

            $programData = $this->exerciseprogramModel->where(array('_id'=>$pData['trainingid']))->field('timeofeach')->find();
            $trainDatas[$pData['starttime']]['pInterval'] = $programData['timeofeach'];
            $trainDatas[$pData['starttime']]['finishTime'] = $pData['endtime'];
            $trainDatas[$pData['starttime']]['calorie'] = $pData['burncalories'];
            $trainDatas[$pData['starttime']]['pId'] = $pData['trainingid'];
            $trainDatas[$pData['starttime']]['trainingImgs'] = $pData['imginfo'];
            if(empty($trainDatas[$pData['starttime']]['trainingImgs']) && !empty($pData['exciseimg'])){
                foreach($pData['exciseimg'] as $exciseImg){
                    $exciseImgs['gifUrl'] = $exciseImg;
                    $exciseImgs['actionId'] = null;
                    $exciseImgs['isBurl'] = false;
                    $trainDatas[$pData['starttime']]['trainingImgs'][] = $exciseImgs;
                }
            }

        }
        $trainDatas = array_values((array)$trainDatas);
        if(empty($trainDatas)){
            $trainDatas = [];
        }
        $data['trainCount'] = count($trainDatas);
        $data['dayTrainings'] = $trainDatas;
        return $data;
    }

    /**
     * 获取该月份总卡路里
     * @Author    422909231@qq.com
     * @DateTime  2017-04-17
     * @version   [version]
     * @param     [type]           $month
     * @param     [type]           $uId
     * @param     [type]           &$data
     */
    protected function getCaloriePerMonth($month, $uId, &$data){
        $dateArr = Tools::getYmw($month);
        $statData = $this->exerciseuserstatModel->aggregate([
            ['$match' => [
                'date.year' => $dateArr['year'],
                'date.month' => $dateArr['month'],
                'stattype' => Dao_ExerciseuserstatModel::STATE_TYPE_MONTH,
                'userid' => $uId,
                'exertype' => ['$in' => [1,2,3]],
                ],
            ],
            ['$group' => [
                '_id' => '$userid',
                'calorie' => ['$sum' => '$burncalorie']
                ],
            ],
            ]);
        $data['calorie'] = 0;
        if(!empty($statData))
            $data['calorie'] = (float)$statData[0]['calorie'];

        return;
    }

}
