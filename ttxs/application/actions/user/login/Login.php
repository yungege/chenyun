<?php 
class LoginAction extends BaseAction {

	protected function __declare(){
		$this->declareParams = true;
		$this->declarePageService = 'Service_User_Login_LoginModel';
		$this->declareRender = array(
				'interface' => array(
					),
				);
	}
}
