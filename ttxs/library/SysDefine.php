<?php
/**
 * Created by PhpStorm.
 * User: moo
 * Date: 15/12/16
 * Time: 上午10:27
 */
// pulic
define('GROUP_TYPE_DEFUALT','default');
define('TIME_MULTIPLE',1000);
define('DEFAULT_SUMMARY_LONG',120);
define('DEFAULT_INTRODUCTION_LONG',250);
define('HTTP_SERVER_ERROR_CODE',500);
define('HTTP_SUCCESS_CODE',200);
define('SEARCH_SIZE_FRAGMENT',0);

define('CLIENT_SOURCE_H5','h5');
define('CLIENT_SOURCE_ANDORID','andorid');
define('CLIENT_SOURCE_IOS','ios');
define('CLIENT_SOURCE_WP','wp');
//article

//source
define('ARTICLE_SOURCE_UGC','ugc');
define('ARTICLE_SOURCE_PGC','pgc');
define('ARTICLE_SOURCE_OFFICIAL','official');
define('ARTICLE_SOURCE_HISTORY','history');
define('ARTICLE_SOURCE_MATERIAL','material');

//***特殊处理***
define('HISTORY_COLUMN_ID','56af1dc0fe6d2371118b46d6');
define('HISTORY_USER_ID','57317efcfe6d23ff0e8b4756');

//folder type
define('FOLDER_TYPE_LIFE',1);
define('FOLDER_TYPE_ENTERTAINMENT',2);
// open type
define('FOLDER_OPEN_ONESELF',1);
define('FOLDER_OPEN_PUBLIC',2);

// operation
define('ARTICLE_GET_CONTENT',1);
define('ARTICLE_GET_CHECK',2);
define('ARTICLE_GET_TOPIC',3);
define('ARTICLE_GET_BYID',4);
define('ARTICLE_GET_PRIVATE',5);
define('ARTICLE_GET_FOLDER',6);
define('ARTICLE_GET_RESERVATION',7);
// sortby
define('SORTBY_CREATETIME',0);
define('SORTBY_IMG',1);
define('SORTBY_WILSON',2);
define('SORTBY_SAMPLE',3);
define('SORTBY_UP',4);
define('SORTBY_COMMENT',5);
define('SORTBY_REVOR',6);
define('SORTBY_SCROE',7);
define('SORTBY_TEXT',8);
// comment type
define('COMMENT_TYPE_NORMAL',1);
define('COMMENT_TYPE_DELETE',2);

// zoneinfo
define('ZONE_NONREVIEW',0);     //未审核
define('ZONE_RECOVERY',1);      //回收站
define('ZONE_SAFE',2);          //安全区
define('ZONE_ESSENCE',3);       //初审精华
define('ZONE_READY',4);         //待发布区
define('ZONE_RELEASED',5);      //已发布区
define('ZONE_SELECT',6);	//精华文章

// modify type
define('MODIFYCONTENT',1);  //修改文章内容
define('MODIFYZONE',2);     //修改文章区域
define('MODIFYLABEL',3);    //修改文章标签
define('MODIFYREMARK',4);   //修改文章备注
define('MODIFYSOURCE',5);   //生活娱乐中修改文章，保存原始文章
define('MODIFYTYPE',6);	    //修改type
define('MODIFYTOPTIME',7);  //标记时效
define('MODIFYPRE',8);	    //节目预定
define('MODIFYBLOCK',9);    //私有屏蔽文章
define('MODIFYZONEBAT',10); //批量加精华
define('MODIFYTOP',11);     //文章置顶
define('OFFSHELF',12);     //文章下架

// modify cron
define('MODIFYCRONZONE',1);  //修改定时区域
define('MODIFYCDELRON',2);   //取消定时

//评论相关
//获取评论类型
define('COMMENT_NORMAL',1);
define('COMMENT_HOT',2);
define('COMMENT_AUTHOR',3);
define('COMMENT_DIALOG',4);

//微信授权信息
define ('WECHAT_APPID', 'wx632de4b3cb82a7c1');
define ('WECHAT_APPSECRET', '6827a9211fff445829c779f3c2a9ff07');

