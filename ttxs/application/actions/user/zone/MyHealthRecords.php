<?php 
class MyhealthrecordsAction extends BaseAction {

    protected function __declare(){
        $this->declareParams = true;
        $this->declarePageService = 'Service_User_Zone_MyHealthRecordsModel';
        $this->declareRender = array(
                'interface' => array(
                    ),
                );
    }
}
