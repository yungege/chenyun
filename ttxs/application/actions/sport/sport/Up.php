<?php

class UpAction extends BaseAction {
    protected function __declare(){
        $this->declareParams = true;
        $this->declarePageService = 'Service_Sport_Sport_UpModel';
        $this->declareRender = array(
            'interface' => array(
            ),
        );
    }
}