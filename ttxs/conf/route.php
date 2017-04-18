<?php
/**
 * yaf 路由同统一配置
 * 自定义路由 按以下格式配置
 * 'name' => [
 *      'match',
 *		['module' => 'model name', 'controller' => 'controller name', 'action' => 'action name'],   	
 * ],
 */

return [
	// User module
	// 登录
	'login' => [
		'/user/login',
		['module' => 'user', 'controller' => 'login', 'action' => 'login'],
	],
	'userinfo' => [
		'/user/userinfo',
		['module' => 'user', 'controller' => 'zone', 'action' => 'userinfo'],
	],
	'trainStatistics' => [
		'/user/trainStatistics',
		['module' => 'user', 'controller' => 'zone', 'action' => 'trainStatistics'],
	],
	'trainHistory' => [
		'/user/trainHistory',
		['module' => 'user', 'controller' => 'zone', 'action' => 'trainHistory'],
	],
	'myHealthRecords' => [
		'/user/myHealthRecords',
		['module' => 'user', 'controller' => 'zone', 'action' => 'myHealthRecords'],
	],
	'relation' => [
		'/user/relation',
		['module' => 'user', 'controller' => 'zone', 'action' => 'relation'],
	],

	// sport module
	// 获取banner图
	'banner' => [
		'/sport/banner',
		['module' => 'sport', 'controller' => 'sport', 'action' => 'banner'],
	],
	'share' => [
		'/sport/share',
		['module' => 'sport', 'controller' => 'sport', 'action' => 'share'],
	],
	'up' => [
		'/sport/up/(\w)',
		['module' => 'sport', 'controller' => 'sport', 'action' => 'up'],
	],
	'upuserlist' =>[
		'/sport/upuserlist/(\w)',
		['module' => 'sport', 'controller' => 'sport', 'action' => 'upuserlist'],
	],

	// rank module
	// 获取排名信息
	'rankinfo' => [
		'/rank/rankinfo',
		['module' => 'rank', 'controller' => 'rank', 'action' => 'rankinfo'],
	],
	'othergraderank' => [
		'/rank/othergraderank',
		['module' => 'rank', 'controller' => 'rank', 'action' => 'othergraderank'],
	],
];
