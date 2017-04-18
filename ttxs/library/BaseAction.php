<?php
/**
 * @declare 基类action
 */
class BaseAction extends Yaf_Action_Abstract{

    const RENDER_TYPE_PARAM_KEY = 'type';

    const RENDER_TYPE_TPL = 'tpl';
    const RENDER_TYPE_RESOURCE = 'resource';
    const RENDER_TYPE_INTERFACE = 'interface';
    const RENDER_TYPE_INTERFACE_NA = 'interfaceNa';
    const RENDER_TYPE_NA_JSONP = 'naJsonp';
    const RENDER_TYPE_SERVICE = 'service';
    const RENDER_TYPE_INTERFACE_ORI = 'interfaceOri';
    const RENDER_TYPE_JSONP = 'jsonp';
    const RENDER_TYPE_TEXT = 'text';

    const RENDER_TPL_TYPE_WML = 'wml';
    const RENDER_TPL_TYPE_COLOR = 'color';
    const RENDER_TPL_TYPE_TOUCH = 'touch';
    const RENDER_TPL_TYPE_WEBAPP = 'webapp';

    const TEMPLATE_PATH = VIEW_PATH;
    const FIRETPL_KEY = 'ttxs';

    const RENDER_INTERFACE_HEAD = 'Content-Type: application/json';
    const RENDER_SERVICE_HEAD_500 = 'http/1.1 500 ';
    const RENDER_TEXT_HEAD = 'Content-Type: text/plain';
    const RENDER_JSONP_HEAD = 'Content-Type: application/x-javascript';

    const BIG_FILE_SIZE = 10485760;

    protected $declareParams;
    protected $declarePageService;
    protected $declareHeader;
    protected $declareRender;
    protected $declareTplType;
    protected $declareRequestType = true;
    protected $allowRequestType = ['get','post','put','delete','options','head'];

    protected $req;
    protected $res;

    protected $_view;

    private $_smartyConf;

    private $_headerInfo;

    public function execute(){
        try{
            $this->__declare();

            $this->__filterRequestType();

            $this->__params();

            $this->__pageService(); 

        }catch(Exception $e){

        }

        $this->__header();

        $this->__render();

        $this->__headerAfter();

    }

    protected function __declare(){

    }

    protected function __filterRequestType(){
        if($this->declareRequestType){
            if(!in_array(strtolower(REQUEST_METHOD), $this->allowRequestType)){
                $res = [
                    'errCode' => NOT_ALLOWD_REQUEST_TYPE,
                    'errMessage' => 'Request method not allow.',
                    'data' => [],
                ];
                header(self::RENDER_INTERFACE_HEAD);
                exit(json_encode($res));
            }
        }
    }

	/**
     * 参数获取
     */
    protected function __params(){
        
        if($this->declareParams){
            //如果声明了文件上传
            if(isset($this->declareParams['file'])){
                $this->req['file'] = $_FILES;
            }

            //如果对path_string赋值，则传递至service层
            if(isset($this->declareParams['path_string'])) {
                $this->req['path_string'] = $this->declareParams['path_string'];
            }

            //如果声明了ori
            // if(isset($this->declareParams['ori'])){
                // $get = is_array($_GET)? $_GET: array();
                // $post = is_array($_POST)? $_POST: array();
                // $this->req['ori']['get'] = $get;
                // $this->req['ori']['post'] = $post;
                // $this->req['ori']['request_param'] = array_merge($get, $post);
            // }

            //如果声明了cookie
            if(isset($this->declareParams['cookie'])){
                $this->req['cookie'] = $_COOKIE;
            }

            $this->__getRequestParams();
        }
    }

    /**
     * 解析请求参数
     * 参数名不能相同
     * @return array
     */
    private function __getRequestParams(){
        switch(strtolower(REQUEST_METHOD)){
            case 'get':
                $this->req['get'] = $_GET;

            default:
                $req = [];
                parse_str(file_get_contents("php://input"), $req);

                $this->req[strtolower(REQUEST_METHOD)] = $req;

                if(!empty($_GET)){
                    $this->req[strtolower(REQUEST_METHOD)] = array_merge(
                        $this->req[strtolower(REQUEST_METHOD)], $_GET);
                }
        }
    }

