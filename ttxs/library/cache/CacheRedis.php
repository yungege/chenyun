<?php

class Cache_CacheRedis{
    private static $_redis;
    private static $_instance = null;

    private function __clone(){}

    private  function __construct(){
        self::$_redis = (new Cache_CacheBaseRedis())->hander;
    }

    public static function getInstance(){
        if(null == self::$_instance){
            self::$_instance = new self();    
        }
        return self::$_instance;
    }

    public function get($name) {
        $value = self::$_redis->get($name);
        $jsonData  = json_decode( $value, true );
        return ($jsonData === NULL) ? $value : $jsonData;
    }

    public function set($name, $value, $expire = null) {
        $value  =  (is_object($value) || is_array($value)) ? json_encode($value) : $value; 
        if(is_int($expire) && $expire) {
            self::$_redis->setex($name, $expire, $value);
        }else{
            self::$_redis->set($name, $value);
        }
        return;
    }

    public function rm($name) {
        return self::$_redis->delete($name);
    }

    public function setIncr($key){
        if(self::$_redis->exists($key)){
            if(is_numeric($this->get($key))){
                return self::$_redis->incr($key);
            }
        }
        return false;
    }

    public function rpush($list, $value){
        return self::$_redis->rpush($list, $value);
    }

    public function lrem($list, $value){
        return self::$_redis->lrem($list, $value);
    }

    public function getList($list){
        return self::$_redis->lrange($list, 0, -1);
    }

}
