<?php

class UpuserlistAction extends BaseAction {
    protected function __declare(){
        $this->declareParams = true;
        $this->declarePageService = 'Service_Sport_Sport_UpuserlistModel';
        $this->declareRender = array(
            'interface' => array(
            ),
        );
    }
}