<?php

class Cache_CacheBaseRedis{
    public $hander;
    private $_options;

    public function __construct() {
        if ( !extension_loaded('redis') ) {
            return false;
        }
        $conf = Yaf_Registry::get('config');
        $params = $conf->cache->redis->master;
        $this->_options = array(
            'host'          => $params['host'] ? : '127.0.0.1',
            'port'          => $params['port'] ? : '6379',
            'timeout'       => $params['timeout'] ? : 3,
            'persistent'    => $params['persistent'] ? : false,
            'auth'          => $params['auth'] ? : ''
        );
        return $this->_connect();
    }
    
    private function _connect() {
        $redis = new Redis();
        $checkAuth = true;
        try {
            $contentRes = $redis->connect(
                $this->_options['host'],
                $this->_options['port'],
                $this->_options['timeout']
            );
            if($this->_options['auth'] != ''){
                $checkAuth = $redis->auth($this->_options['auth']);    
            }
            if($contentRes == true && $checkAuth == true){
                $this->hander = $redis;
            }
        }catch(Exception $e) {
            Log::writeLog('redisError', date('Y-m-d H:i:s'), '连接出错');
        }
    }
}
