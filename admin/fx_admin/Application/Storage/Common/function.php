<?php   
    function PWD($pwd){		//加密密码
		return md5(C('SALT_PWD').$pwd);
	}
	/**
	 * [getPower description]
	 * @return [type] [description]
	 */
	function getPower( $mKey ){
		if( !is_numeric( $mKey ) ){
			$_powerKey = session('powerKey');
			$_second_menu_id = I('second_menu_id/d');
			$mKey = $_powerKey[$_second_menu_id][$mKey];
		}
		$_power = session('power');
		return isset($_power[$mKey])?$_power[$mKey]:1;
	}

    /**
     * getParentCategory 商品树型父级类目
     * @param   Int     $mCategoryCid 分类ID
     * @return  Int|false
     */
    function getTreeCategory( $mCategoryCid, $mCategoryArr = array() ){
        $_goods_category_row = M('goods_category')->where("cid={$mCategoryCid}")->find();
        $mCategoryArr[] =$_goods_category_row['name'];
        if( 0 != intval($_goods_category_row['parent_cid']) ){
            return getTreeCategory( $_goods_category_row['parent_cid'], $mCategoryArr );
        }else{
        	krsort($mCategoryArr);
            return implode(' / ', $mCategoryArr) ;
        }
    }

    /**
     * getShopStr 取平台字符串
     * @param  Int 		 $mGoodsId  商品ＩＤ
     * @return 
     */
    function getShopStr( $mGoodsId){
    	$_system_shop_goods_list = M('system_shop_goods')->where("goods_id={$mGoodsId}")->select();
    	foreach ($_system_shop_goods_list as $key => $value) {
    		$_shop_list[] = $value['shop_name'];
    	}
    	if( isset($_shop_list) ){
    		return implode(',', $_shop_list);
    	}
    	return false;
    }


    /**
     * checkShopGoods 检测某商品是否发面在某平台
     * @param  Int $mShopId  平台ＩＤ
     * @param  Int $mGoodsId 商品ＩＤ
     * @return true|false
     */
    function checkShopGoods( $mShopId, $mGoodsId ){
    	return M('system_shop_goods')->where(array("shop_id"=>$mShopId, "goods_id"=>$mGoodsId) )->count()?true:false;
    }


	/**
	 * get_url 当前完整URL地址
	 * @return 
	 */
	function getUrl() {
	    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
	    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
	    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
	    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
	    return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
	}

	/**
	 * getMenuName 取得菜单名称
	 * @param  Int 		$mMenuId 菜单ID
	 * @return String
	 */
	function getMenuName( $mMenuId  ){
		if( 0 ==  $mMenuId ){
			switch ( I('get.menu_id') ){
				case 1:
					$mMenuId = 4;
					break; 
				case 2:
					$mMenuId = 8;
					break; 
				case 3:	
					$mMenuId = 10;
					break; 
			}
		}
	 	return $_menuName = M('system_menu')->where("id={$mMenuId}")->GetField('menu_name');
	 }

    /**
     * [getGoodsProperty           取商品属性值
     * @param  Int      $mGoodsId  商品ＩＤ    
     * @param  String   $mFiled    商品属性名
     * @return String          
     */
    function getGoodsProperty( $mGoodsId, $mFiled ){
        return M('goods_list_property')->where("goods_id={$mGoodsId} and  goods_key = '{$mFiled}'")->getField('goods_value');
    } 


    /**
     * goodsPicture 解析商品新图片
     * @param  String       $mGoodsPicture 商品新图片属性
     * @return Array|false                
     */
    function goodsPicture( $mGoodsPicture ){
        if( '' == $mGoodsPicture ){
            return false;
        } 
        preg_match_all('/([^:]{32})?:[0-9]{1}:[0-9]{1}/', $mGoodsPicture, $return_array );
        if( isset($return_array[1]) ){
            return $return_array[1];
        }else{
            return false;
        }
    }

    /**
     * getFirstImg 取第一张图片
     * @param   Int     $goods_id  取商品ＩＤ
     * @return  String|false           
     */
    function getFirstImg( $mGoodsImg ){
        $_target_folder = C('UPLOAD_URL');  
        if ( !file_exists( ROOT_DIR.$_target_folder.$mGoodsImg.'.tbi' ) ){
            return false;
        }
        if( file_exists( ROOT_DIR.$_target_folder.$mGoodsImg.'.jpg' ) ){
            return $_target_folder.$mGoodsImg.'.jpg';
        }
        if( copy( ROOT_DIR.$_target_folder.$mGoodsImg.'.tbi', ROOT_DIR.$_target_folder.$mGoodsImg.'.jpg' ) ){
            return $_target_folder.$mGoodsImg.'.jpg';
        }
        return false;
    }    


    /**
     * updataGoodsImg 更新商品图片
     * @param  Int $mGoodsId  商品ＩＤ
     * @param  Int $mTime     时间戳
     * @return String|false
     */
    
    function updataGoodsImg( $mGoodsId ){
		$_picture = getGoodsProperty( $mGoodsId , 'picture' );
        if( $_picture = goodsPicture( $_picture ) ){
        	$_time = M('goods_list')->where("goods_id={$mGoodsId}")->getField('addtime');
            $_first_img_path   = getFirstImg( date('Ymd', $_time).'/'.$_picture[0] );
            $_data['img_path'] = $_first_img_path;
            M('goods_list')->where("goods_id = $mGoodsId")->save( $_data );
            return $_data['img_path'];
        }
        return false;	
    }


	/**
	 * 根据参数生成图片地址
	 * @param string $url
	 * @param int $width
	 * @param int $height
	 * @param int $type
	 * @param boolean $water
	 */
	function img_url($url, $width, $height, $type=0, $water=false, $showDomain=false){
		if( is_numeric($url) ){
			$url = updataGoodsImg($url);
		}
		//首先判断文件是否存在
		$url_file = $_SERVER['DOCUMENT_ROOT'] . $url;
		if (!file_exists($url_file)) return  '';

		return img_url_by_arr(array(
				'u'	=> $url,
				'w'	=> $width,
				'h'	=> $height,
				'tp'=> $type,
				'wa'=> $water,
		), $showDomain);
	}

	/**
	 * 根据参数生成图片地址
	 * @param array $option 配置项
	 */
	function img_url_by_arr($optons, $showDomain=false){
		if( empty($optons['u']) ||
				empty($optons['w']) || intval($optons['w'])<1 ||
				empty($optons['h']) || intval($optons['h'])<1 ){
			return '';
		}

		//如果图片为远程地址就直接返回
		if( stripos($optons['u'], 'http://') === 0 ){
			return $optons['u'];
		}

		//重构参数格式
		$params[] = 'w-' . intval($optons['w']);
		$params[] = 'h-' . intval($optons['h']);
		if( !empty($optons['tp']) ){
			$params[] = 'tp-'.$optons['tp'];
		}
		if( !empty($optons['wa']) ){
			$params[] = 'wa-1';
		}

		$url	= $optons['u'];
		$param	= implode('-', $params);
		$lmd5	= md5( $url . $param . C('IMAGE_CHECK_KEY'));
		$img	= '/auto/'.substr($lmd5, 0, 2).'/'.$lmd5.'.jpg';
		//return C('UPLOAD_PATH');
		//如果存在图片就直接返回图片
		if( is_file(C('UPLOAD_PATH').$img) ){
			return get_upload_url($img);
		}

		//生成校验码
		$key = substr($lmd5, 8, 16);
		//返回新路径
		 return U('Image/url', array('u'=>urlencode($url), 'p'=>$param, 'k'=>$key));
	}
	/**
	 * 获取上传文件的完整访问URL 
	 * @param string $path 上传文件相对根路径 
	 * @return string
	 */	
	function get_upload_url($path){
		return C('UPLOAD_URL').$path;
	}
        
