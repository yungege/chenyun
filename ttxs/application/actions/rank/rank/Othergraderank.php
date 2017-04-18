<?php

class OthergraderankAction extends BaseAction {
    protected function __declare(){
        $this->declareParams = true;
        $this->declarePageService = 'Service_Rank_Rank_OthergraderankModel';
        $this->declareRender = array(
            'interface' => array(
            ),
        );
    }
}