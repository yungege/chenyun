<?php
/**
 * @declare 入口文件
 */
define('APP_NAME', 'ttxs');
define('APP_DOMAIN', '');
define('APPLICATION_PATH', dirname(dirname(__FILE__)));
define('APP_PATH', APPLICATION_PATH.'/application');
define('VIEW_PATH', APP_PATH.'/views');
define('LOG_DIR', APP_PATH . '/log/');

if (!extension_loaded('yaf'))
	exit('yaf extension not install.');

$application = new Yaf_Application(APPLICATION_PATH . "/conf/application.ini");
$application->bootstrap()->run();
