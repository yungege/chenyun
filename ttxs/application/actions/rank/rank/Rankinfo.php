<?php

class RankinfoAction extends BaseAction {
	protected function __declare(){
	    $this->declareParams = true;
	    $this->declarePageService = 'Service_Rank_Rank_RankinfoModel';
	    $this->declareRender = array(
	        'interface' => array(
	        ),
	    );
	}
}