// material
// default value
define('MATERIAL_DEFAULT_TITLE','default');
define('MATERIAL_DEFAULT_IMG','http://7xpfjj.com2.z0.glb.qiniucdn.com/96d6f2e7e1f705ab5e59c84a6dc009b2.JPG');
// materialtype
define('MATERIAL_ARTICLE',0);
define('MATERIAL_PIC',1);
define('MATERIAL_AUDIO',2);
define('MATERIAL_VIDEO',3);
// operation type
define('OPERATION_GROUP',1);
define('OPERATION_MATERIAL',2);

// qiniu
define ('ACCESS_KEY', 'YiqWCcEbG0gULpD1RlWrsY8XKHPRmtxev4DWvY9X');    // mIICNUq71V8G3x4EcXlWvKeoerMPzr-N-kM7nBcl
define ('SECRET_KEY', 'R1vbtZpDPszSKIwYySAwZjB5VJea183f60Lzj3Bd');    // zj4D6pOADBZ5vp4pwgC00CXPRcgeDl3w9tam2wug

// 用户相关
// 角色
define('USER_ADMIN','admin');
define('USER_UGC','ugc');

// 性别
define('USER_GENDER_UNKNOWN',0);
define('USER_GENDER_MALE',1);
define('USER_GENDER_FEMALE',2);

// 类型
define('USER_TYPE_UGC',0);
define('USER_TYPE_PGC',1);
define('USER_TYPE_MASTER',2);
define('USER_TYPE_EXE',3);
define('USER_TYPE_EDITOR',4);
define('USER_TYPE_INTERN',5);


// author define
// 审查系统 1~100
define('AUTH_CHECKSYS_VIEW_ARTICLE',1);             //检索文章
define('AUTH_CHECKSYS_MODIFY_ARTICLE',2);           //编辑文章
define('AUTH_CHECKSYS_ADD_RMARK',3);                //添加备注
define('AUTH_CHECKSYS_PASS_ARTICLE',4);             //通过/不通过文章
define('AUTH_CHECKSYS_KEY_BLACKLIST',5);            //导入、编辑关键字黑名单
define('AUTH_CHECKSYS_USER_BLACKLIST',6);           //添加编辑IP、设备MAC、用户黑名单
define('AUTH_CHECKSYS_RECOVERY_ARTICLE',7);         //从垃圾箱通过文章（需编辑）

// 娱乐文章列表管理 101~200
define('AUTH_FUN_VIEW_ARTICLE',101);            //检索文章
define('AUTH_FUN_MODIFY_ARTICLE',102);          //编辑文章
define('AUTH_FUN_ADD_REMARK',103);               //添加备注
define('AUTH_FUN_ADD_LABEL',104);               //添加标签
define('AUTH_FUN_MVTO_PRE',105);                //添加文章至待发布
define('AUTH_FUN_MVTO_SPICIAL',106);            //移动文章至特殊分区
define('AUTH_FUN_VIEW_ORIGIN',107);             //查看原文内容
define('AUTH_FUN_BLOCK_ARTICLE',108);           //删除、屏蔽文章
define('AUTH_FUN_PRIVATE_MSG',109);             //私信发布人
define('AUTH_FUN_UPDATE_LIST',110);             //更新发布文章列表
define('AUTH_FUN_MOIDFY_LIST',111);             //编辑文章列表
define('AUTH_FUN_VIEW_STATISTICS',112);         //查看统计数据

// 生活文章列表管理 201~300
define('AUTH_LIFE_VIEW_ARTICLE',201);            //检索文章
define('AUTH_LIFE_MODIFY_ARTICLE',202);          //编辑文章
define('AUTH_LIFE_ADD_REMARK',203);               //添加备注
define('AUTH_LIFE_ADD_LABEL',204);               //添加标签
define('AUTH_LIFE_MVTO_PRE',205);                //添加文章至待发布
define('AUTH_LIFE_MVTO_SPICIAL',206);            //移动文章至特殊分区
define('AUTH_LIFE_VIEW_ORIGIN',207);             //查看原文内容
define('AUTH_LIFE_BLOCK_ARTICLE',208);           //删除、屏蔽文章
define('AUTH_LIFE_PRIVATE_MSG',209);             //私信发布人
define('AUTH_LIFE_UPDATE_LIST',210);             //更新发布文章列表
define('AUTH_LIFE_MOIDFY_LIST',211);             //编辑文章列表
define('AUTH_LIFE_VIEW_STATISTICS',212);         //查看统计数据

