<?php 
class TrainstatisticsAction extends BaseAction {

    protected function __declare(){
        $this->declareParams = true;
        $this->declarePageService = 'Service_User_Zone_TrainStatisticsModel';
        $this->declareRender = array(
                'interface' => array(
                    ),
                );
    }
}
