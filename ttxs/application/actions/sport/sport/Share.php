<?php

class ShareAction extends BaseAction {
	protected function __declare(){
	    $this->declareParams = true;
	    $this->declarePageService = 'Service_Sport_Sport_ShareModel';
	    $this->declareRender = array(
	        'interface' => array(
	        ),
	    );
	}
}