    //执行逻辑
    protected function __pageService(){
        if ($this->declarePageService) {
            if(class_exists($this->declarePageService)){
                $pageServiceName = $this->declarePageService;
                $pageService = new $pageServiceName();
                $this->res = $pageService->execute($this->req);
            }
        }
    }

    //响应头
    protected function __header(){
        if($this->declareHeader){
            $this->_headerInfo = $this->res['data']['headerInfo'];
            unset($this->res['data']['headerInfo']);

            $headers = $this->_headerInfo;
            if(is_array($headers)){
                foreach($headers as $header){
                    if(preg_match('/\$\{contentLength\}/', $header)){
                        continue;
                    }
                    header($header);
                }
            }
            //wap依照tpl类型设置
            if(isset($this->declareTplType) && in_array($this->declareTplType,
                        array('wml','color','touch','webapp'))){
                if($this->declareTplType == 'wml'){
                    header('Content-type: text/vnd.wap.wml;charset=utf-8;' );
                    header("Cache-Control:no-cache");
                }else{
                    $acceptHeader = $_SERVER['HTTP_ACCEPT'];
                    if (false !== strpos($acceptHeader, 'application/vnd.wap.xhtml+xml')) {
                        header('Content-type: application/vnd.wap.xhtml+xml; charset=UTF8;');
                        header("Cache-Control:no-cache");
                    } else if (false !== strpos($acceptHeader, 'application/xhtml+xml')) {
                        header('Content-type: application/xhtml+xml; charset=UTF8;');
                        header("Cache-Control:no-cache");
                    } else {
                        header('Content-type: text/html; charset=UTF8;');
                        header("Cache-Control:no-cache");
                    }
                }
            }//未设置declareTplType不做header输出
        }
        //NA客户端检查跨域
        $this->checkAccess();
    }

    //响应头(render后)
    protected function __headerAfter(){
        if($this->declareHeader){
            $headers = $this->_headerInfo;
            if(is_array($headers)){
                foreach($headers as $header){
                    if(preg_match('/\$\{contentLength\}/', $header)){
                        $contentLength = ob_get_length();
                        $header = preg_replace('/\$\{contentLength\}/', $contentLength, $header);
                        header($header);
                    }else{
                        continue;
                    }
                }
            }
        }
    }

    //渲染
    protected function __render(){
        if($this->declareRender && is_array($this->declareRender)){
            $targetRenderType = null;
            $defaultRenderType = null;
            foreach($this->declareRender as $renderType => $renderConf){

                //render配置中的type和请求参数中的type一致的作为目标render
                if(isset($renderConf[self::RENDER_TYPE_PARAM_KEY])){
                    if($type == $renderConf[self::RENDER_TYPE_PARAM_KEY]){
                        $targetRenderType = $renderType;
                    }
                }else{
                    //没有设置type的为默认render
                    $defaultRenderType = $renderType;
                }
            }

            $targetRenderType = $targetRenderType == null ? $defaultRenderType : $targetRenderType;

            if(in_array($targetRenderType, array(self::RENDER_TYPE_TPL,self::RENDER_TYPE_RESOURCE, 
                            self::RENDER_TYPE_INTERFACE,self::RENDER_TYPE_INTERFACE_NA,
                            self::RENDER_TYPE_SERVICE, self::RENDER_TYPE_INTERFACE_ORI, self::RENDER_TYPE_JSONP,
                            self::RENDER_TYPE_TEXT, self::RENDER_TYPE_NA_JSONP))){
                $targetRenderConf = $this->declareRender[$targetRenderType];
                call_user_func(array($this, '_render_'.$targetRenderType), $targetRenderConf);
            }
        }
    }


