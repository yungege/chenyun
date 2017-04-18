<?php 
class RelationAction extends BaseAction {

    protected function __declare(){
        $this->declareParams = true;
        $this->declarePageService = 'Service_User_Zone_RelationModel';
        $this->declareRender = array(
                'interface' => array(
                    ),
                );
    }
}
