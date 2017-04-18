<?php
/**
 * 错误信息输出
 *
 */

class ErrorController extends Yaf_Controller_Abstract {
    
	public function errorAction($exception) {
    	$errMsg = $exception->getMessage();
        if (DEBUG_MODE)
        {
            $res = [
        		'errCode' => 500,
        		'errMessage' => $errMsg,
        	];
			header('Content-type: application/json');
            exit(json_encode($res));
        }

    }
}
