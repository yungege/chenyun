<?php
/**
 * 错误码
 */

define('SUCCESS',0);

//SSO登录错误码1~49
define('SSO_SOURCE_EMPTY',1);                   //SSO_SOURCE为空
define('SSO_SOURCE_INVALID',2);                 //SSO_SOURCE不正确
define('WEIXIN_CODE_EMPTY',3);                  //微信code为空
define('WEIXIN_CODE_INVALID',4);                //微信code不正确
define('SSO_ID_EMPTY',5);                       //SSO_ID为空
define('SSO_ID_INVALID',6);                     //SSO_ID不正确
define('REQUEST_PARAMS_ERROR',7);               //请求参数错误
define('PLATFORM_SOURCE_EMPTY',8);              //请求参数错误
define('WEIXBO_CODE_EMPTY',9);                  //微信code为空
define('WEIXBO_CODE_INVALID',10);               //微信code不正确
define('QQ_CODE_EMPTY',11);                     //微信code为空
define('QQ_CODE_INVALID',12);                   //微信code不正确
define('MATCHING_SECOND',13);                   //该信息已经被匹配过    
define('MATCHING_ACCOUNT_DONE',15);             //该账号已经匹配过用户信息
define('PHONENUM_HAS_EXIST',16);                //该手机号已经被注册
define('PHONENUM_NO_EXIST',17);                 //该手机号未被注册
define('MATCHING_FAULT',18);                    //匹配失败


// public50~99
define('PUBLIC_NOT_FOUND',50);

// 栏目错误码100~199
define('COLUMN_NAME_EMPTY',100);        //栏目名空
define('COLUMN_CREATER_EMPTY',101);     //栏目创建者空
define('COLUMN_NAME_EXSIT',102);        //栏目名称已存在
define('COLUMN_ADD_FAILED',103);        //添加栏目错误
define('COLUMN_NO_EXSIT',104);          //栏目不存在
define('COLUMN_MODIFY_FAILED',105);     //栏目修改错误
define('COLUMN_DELETE_FAILED',106);     //删除栏目错误

// 文章信息200~399
define('ARTICLE_TITLE_EMPTY',200);              //文章标题空
define('ARTICLE_ADD_FAILED',201);               //添加文章错误
define('ARTICLE_MODIFY_FAILED',202);            //修改文章错误
define('ARTICLE_UNKONWN_CONTENT_TYPE',203);     //内容类型不存在
define('ARTICLE_UNKONWN_MODIFY_TYPE',204);      //修改类型不明
define('ARTICLE_UNKONWN_OPERATION_TYPE',205);   //操作类型不存在
define('ARTICLE_NO_EXSIT',206);                 //文章不存在
define('ARTICLE_MERGEORIGIN_FAILED',207);       //组合原文失败
define('ARTICLE_MODIFYZONE_FAILED',208);        //移动区域失败
define('ARTICLE_MODIFYLABLE_FAILED',209);       //修改标签失败
define('ARTICLE_MODIFYREMARK_FAILED',210);      //修改备注失败
define('ARTICLE_MODIFYTYPE_FAILED',211);        //修改文章类型失败
define('ARTICLE_MODIFYTOP_FAILED',212);         //标记时效失败
define('ARTICLE_MODIFYPRE_FAILED',213);         //节目预定失败
define('ARTICLE_MODIFYPRIVATE_FAILED',214);     //屏蔽文章失败
define('ARTICLE_ADDFAVOR_FAILED',215);          //添加收藏失败
define('ARTICLE_ID_EMPTY',216);                 //文章id为空

// 用户信息 400~449
define('USER_NAME_EMPTY',400);      //用户名空
define('USER_PWD_EMPTY',401);       //密码空
define('USER_ADD_FAILED',402);      //添加用户错误
define('USER_USER_NON_EXSIT',403);  //用户不存在
define('USER_GET_FAILED',404);      //获取用户信息错误
define('USER_UA_PW_ERROR',405);     //用户名或密码错误
define('USER_DISABLE_FAILED',406);  //禁用用户失败
define('USER_ENABLE_FAILED',407);   //启用用户失败
define('USER_MODIFY_FAILED',408);   //修改用户失败
define('USER_NAME_EXSIT',409);      //用户名已存在
define('USER_NEED_LOGIN',410);      //需要登录
define('USER_PLATFORM_EMPTY',411);  //平台来源为空
define('USER_NAME_SENSITIVE',412);  //用户ID包含敏感词
define('USER_EXCEED_MODIFY_COUNT',413);  //用户ID本月已经修改了两次
define('USER_HAS_EXIST',414);            //用户已经注册
define('USER_FORBID_MODIFY',415);        //禁止修改用户信息
define('USER_EXIST_PHONE',416);          //用户手机号已经存在


