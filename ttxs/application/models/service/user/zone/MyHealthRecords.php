<?php
class Service_User_Zone_MyHealthRecordsModel extends BasePageService {

    const PAGESIZE = 10;

    protected $physicalfitnesstestModel;

    protected static $testNames = [
        1   => ['身高测试','厘米'],
        2   => ['体重测试','千克'],
        3   => ['台阶试验','个'],
        4   => ['肺活量','毫升'],
        5   => ['50米跑','秒'],
        6   => ['立定跳远','厘米'],
        7   => ['坐位体前屈','个'],
        8   => ['握力','牛顿'],
        9   => ['50米×8往返跑','秒'],
        10  => ['800米跑','秒'] ,
        11  => ['1000米跑','秒'],
        12  => ['仰卧起坐','个'],
        13  => ['400米跑','秒'],
        14  => ['引体向上','个'],
        15  => ['掷实心球','米'],
        16  => ['投沙包','米'],
        17  => ['25米*2往返跑','秒'],
        18  => ['跳绳','个'],
        19  => ['篮球运球'],
        20  => ['足球运球'],
        21  => ['排球垫球','个'],
        22  => ['30秒踢键子','个'],
        23  => ['足球颠球','个']
    ];

    public function __construct() {
        $this->physicalfitnesstestModel = Dao_PhysicalfitnesstestModel::getInstance();
    }

    protected function __declare() {

    }

