<?php

class BannerAction extends BaseAction {
	protected function __declare(){
	    $this->declareParams = true;
	    $this->declarePageService = 'Service_Sport_Sport_BannerModel';
	    $this->declareRender = array(
	        'interface' => array(
	        ),
	    );
	}
}