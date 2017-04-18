<?php
class Dao_RewardModel extends Db_Mongodb {

    const PINGPP_API_KEY = 'sk_test_rz1efT880S0SX1WXXDCC84G4';
    const PINGPP_APP_ID = 'app_58izP0Hm1eTO9WHC';

    //打赏状态
    const REWARD_STATUS_CREATE  = 'create';  //已创建
    const REWARD_STATUS_SUCCESS = 'success'; //成功
    const REWARD_STATUS_FAIL    = 'fail';    //失败
    const REWARD_STATUS_CLOSE   = 'close';   //关闭
    
    protected $table = 'reward';

    protected $fields = [
        'orderno' => '',                  //订单号
        'channel' => '',                  //支付渠道
        'articleid' => '',                //文章id
        'authorid' => '',                 //作者id
        'rewarderid' => '',               //打赏人id
        'amount' => 0,                   //打赏金额 单位分
        'clientip' => '',                 //发起打赏客户端ip
        'subject' => '',                  //标题
        'body' => '',                     //描述
        'status' => 0,                   //打赏单状态
        'notifydata' => '',               //异步通知数据
        'createtime' => 0,               //创建时间
        'notifytime' => 0,               //异步通知时间
        'closetime' => 0,                //关闭时间
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
}