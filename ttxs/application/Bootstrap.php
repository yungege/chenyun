<?php

class Bootstrap extends Yaf_Bootstrap_Abstract {
    protected $config;

    public function _initConfig(Yaf_Dispatcher $dispatcher) {
        $this->config = Yaf_Application::app()->getConfig();
        Yaf_Registry::set('config', $this->config);
        //判断请求方式，命令行请求应跳过一些HTTP请求使用的初始化操作，如模板引擎初始化
        define('REQUEST_METHOD', strtoupper($dispatcher->getRequest()->getMethod()));
        Yaf_Loader::import(APPLICATION_PATH . '/conf/defines.inc.php');
    }

    public function _initError(Yaf_Dispatcher $dispatcher) {
        if ($this->config->application->debug)
        {
            define('DEBUG_MODE', true);
			//error_reporting("E_ALL & ~E_NOTICE");
            //ini_set('display_errors', 'On');
            //error_reporting(E_PARSE | E_ERROR);
        }
        else
        {
            define('DEBUG_MODE', false);
            ini_set('display_errors', 'Off');
        }
    }

    public function _initPlugin(Yaf_Dispatcher $dispatcher) {
        if (isset($this->config->application->benchmark) && $this->config->application->benchmark == true)
        {
            $benchmark = new BenchmarkPlugin();
            $dispatcher->registerPlugin($benchmark);
        }
    }

    public function _initRoute(Yaf_Dispatcher $dispatcher) {
		// 走 .ini 配置文件
		/*
		$routes = $this->config->routes;
		if (!empty($routes))
        {
            $router = $dispatcher->getRouter();
            $router->addConfig($routes);
        }
		*/
		
		// 走 .php 配置数组
		$routes = require_once APPLICATION_PATH . '/conf/route.php';
		if (!empty($routes))
		{
			$router = $dispatcher->getRouter();
			
			foreach ($routes as $name => $route) {
				list($match, $mvc) = $route;
				$routeObj  = new Yaf_Route_Rewrite($match, $mvc);
				$router->addRoute($name, $routeObj);
			}
		}
	}

    // public function _initMemcache() {
    //     if (!empty($this->config->cache->caching_system))
    //     {
    //         Yaf_Registry::set('cache_exclude_table', explode('|', $this->config->cache->cache_exclude_table));
    //         Yaf_Loader::import(APPLICATION_PATH . '/library/Cache/Cache.php');
    //         if (isset($this->config->cache->prefix))
    //         {
    //             define('CACHE_KEY_PREFIX', $this->config->cache->prefix);
    //         }
    //         if (isset($this->config->cache->object_cache_enable) && $this->config->cache->object_cache_enable)
    //         {
    //             define('OBJECT_CACHE_ENABLE', true);
    //         }
    //         else
    //         {
    //             define('OBJECT_CACHE_ENABLE', false);
    //         }
    //     }
    //     else
    //     {
    //         define('MYSQL_CACHE_ENABLE', false);
    //         define('OBJECT_CACHE_ENABLE', false);
    //     }
    // }

    // public function _initDatabase() {
    //     $servers = array();
    //     $database = $this->config->database;
    //     $servers[] = $database->master->toArray();
    //     $slaves = $database->slaves;
    //     if (!empty($slaves))
    //     {
    //         $slave_servers = explode('|', $slaves->servers);
    //         $slave_users = explode('|', $slaves->users);
    //         $slave_passwords = explode('|', $slaves->passwords);
    //         $slave_databases = explode('|', $slaves->databases);
    //         $slaves = array();
    //         foreach ($slave_servers as $key => $slave_server)
    //         {
    //             if (isset($slave_users[$key]) && isset($slave_passwords[$key]) && isset($slave_databases[$key]))
    //             {
    //                 $slaves[] = array('server' => $slave_server, 'user' => $slave_users[$key], 'password' => $slave_passwords[$key], 'database' => $slave_databases[$key]);
    //             }
    //         }
    //         $servers[] = $slaves[array_rand($slaves)];
    //     }
    //     Yaf_Registry::set('database', $servers);
    //     if (isset($database->mysql_cache_enable) && $database->mysql_cache_enable && !defined('MYSQL_CACHE_ENABLE'))
    //     {
    //         define('MYSQL_CACHE_ENABLE', true);
    //     }
    //     if (isset($database->mysql_log_error) && $database->mysql_log_error && !defined('MYSQL_LOG_ERROR'))
    //     {
    //         define('MYSQL_LOG_ERROR', true);
    //     }
    // }

    public function _initView(Yaf_Dispatcher $dispatcher) {
        //命令行下基本不需要使用smarty
        if (REQUEST_METHOD != 'CLI')
        {
            // 关闭yaf自动渲染
            Yaf_Dispatcher::getInstance()->autoRender(FALSE);
            $smarty = new Smarty_Adapter(null, $this->config->smarty);
            $smarty->registerFunction('function', 'truncate', array('Tools', 'truncate'));
            $dispatcher->setView($smarty);
        }
    }

    public function _initMongo(Yaf_Dispatcher $dispatcher) {
        // mongo server 初始化
        $servers = array();
        $database = $this->config->mongodb;
        $servers['master'] = $database->master->toArray(); // master
        $slaves = $database->slaves; // slaves

        if (!empty($slaves))
        {
            $slave_servers	 = explode('|', $slaves->servers);
            $slave_ports	 = explode('|', $slaves->ports);
            $slave_users	 = explode('|', $slaves->users);
            $slave_passwords = explode('|', $slaves->passwords);
            $slave_databases = explode('|', $slaves->databases);
            $slaves = array();

            foreach ($slave_servers as $key => $slave_server)
            {
                if (
                    isset($slave_ports[$key]) &&
                    isset($slave_users[$key]) && 
                    isset($slave_passwords[$key]) && 
                    isset($slave_databases[$key])
				){
                    $slaves[] = array(
                        'server' => $slave_server,
                        'port' => $slave_ports[$key],
                        'database' => $slave_databases[$key],
                        'user' => $slave_users[$key],
                        'password' => $slave_passwords[$key],
                        );
                }
            }
            $servers['slaves'] = $slaves[array_rand($slaves)];
        }
        Yaf_Registry::set('mongodb', $servers);
    }

    /**
     * 注册系统错误码 系统常量 composer自动加载类
     * @Author    422909231@qq.com
     * @DateTime  2017-04-13
     * @return
     */
    public function _initDefine(){
        Yaf_Loader::import(APPLICATION_PATH . '/library/ErrCode.php');
        Yaf_Loader::import(APPLICATION_PATH . '/library/SysDefine.php');
        Yaf_Loader::import(APPLICATION_PATH . '/vendor/autoload.php');
    }

}