/**
 * [get_freight_template 查询运费信息]
 * @param int $fid
 * @author san shui <2881501985@qq.com>
 * @return string
 */
function get_freight_template($fid){
    return M('fx_freight_template')->where(array('freight_template_id'=>$fid))->getField('name');
}
/**
 * [get_supplier_user 获取供应商]
 * @param int $uuid
 * @author san shui <2881501985@qq.com>
 * @return string
 */
function get_supplier_user($uuid){
   // echo $uuid;exit;
    return M('fx_supplier_user')->where(array('id'=>$uuid))->getField('user_account');
}

/**
 * [getOrderConcatAll 获取订单收件人所有地址信息]
 * @param  int  $mOrderID [订单ID]
 * @return Array           [数组]
 */
function getOrderConcatAll($mOrderID, $mLimit = 1) {
    $_concat = M('order_contact')->where(array('order_id' => $mOrderID))->order('id desc');
    if (1 == $mLimit) {
        return $_concat->find();
    } else {
        return $_concat->select();
    }
}

/**
 * [getOrderGoodsSK 获取订单商品SKU]
 * @param  [订单id] $mOrderID [description]
 * @param  [订单商品id] $mGoodsID [description]
 * @return [type]           [description]
 */
function getOrderGoodsSK($mOrderID = '', $goodsId = '') {
    $map['order_id'] = $mOrderID;
    if (empty($goodsId)) {
        $_order_sku_id = M('order_goods_sku')->where($map)->Field('sku_comb_id,goods_id')->find();
        $con_sku_val = M('goods_sku_comb')->where(array('goods_id' => $_order_sku_id['goods_id'], 'id' => $_order_sku_id['sku_comb_id']))->getField('sku_str');
        $_where['goods_id'] = $_order_sku_id['goods_id'];
        $_data['goods_id'] = $_order_sku_id['goods_id'];
    } else {
        $con_sku_val = M('goods_sku_comb')->where(array('goods_id' => $goodsId))->getField('sku_str');
        $_where['goods_id'] = $goodsId;
        $_data['goods_id'] = $goodsId;
    }
    preg_match_all('/([0-9]+:[0-9]+);/', $con_sku_val, $rk);
    $arr_sku = array();
    foreach ($rk[1] as $k => $v) {
        $sku_key_val = explode(':', $v);
        $sku_name = $sku_key_val[0];
        $sku_val = $sku_key_val[1];
        $_where['sku_name'] = $sku_name;
        //$sku_name_str = M('goods_sku_list_name')->where($_where)->getField('sku_name_str');
        $_data['sku_val'] = $sku_val;
        //$sku_val_str = M('goods_sku_list_val')->where($_data)->getField('sku_val_str');
        $arr_sku[$sku_name_str] = $sku_val_str;
    }
    return $arr_sku;
}