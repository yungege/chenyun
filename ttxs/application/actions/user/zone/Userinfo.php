<?php 
class UserinfoAction extends BaseAction {

    protected function __declare(){
        $this->declareParams = true;
        $this->declarePageService = 'Service_User_Zone_UserinfoModel';
        $this->declareRender = array(
                'interface' => array(
                    ),
                );
    }
}