// 素材信息 600~649
define('MATERIAL_UNKONWN_TYPE',600);            //素材类型不存在
define('MATERIAL_ADD_FAILED',601);              //添加素材错误
define('MATERIAL_MODIFY_FAILED',602);           //修改素材错误
define('MATERIAL_DELETE_FAILED',603);           //删除素材错误
define('GROUP_SAME_NAME',604);                  //存在同名组
define('GROUP_NON_EXIST',605);                  //组不存在
define('GROUP_MODIFY_FAILED',606);              //修改组失败
define('GROUP_DEFAULT_MODIFY',607);             //默认组不能修改
// define('MATERIAL_MODIFY_FAILED',608);           //修改素材错误
define('MATERIAL_MOVEGROUP_FAILED',609);        //素材移动组失败
define('GROUP_DEFAULT_DELETE',610);             //默认组删除失败
define('GROUP_DELETE_FAILED',611);              //删除组错误
define('GROUP_ADD_FAILED',612);                 //添加组失败



// up错误信息 650~699
define('UP_ERROR_IDNEED',650);                  //需要articleid或commentid
define('UP_OPTION_FAILED',651);                 //点赞操作失败
define('UP_ERROR_IDNEED_SPORT',652);            //运动圈点赞
define('UP_CANCEL_ERROR_IDNEED',653);     //取消点赞

// 文件夹 700 ~ 749
define('FOLDER_ADD_FAILED',700);                //文件夹添加失败
define('FOLDER_MODIFY_FAILED',701);             //文件夹修改失败
define('FOLDER_NOT_EXSIT',702);                 //文件夹不存在
define('FOLDER_MOVE_FAILED',703);               //移动文章失败
define('FOLDER_DELETE_FAILED',704);             //删除文件夹失败
// 评论 750 ~ 799
define('COMMENT_AIDCID_EMPTY',750);             //文章和评论id都为空
define('COMMENT_CONTENT_EMPTY',751);            //评论内容为空
define('COMMENT_ADD_FAILED',752);               //评论添加失败
define('COMMENT_DELETE_FAILED',753);            //删除评论失败
define('COMMENT_ID_NULL',754);                  //评论id为空

// others 1000
define('HAVE_NO_AUTH',1000);         //没权限
define('NEED_LOGIN',1001);           //请登录
define('DATABASE_ERROR',1002);       //数据库错误
define('DATASOURCE_ERROR',1003);     //数据源错误
define('NOT_ALLOWD_REQUEST_TYPE',1004); //请求方法错误

// 第三方puligin 751 ~ 799
define('QINIU_UPLOAD_RESOURCE_FAILED',751);             //上传资源失败

// 定时资源 800 ~
define('CRON_OPEN_FAILED',800);             //打开素材资源数据库失败

// 锻炼 900 ~
define('TRAINING_DATA_EMPTY',900);              //没有你想获取的锻炼数据
define('TRAINING_DATA_FAULSE',901);             //锻炼数据提交失败
define('TRAINING_REMIND_ADD_FAULSE',902);       //锻炼提醒时间配置失败
define('HOMEWORK_HAS_BEEN',903);                //班级当前有已有作业存在
define('FEEDBACK_POST_FAULT',904);              //反馈信息提交失败
define('TRAINING_DATA_HAS_DONE',905);           //锻炼已经提交过
define('TRAINING_PUBLISH_TIME_FAULT',906);      //锻炼截止时间有误
define('TRAINING_TASK_DELAY_FAULT',907);        //延期失败
define('FEEDBACK_DATA_EMPTY',908);              //当前没有反馈意见
define('DATA_EMPTY',909);                       //数据为空


// 推送
define('PUSH_FAULT',1101);                      //推送失败
define('PUSH_HASDONE',1102);                    //推送的班级本周已经推送过2次，不能再次推送！
define('PUSH_DATA_EMPTY',1103);                 //没有推送消息！
define('VERSION_UPDATE_EMPTY',1104);            //无版本升级信息！