    private function _render_tpl($renderConf){

        //如果需要转向
        if(isset($this->res['data']['ru'])){
            $ru = $this->res['data']['ru'];
            header(sprintf('Location: %s', $ru));
        }
        $tplName = $renderConf['tplName'];
        if(is_array($this->res['data']) && !empty($this->res['data'])){
            foreach ($this->res['data'] as $key => $val) {
                $this->_view->assign($key, $val);
            }
        }
        $this->_view->display($tplName);
    }

	// api json
    private function _render_interface($renderConf){
        $out = json_encode((array)$this->res);
        header(self::RENDER_INTERFACE_HEAD);
        exit($out);
    }

    private function _render_interfaceNa($renderConf){
        $header = empty($this->res['data']['header']) ? self::RENDER_INTERFACE_HEAD : $this->res['data']['header'];
        if(is_array($header)){
            foreach($header as $hd){
                header($hd);
            }
        }else{
            header($header);
        }

        if($header == self::RENDER_INTERFACE_HEAD){
            unset($this->res['data']['header']);
            $out = json_encode($this->res);
            echo $out;
        }else{
            echo $this->res["data"]["content"];
        }   
    }   

    private function _render_naJsonp($renderConf){
        $data = $this->res['data'];
        header(self::RENDER_JSONP_HEAD);

        $jsonpCallback = $data['callback'];
        if(!preg_match('/^([\$_A-Za-z0-9])+$/', $jsonpCallback)){
            echo '';
            return;
        }
        unset($data['errstr']);
        unset($data['callback']);
        $jsonpParam = json_encode($data);

        echo $jsonpCallback . '(' . $jsonpParam . ')';
    }

    private function _render_interfaceOri($renderConf){
        $data = $this->res['data'];
        $encodingConf = Bd_Conf::getConf('encoding');
        $jsOe = $encodingConf['js_oe'];
        $jsIe = $encodingConf['js_ie'];
        // $out = json_encode(Bd_String::iconv_recursive($data, $jsIe, $jsOe));
        header(self::RENDER_INTERFACE_HEAD);
        echo $out;
    }

    private function _render_jsonp($renderConf){
        $data = $this->res['data'];
        $encodingConf = Bd_Conf::getConf('encoding');
        $jsOe = $encodingConf['js_oe'];
        $jsIe = $encodingConf['js_ie'];
        header(self::RENDER_JSONP_HEAD);

        $jsonpCallback = $data['jsonpCallback'];
        if(!preg_match('/^([\$_A-Za-z0-9])+$/', $jsonpCallback)){
            echo '';
            return;
        }
        $jsonpParam = json_encode(Bd_String::iconv_recursive($data['jsonpParam'], $jsIe, $jsOe));

        echo $jsonpCallback . '(' . $jsonpParam . ')';
    }

    private function _render_text($renderConf){
        $data = $this->res['data'];
        $encodingConf = Bd_Conf::getConf('encoding');
        $textOe = $encodingConf['text_oe'];
        $textIe = $encodingConf['text_ie'];
        $textContent = $data['textContent'];
        $textContent = Bd_String::iconv_recursive($data['textContent'], $textIe, $textOe);
        header(self::RENDER_TEXT_HEAD);
        echo $textContent;
    }

    private function _render_service($renderConf){
        $errno = $this->res['errno'];
        $errstr = $this->res['data']['errstr'];
        if($errno!=0){
            header(self::RENDER_SERVICE_HEAD_500.$errstr);
            exit;
        }
    }

    private function _render_resource($renderConf){
        if (isset($this->res['data']['header'])) {
            $header = $this->res['data']['header'];
            header($header);
        }
        $output = $this->res['data']['output'];
        echo $output;
    }
	
    protected function checkAccess(){
        //只对naapi做跨域检查
        /*
		if(!strstr($_SERVER['REQUEST_URI'], 'naapi')){
            return;
        }
        $ori = $_SERVER['HTTP_ORIGIN'];
        if(preg_match('/^https:\/\/.*.ttxs.com/', $ori)){
            header("Access-Control-Allow-Origin: $ori");
        }else{
            header("Access-Control-Allow-Origin: ".APP_DOMAIN);
        }
        header('Access-Control-Allow-Methods:POST,GET');
		*/
	}


}
