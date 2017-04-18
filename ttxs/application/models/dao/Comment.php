<?php
class Dao_CommentModel extends Db_Mongodb {

    const COMMENT_TYPE_ARTICLE = 1; //对文章的评论
    const COMMENT_TYPE_COMMENT = 2; //对评论的评论
    
    protected $table = 'comment';

    protected $fields = [
        'articleid' => '',                    //文章id
        'articletitle' => '',                 //文章title
        'articlecoverimg' => '',              //文章封面
        'destcommentid' => '',                //目标评论id
        'commenttype' => 0,                  //评论类型
        'createtime' => 0,                   //创建时间
        'commenter' => '',                    //评论人id
        'commentee' => '',                    //被评论人id,用于@搜索
        'commenttext' => '',                  //评论内容-纯文本
        'imageinfo' => [],                    //图片信息
        'commentup' => 0,                    //评论点赞数
        'commentdown' => 0,                  //评论差评数
        'issensitive' => 0,                  //是否有敏感词
        'isdeleted' =>0 ,                    //是否删除
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