    protected function __execute($req) {
        $uId = $req['get']['client_set']['uid'];

        if(!empty($req['get']['page']) || !is_numeric($req['get']['page']))
            $req['get']['page'] = 1;
        if(!empty($req['get']['count']) || !is_numeric($req['get']['count']))
            $req['get']['count'] = 1;

        $testDatas = $this->physicalfitnesstestModel->getPhyInfoByUserid($uId)[0];
        if(empty($testDatas))
            return [];

        $healthRecords = array();
        foreach($testDatas['bodyshape'] as $bodyShape){
            if($bodyshape['testtype'] == 1){
                $data['itemName'] = self::$testNames[$bodyShape['itemnumber']][0];
                $data['itemUnit'] = self::$testNames[$bodyShape['itemnumber']][1];
                $data['itemScore'] = $bodyShape['score'];
                if($bodyShape['itemnumber'] == 1){
                    $data['itemValue'] = $bodyShape['heightvalue'];
                }elseif($bodyShape['itemValue'] == 2){
                    $data['itemValue'] = $bodyShape['weightvalue'];
                }
                $data['itemLevel'] = $bodyShape['rank'];
                $data['otherMeg'] = "";
                $healthRecords[$bodyShape['testtime']]['testTime'] = $bodyShape['testtime'];
                $healthRecords[$bodyShape['testtime']]['testType'] = 1;
                $healthRecords[$bodyShape['testtime']]['items'][] = $data;
                unset($data);
            }
            if($bodyshape['testtype'] == 2){
                $data['itemName'] = self::$testNames[$bodyShape['itemnumber']][0];
                $data['itemUnit'] = self::$testNames[$bodyShape['itemnumber']][1];
                $data['itemScore'] = $bodyShape['score'];
                if($bodyShape['itemnumber'] == 1){
                    $data['itemValue'] = $bodyShape['heightvalue'];
                }elseif($bodyShape['itemValue'] == 2){
                    $data['itemValue'] = $bodyShape['weightvalue'];
                }
                $data['itemLevel'] = $bodyShape['rank'];
                $data['otherMeg'] = "";
                $testTime = $bodyShape['testtime'] - 1;
                $healthRecords[$testTime]['testTime'] = $bodyShape['testtime'];
                $healthRecords[$testTime]['testType'] = 2;
                $healthRecords[$testTime]['items'][] = $data;
                unset($data);
            }
            
        }
        foreach($testDatas['bodyfunction'] as $bodyFunction){
            if($bodyFunction['testtype'] == 1){
                $data['itemName'] = self::$testNames[$bodyFunction['itemnumber']][0];
                $data['itemUnit'] = self::$testNames[$bodyFunction['itemnumber']][1];
                $data['itemScore'] = $bodyFunction['vitalcwscore'];
                $data['itemValue'] = $bodyFunction['vitalcapacityvalue'];
                $data['itemLevel'] = $bodyFunction['vitalcwrank'];
                $data['otherMeg'] = "";
                $healthRecords[$bodyFunction['testtime']]['testTime'] = $bodyFunction['testtime'];
                $healthRecords[$bodyFunction['testtime']]['testType'] = 1;
                $healthRecords[$bodyFunction['testtime']]['items'][] = $data;
                unset($data);
            }
            if($bodyFunction['testtype'] == 2){
                $data['itemName'] = self::$testNames[$bodyFunction['itemnumber']][0];
                $data['itemUnit'] = self::$testNames[$bodyFunction['itemnumber']][1];
                $data['itemScore'] = $bodyFunction['vitalcwscore'];
                $data['itemValue'] = $bodyFunction['vitalcapacityvalue'];
                $data['itemLevel'] = $bodyFunction['vitalcwrank'];
                $data['otherMeg'] = "";
                $testTime = $bodyFunction['testtime'] - 1;
                $healthRecords[$testTime]['testTime'] = $bodyFunction['testtime'];
                $healthRecords[$testTime]['testType'] = 2;
                $healthRecords[$testTime]['items'][] = $data;
                unset($data);
            }
            
        }
        foreach($testDatas['endurance'] as $endurance){
            if($endurance['testtype'] == 1){
                $data['itemName'] = self::$testNames[$endurance['itemnumber']][0];
                $data['itemUnit'] = self::$testNames[$endurance['itemnumber']][1];
                $data['itemScore'] = $endurance['score'];
                $data['itemValue'] = $endurance['value'];
                $data['itemLevel'] = $endurance['rank'];
                $data['otherMeg'] = "";
                $healthRecords[$endurance['testtime']]['testTime'] = $endurance['testtime'];
                $healthRecords[$endurance['testtime']]['testType'] = 1;
                $healthRecords[$endurance['testtime']]['items'][] = $data;
                unset($data);
            }
            if($endurance['testtype'] == 2){
                $data['itemName'] = self::$testNames[$endurance['itemnumber']][0];
                $data['itemUnit'] = self::$testNames[$endurance['itemnumber']][1];
                $data['itemScore'] = $endurance['score'];
                $data['itemValue'] = $endurance['value'];
                $data['itemLevel'] = $endurance['rank'];
                $data['otherMeg'] = "";
                $testTime = $endurance['testtime'] - 1;
                $healthRecords[$testTime]['testTime'] = $endurance['testtime'];
                $healthRecords[$testTime]['testType'] = 2;
                $healthRecords[$testTime]['items'][] = $data;
                unset($data);
            }
           
        }
        foreach($testDatas['flexibilitystrength'] as $fData){
            if($fData['testtype'] == 1){
                $data['itemName'] = self::$testNames[$fData['itemnumber']][0];
                $data['itemUnit'] = self::$testNames[$fData['itemnumber']][1];
                $data['itemScore'] = $fData['score'];
                $data['itemValue'] = $fData['value'];
                $data['itemLevel'] = $fData['rank'];
                $data['otherMeg'] = "";
                $healthRecords[$fData['testtime']]['testTime'] = $fData['testtime'];
                $healthRecords[$fData['testtime']]['testType'] = 1;
                $healthRecords[$fData['testtime']]['items'][] = $data;
                unset($data);
            }
            if($fData['testtype'] == 2){
                $data['itemName'] = self::$testNames[$fData['itemnumber']][0];
                $data['itemUnit'] = self::$testNames[$fData['itemnumber']][1];
                $data['itemScore'] = $fData['score'];
                $data['itemValue'] = $fData['value'];
                $data['itemLevel'] = $fData['rank'];
                $data['otherMeg'] = "";
                $testTime = $fData['testtime'] - 1;
                $healthRecords[$testTime]['testTime'] = $fData['testtime'];
                $healthRecords[$testTime]['testType'] = 2;
                $healthRecords[$testTime]['items'][] = $data;
                unset($data);
            }
            
        }
        foreach($testDatas['speeddexterity'] as $sData){
            if($sData['testtype'] == 1){
                $data['itemName'] = self::$testNames[$sData['itemnumber']][0];
                $data['itemUnit'] = self::$testNames[$sData['itemnumber']][1];
                $data['itemScore'] = $sData['score'];
                $data['itemValue'] = $sData['value'];
                $data['itemLevel'] = $sData['rank'];
                $data['otherMeg'] = "";
                $healthRecords[$sData['testtime']]['testTime'] = $sData['testtime'];
                $healthRecords[$sData['testtime']]['testType'] = 1;
                $healthRecords[$sData['testtime']]['items'][] = $data;
                unset($data);
            }
            if($sData['testtype'] == 2){
                $data['itemName'] = self::$testNames[$sData['itemnumber']][0];
                $data['itemUnit'] = self::$testNames[$sData['itemnumber']][1];
                $data['itemScore'] = $sData['score'];
                $data['itemValue'] = $sData['value'];
                $data['itemLevel'] = $sData['rank'];
                $data['otherMeg'] = "";
                $testTime = $sData['testtime'] - 1;
                $healthRecords[$testTime]['testTime'] = $sData['testtime'];
                $healthRecords[$testTime]['testType'] = 2;
                $healthRecords[$testTime]['items'][] = $data;
                unset($data);
            }
        }
        $healthDatas = array();
        rsort($healthRecords);
        $healthRecords = array_values($healthRecords);
        
        $no = count($healthRecords);
        $i = ($req['get']['page'] - 1) * $req['get']['count'];
        $no = $i + $req['get']['count'];
        for($i;$i < $no;$i++){
            if(!empty($healthRecords[$i])){
               array_push($healthDatas, $healthRecords[$i]);
            }
        }
        return ['healthRecords' => $healthDatas];
    }
}