function setError($errorCode, $errorMsg=''){
    switch($errorCode){
        case SUCCESS:
            $msg = 'success';
            break;
        //sso 相关错误
        case SSO_SOURCE_EMPTY:
            $msg = 'SSO_SOURCE为空';
            break;
        case SSO_SOURCE_INVALID:
            $msg = 'SSO_SOURCE不正确';
            break;
        case WEIXIN_CODE_EMPTY:
            $msg = '微信code为空';
            break;
        case WEIXIN_CODE_INVALID:
            $msg = '微信code不正确';
            break;
        case SSO_ID_EMPTY:
            $msg = 'SSO ID为空';
            break;
        case SSO_ID_INVALID:
            $msg = 'SSO ID不正确';
            break;
        case REQUEST_PARAMS_ERROR:
            $msg = '请求参数错误';
            break;
        case USER_PLATFORM_EMPTY:
            $msg = '平台来源为空';
            break;
        case MATCHING_SECOND:
            $msg = '您输入的信息已经被匹配过,请从新确认您输入的信息！';
            break;
        case MATCHING_FAULT:
            $msg = '匹配失败,请从新尝试';
            break;
        case MATCHING_ACCOUNT_DONE:
            $msg = '该账号已经匹配过信息';
            break;
        case PHONENUM_HAS_EXIST:
            $msg = '该手机号已经被注册!';
            $value['data']['valid'] = 0;
            break;
        case PHONENUM_NO_EXIST:
            $msg = '该手机号未被注册过!';
            break;

        // 栏目错误
        case COLUMN_NAME_EMPTY:
            $msg = '栏目名不能为空';
            break;
        case COLUMN_CREATER_EMPTY:
            $msg = '栏目创建者不能为空';
            break;
        case COLUMN_NAME_EXSIT:
            $msg = '栏目名称已存在';
            break;
        case COLUMN_ADD_FAILED:
            $msg = '添加栏目失败';
            break;
        case COLUMN_NO_EXSIT:
            $msg = '栏目不存在';
            break;
        case COLUMN_MODIFY_FAILED:
            $msg = '修改栏目失败';
            break;
        case COLUMN_DELETE_FAILED:
            $msg = '删除栏目失败';
            break;

        // 文章相关
        case ARTICLE_TITLE_EMPTY:
            $msg = '文章标题不能为空';
            break;
        case ARTICLE_ADD_FAILED:
            $msg = '添加文章失败';
            break;
        case ARTICLE_MODIFY_FAILED:
            $msg = '修改文章失败';
            break;
        case ARTICLE_UNKONWN_CONTENT_TYPE:
            $msg = '文章内容类型不存在';
            break;
        case ARTICLE_UNKONWN_MODIFY_TYPE:
            $msg = '文章修改类型不存在';
            break;
        case ARTICLE_UNKONWN_OPERATION_TYPE:
            $msg = '文章操作类型不存在';
            break;
        case ARTICLE_NO_EXSIT:
            $msg = '文章不存在';
            break;
        case ARTICLE_MERGEORIGIN_FAILED:
            $msg = '生成原文失败';
            break;
        case ARTICLE_MODIFYZONE_FAILED:
            $msg = '移动区域失败';
            break;
        case ARTICLE_MODIFYLABLE_FAILED:
            $msg = '修改标签失败';
            break;
        case ARTICLE_MODIFYREMARK_FAILED:
            $msg = '修改备注失败';
            break;
        case ARTICLE_MODIFYTYPE_FAILED:
            $msg = '修改文章类型失败';
            break;
        case ARTICLE_MODIFYTOP_FAILED:
            $msg = '标记时效失败';
            break;
        case ARTICLE_MODIFYPRE_FAILED:
            $msg = '节目预定失败';
            break;
        case ARTICLE_MODIFYPRIVATE_FAILED:
            $msg = '屏蔽文章失败';
            break;
        case ARTICLE_ADDFAVOR_FAILED:
            $msg = '添加收藏失败';
            break;
        case ARTICLE_ID_EMPTY:
	        $msg = '文章id为空';
	        break;

        //用户信息
        case USER_NAME_EMPTY:
            $msg = '用户名空';
            break;
        case USER_PWD_EMPTY:
            $msg = '密码空';
            break;
        case USER_ADD_FAILED:
            $msg = '添加用户失败';
            break;
        case USER_USER_NON_EXSIT:
            $msg = '用户不存在';
            break;
        case USER_GET_FAILED:
            $msg = '获取用户信息失败';
            break;
        case USER_UA_PW_ERROR:
            $msg = '用户名或密码错误';
            break;
        case USER_DISABLE_FAILED:
            $msg = '禁用用户失败';
            break;
        case USER_ENABLE_FAILED:
            $msg = '启用用户失败';
            break;
		case USER_MODIFY_FAILED:
            $msg = '修改用户失败';
            break;
		case USER_NAME_EXSIT:
			$msg = '用户名已存在';
			break;
        case USER_NEED_LOGIN:
            $msg = '未登录';
            break;
        case USER_NAME_SENSITIVE:
            $msg = '发布内容包含敏感词';
            break;
        case USER_EXCEED_MODIFY_COUNT:
            $msg = '用户ID本月已经修改了两次';
            break;
        case USER_HAS_EXIST:
            $msg = '该账户已经注册过';
            break;
        case USER_FORBID_MODIFY:
            $msg = '禁止修改用户信息';
            break;
        case USER_EXIST_PHONE:
            $msg = '用户手机号已经存在';
            break;

        //素材信息
        case MATERIAL_UNKONWN_TYPE:
            $msg = '素材类型不存在';
            break;
        case MATERIAL_ADD_FAILED:
            $msg = '添加素材失败';
            break;
        case MATERIAL_MODIFY_FAILED:
            $msg = '修改素材失败';
            break;
        case MATERIAL_DELETE_FAILED:
            $msg = '删除素材失败';
            break;
        case GROUP_SAME_NAME:
            $msg = '存在同名组';
            break;
        case GROUP_NON_EXIST:
            $msg = '组不存在';
            break;
        case GROUP_MODIFY_FAILED:
            $msg = '修改组失败';
            break;
        case GROUP_DEFAULT_MODIFY:
            $msg = '默认组不能修改';
            break;
        case MATERIAL_MODIFY_FAILED:
            $msg = '修改素材失败';
            break;
        case MATERIAL_MOVEGROUP_FAILED:
            $msg = '移动组失败';
            break;
        case GROUP_DEFAULT_DELETE:
            $msg = '默认组不能删除';
            break;
        case GROUP_DELETE_FAILED:
            $msg = '删除组失败';
            break;
        case GROUP_ADD_FAILED:
            $msg = '添加组失败';
			break;

        // 点赞错误
        case UP_ERROR_IDNEED:
            $msg = '文章id和评论id不能同时为空';
            break;
        case UP_OPTION_FAILED:
            $msg = '赞操作失败';
            break;
        case UP_ERROR_IDNEED_SPORT:
            $msg = '分享动态id不能为空';
            break;
        case UP_CANCEL_ERROR_IDNEED:
            $msg = '取消点赞失败';
            break;

		//文件夹操作
		case FOLDER_ADD_FAILED:
			$msg = '添加文件夹失败';
			break;
		case FOLDER_MODIFY_FAILED:
			$msg = '修改文件夹失败';
			break;
		case FOLDER_NOT_EXIST:
			$msg = '文件夹不存在';
			break;
		case FOLDER_MOVE_FAILED:
			$msg = '移动文章失败';
			break;
		case FOLDER_DELETE_FAILED:
			$msg = '删除文件夹失败';
			break;

        // 评论错误
        case COMMENT_AIDCID_EMPTY:
            $msg = '文章和评论ID不能同时为空';
            break;
        case COMMENT_CONTENT_EMPTY:
            $msg = '评论内容为空';
            break;
        case COMMENT_ADD_FAILED:
            $msg = '评论添加失败';
            break;
        case COMMENT_DELETE_FAILED:
            $msg = '删除评论失败';
            break;
        case COMMENT_ID_NULL:
            $msg = '评论id为空';
            break;

        //其他
        case HAVE_NO_AUTH:
            $msg = '没有操作权限';
            break;
        case NEED_LOGIN:
            $msg = '请登录';
            break;
        case DATABASE_ERROR:
            $msg = '数据库错误';
            break;
        case DATASOURCE_ERROR:
            $msg = '数据源错误';
            break;
        //锻炼
        case TRAINING_DATA_EMPTY:
            $msg = '亲，暂时没有你想获取的数据！';
            break;
        case TRAINING_DATA_FAULSE:
            $msg = '锻炼数据提交失败';
            break;
        case TRAINING_REMIND_ADD_FAULSE:
            $msg = '锻炼提醒时间配置失败';
            break;
        case HOMEWORK_HAS_BEEN:
            $msg = '您所发布的班级当前时间均已有作业存在，故不能再发布作业!';
            break;
        case FEEDBACK_POST_FAULT:
            $msg = '反馈数据提交失败';
            break;
        case FEEDBACK_DATA_EMPTY:
            $msg = '当前没有反馈意见';
            break;
        case TRAINING_DATA_HAS_DONE:
            $msg = '该锻炼数据已经提交过';
            break;
        case TRAINING_PUBLISH_TIME_FAULT:
            $msg = '锻炼截止时间发布有误';
            break;
        case DATA_EMPTY:
            $msg = '数据为空';
            break;
        case TRAINING_TASK_DELAY_FAULT:
            $msg = '延期失败';
            break;
        case PUSH_FAULT:
            $msg = '推送失败';
            break;
        case PUSH_HASDONE:
            $msg = '推送的班级本周已经推送过2次，不能再次推送！';
            break;
        case PUSH_DATA_EMPTY:
            $msg = '您目前没有通知消息!';
            break;
        case VERSION_UPDATE_EMPTY:
            $msg = '无版本升级信息';
            break;
		default :
			$msg = '未知错误';
			break;

        //定时资源
        case CRON_OPEN_FAILED:
            $msg = '打开素材资源数据库失败';
            break;
    }

    if(empty($msg))
        $msg = $errorMsg;

    return $msg;
    // $value['errCode'] = $errorCode;
    // $value['errMessage'] = $msg;
	// send_http_status($httpCode);
}