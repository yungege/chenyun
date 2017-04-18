<?php
class Dao_SessionModel extends Db_Mongodb {

    protected $table = 'session';

    protected $fields = [
        'userid' => '',                 //userid
        'username' => '',               //username
        'nickname' => '',               //用户名
        'type' => '',                   //类型
        'key' => '',                    //用于生成token
        'authority' => [],              //权限
        'ssoid' => '',                  //唯一标识
        'ssosource' => '',              //wx,qq,phone
        'lastoperationtime' => 0,       //最后操作时间
    ];

    protected function __construct(){
        parent::__construct();
    }

    /**
     * 获得实例
     * @param string $confkey
     * @return mongodb
     */
    public static function getInstance() {

        if(!self::$instance instanceof self){
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * 通过userid获取session信息
     * @param  string $userId [description]
     * @return array
     */
    public function getSessionInfoByUserid(string $userId){
        $where = ['userid' => $userId];
        return $this->query($where);
    }

    /**
     * 修改最后登录时间
     * @param  string $userId [description]
     * @param  int    $time   [description]
     * @return bool 成功：true 失败：false
     */
    public function updateLastLoginTimeByUserid(string $userId, int $time = 0){
        $time = $time ? : time();

        $where = [
            'userid' => $userId,
        ];

        $update = [
            'lastoperationtime' => $time,
        ];

        return $this->update($where, $update);
    }

    public function updateSessionByUserid(string $userId, array $set){
        $where = [
            'userid' => $userId,
        ];

        return $this->update($where, $set);
    }
}
