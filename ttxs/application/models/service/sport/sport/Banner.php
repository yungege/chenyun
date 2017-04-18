<?php
/**
 * 获取banner图
 */
class Service_Sport_Sport_BannerModel extends BasePageService {

	protected $bannerModel;
    
    public function __construct() {
    	$this->bannerModel = Dao_BannerModel::getInstance();
    }

    protected function __declare() {
        // $this->declareLogin = false;
    }

    protected function __execute($req) {
    	switch (strtolower(REQUEST_METHOD)) {
    		// 获取banner当前有效banner图，最多返回10张
    		case 'get':
    			$resData = [];
    			$bannerList = $this->bannerModel->getBannerList();
    			if(empty($bannerList))
    				return $resData;

				foreach ($bannerList as $row) {
					$item = [
						'adId' 		=> $row['_id'],
						'adTitle' 	=> $row['title'],
						'adDesc' 	=> $row['h5content'],
						'adUrl' 	=> $row['h5url'],
						'adImg' 	=> $row['coverimgurl'],
					];
					$resData[] = $item;
				}
    			return $resData;
    			
    			break;

    			// 添加banner图
    			case 'post':
    			// todo
    			
    			// 删除banner图
    			case 'delete':
    			// todo
    			
    			// 修改banner图
    			case 'put':
    			// todo

    			break;
    		
    		default:
    			
    			break;
    	}
    	
    }










}