<?php 
class TrainhistoryAction extends BaseAction {

    protected function __declare(){
        $this->declareParams = true;
        $this->declarePageService = 'Service_User_Zone_TrainHistoryModel';
        $this->declareRender = array(
                'interface' => array(
                    ),
                );
    }
}
