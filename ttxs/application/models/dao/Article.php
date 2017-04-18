<?php
class Dao_ArticleModel extends Db_Mongodb {
    
    const ARTICLE_SOURCE_UGC = 'ugc';
    const ARTICLE_SOURCE_PGC = 'pgc';
    const ARTICLE_SOURCE_OFFICIAL = 'official';
    const ARTICLE_SOURCE_HISTORY = 'history';
    const ARTICLE_SOURCE_MATERIAL = 'material';

    const ARTICLE_UNDELETED = 0;             //文章未删除
    const ARTICLE_DELETED = 1;               //文章已删除

    const ARTICLE_ZONE_UNAUDIT = 0;          //未审核区
    const ARTICLE_ZONE_GABBAGE = 1;          //回收站区
    const ARTICLE_ZONE_SAFE = 2;             //安全区
    const ARTICLE_ZONE_EXCELLENT = 3;        //初审精华区
    const ARTICLE_ZONE_PUBLISH_PENDING = 4;  //待发布区
    const ARTICLE_ZONE_PUBLISHED = 5;        //已发布区

    const ARTICLE_CATEGORY_IMAGE = 'image';
    const ARTICLE_CATEGORY_VIDEO = 'video';
    const ARTICLE_CATEGORY_AUDIO = 'audio';

    protected $table = 'article';

    protected $fields = [
        'groupid' => '',		//素材组信息
        'title' => '',			//标题
        'titlelength' => 0,		//标题长度
        'summary' => '',		//摘要
        'source' => '',			//文章来源:UGC?PGC
        'type' => '',			//类型:娱乐八卦?生活八卦
        'category' => ,
        'zoneinfo' => 0,		//区域信息:安全区?未审区?精华?待发布区?发布区
        'columninfo' => [],		//栏目信息
        'authorid' => '',		//文章作者id
        'topic' => [],			//所属话题信息
        'linkurl' => '',
        'videoinfo' => [],		//视频内容信息
        'imageinfo' => [],		//图片信息
        'audioinfo' => [],		//音频信息
        'createtime' => 0,		//创建时间
        'publishtime' => 0,		//发布时间
        'toptime' => 0,			//置顶时间
        'isdeleted' => 0,		//是否被删除
        'aging' => 0,			//标记时效
        'reservation' => 0,		//节目预定
        'coverimginfo' => [],	//封面图片信息
        'iscompleted' => 0,
        'sampleupperlimit' => 0,     //抽样样本上限
        'adress' => [],               //发布文章的地理位置信息
        'titlehtml' => '',            //标题html
        'fullshowhtml' => '',         //文章最终版html
        'contenteditorhtml' => '',    //ueditor文章页面html
        'fulloriginhtml' => '',       //原文html
        'contenttext' => '',          //文章文字内容,供搜索使用
        'contenthtml' => '',          //供后台管理系统显示html
        'contentueditor' => '',
	    'statisticsinfo' => [],       //统计信息
        'attachments' => [],          //附件信息
        'hotcomment' => [],           //热门评论信息
        'transmited' => '',           //转发信息
        'updetail' => '',             //点赞信息
        'readdetail' => '',           //阅读量信息
        'sampleinfo' => '',
        'reward' => [],               //打赏信息
        'label' => [],                //标签信息
        'remark' => [],               //备注信息
        'favor' => [],                //收藏信息
        'privatestatus' => [],        //管理员私有过滤
        'revise' => [],
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