// 官方栏目 301~400
define('AUTH_OFFICIAL_CREATE',301);             //创建栏目
define('AUTH_OFFICIAL_MODIFY',302);             //编辑栏目
define('AUTH_OFFICIAL_SET_POPBOX',303);         //设置栏目内文章首页发布、二级页面
define('AUTH_OFFICIAL_VIEW_MATERIAL',304);      //检索素材
define('AUTH_OFFICIAL_CREATE_MATERIAL',305);    //新建素材
define('AUTH_OFFICIAL_MODIFY_MATERIAL',306);    //编辑素材
define('AUTH_OFFICIAL_DEL_MATERIAL',307);       //删除素材
define('AUTH_OFFICIAL_UGC_TOP',308);            //栏目内话题ugc内容置顶
define('AUTH_OFFICIAL_DEL_UGC',309);            //栏目内话题删除ugc
define('AUTH_OFFICIAL_REPLAY',310);             //回复评论
define('AUTH_OFFICIAL_DEL_COMMENT',311);        //删除评论
define('AUTH_OFFICIAL_RELEASE_PUSH',312);       //发布推送
define('AUTH_OFFICIAL_VIEW_STATISTICS',313);    //查看统计数据

// 话题管理系统 401~500
define('AUTH_TOPIC_CREATE',401);            //新建话题
define('AUTH_TOPIC_MODIFY',402);            //编辑话题
define('AUTH_TOPIC_TOP',403);               //话题下文章置顶
define('AUTH_TOPIC_VIEW',404);              //查看话题文章
define('AUTH_TOPIC_BATADD',405);            //批量添加文章到话题
define('AUTH_TOPIC_RELEASE_HOT',406);       //发布更新热门话题榜
define('AUTH_TOPIC_VIEW_STATISTICS',407);   //查看统计数据


// 体质健康测试项目编号
/*身体形态*/
define('PHYSICALFITNESSTEST_HEIGHT',1);                      //身高测试
define('PHYSICALFITNESSTEST_WEIGHT',2);                      //体重测试
/*身体机能*/
define('PHYSICALFITNESSTEST_VITALCAPACITY',4);               //肺活量
/*耐力项目*/
define('PHYSICALFITNESSTEST_TENKRUN',11);                    //1000米跑(身体素质:0-耐力素质)
define('PHYSICALFITNESSTEST_EIGHTKRUN',10);                  //800米跑(身体素质:0-耐力素质)
define('PHYSICALFITNESSTEST_STEP',3);                        //台阶试验
define('PHYSICALFITNESSTEST_FOURKRUN',13);                   //400米跑
define('PHYSICALFITNESSTEST_FERETURNRUN',9);                 //50米×8往返跑
/*柔韧、力量项目*/
define('PHYSICALFITNESSTEST_CHIN',14);                       //引体向上(身体素质:1-上肢力量)
define('PHYSICALFITNESSTEST_SITUPS',12);                     //仰卧起坐(身体素质:2-腹肌耐力)
define('PHYSICALFITNESSTEST_THROWSOLIDBALL',15);             //掷实心球
define('PHYSICALFITNESSTEST_THROWSSANDBAGS',16);             //投沙包
define('PHYSICALFITNESSTEST_SITREACH',7);                    //坐位体前屈(身体素质:3-柔韧素质)
define('PHYSICALFITNESSTEST_GRIP',8);                        //握力
/*速度、灵巧项目*/
define('PHYSICALFITNESSTEST_FIFTYMRUN',5);                   //50米跑(身体素质:4-速度素质)
define('PHYSICALFITNESSTEST_TTRETURNRUN',17);                //25米*2往返跑
define('PHYSICALFITNESSTEST_STANDJUMP',6);                   //立定跳远(身体素质:5-下肢力量)
define('PHYSICALFITNESSTEST_ROPE',18);                       //跳绳
define('PHYSICALFITNESSTEST_BADRIBBLE',19);                  //篮球运球
define('PHYSICALFITNESSTEST_FTDRIBBLE',20);                  //足球运球
define('PHYSICALFITNESSTEST_VODRIBBLE',21);                  //排球垫球
define('PHYSICALFITNESSTEST_TMKICK',22);                     //30秒踢键子
define('PHYSICALFITNESSTEST_FTJUGGLING',23);                 //足球颠球