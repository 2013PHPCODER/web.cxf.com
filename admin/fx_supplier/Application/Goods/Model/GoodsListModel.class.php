<?php

namespace Goods\Model;

use Think\Model;

class GoodsListModel extends Model {

    /**
     * getGoodsList 商品列表
     * @param  Array  $mWhere 查询条件
     * @param  String $mOrder 排序
     * @return Array         
     */
    public function getGoodsList($mWhere = '', $mOrder = '', $fields = '') {
        $_count = $this->where($mWhere)->count();
        $_page = getpage($_count);
        $_goods_list = $this->field($fields)->join('left join goods_img_path on goods_img_path.md5_path=goods_list.img_path')->where($mWhere)->order($mOrder);
        if (0 == I('get.explode_goods/d')) {
            $_goods_list = $_goods_list->limit($_page->firstRow . ',' . $_page->listRows);
        }
        $_data['list'] = $_goods_list->select();
//        echo $this->getLastSql();exit;
        $_data['sql'] = $this->getlastsql();
        $_data['page'] = $_page->show();
        return $_data;
    }

    /**
     * getGoodsList 导出商品价格列表
     * @param  Array  $mWhere 查询条件
     * @param  String $mOrder 排序
     * @return Array         
     */
    public function outPutGoodsList($mWhere = '', $mOrder = '', $fields = '') {
        $_count = $this->where($mWhere)->count();
        $_page = getpage($_count);
        $_goods_list = $this->join('goods_sku_comb on goods_list.goods_id=goods_sku_comb.goods_id')
                        ->field($fields)->where($mWhere)->order($mOrder);
        if (0 == I('get.explode_goods/d')) {
            $_goods_list = $_goods_list->limit($_page->firstRow . ',' . $_page->listRows);
        }
        $_data['list'] = $_goods_list->select();
        $_data['sql'] = $this->getlastsql();
        $_data['page'] = $_page->show();
        return $_data;
    }

    /**
     * searchWhere 搜索条件组合
     * @return Array 
     */
    public function searchWhere($user_id) {
        //商品状态
        $_where['supplier_id'] = $user_id;
        $_where['is_delete'] = 0;
        $_where['goods_lack'] = 0;
        if (2 == I('get.group_id')) {
            $_where['new_upload'] = 0;
        }
        if (3 == I('get.group_id')) {
            $_where['goods_sale'] = 2;
            $_where['off_sale_time'] = array('gt', 0);
            $_where['new_upload'] = 1;
        }
        if (4 == I('get.group_id')) {
            $_where['goods_sale'] = 1;
            $_where['sale_time'] = array('gt', 0);
            $_where['goods_status'] = 3;
        }
        if (5 == I('get.group_id')) {
            $_where['goods_status'] = 1;
            $_where['goods_sale'] = 1;
            $_where['new_upload'] = 1;
        }
        if (6 == I('get.group_id')) {
            $_where['goods_status'] = 2;
        }
        //商品状态
        if (2 == I('get.goods_status')) {
            $_where['new_upload'] = 0;
        }
        if (3 == I('get.goods_status')) {
            $_where['goods_sale'] = 2;
            $_where['off_sale_time'] = array('gt', 0);
            $_where['new_upload'] = 1;
        }
        if (4 == I('get.goods_status')) {
            $_where['goods_sale'] = 1;
            $_where['sale_time'] = array('gt', 0);
            $_where['goods_status'] = 3;
        }
        if (5 == I('get.goods_status')) {
            $_where['goods_status'] = 1;
            $_where['goods_sale'] = 1;
            $_where['new_upload'] = 1;
        }
        if (6 == I('get.goods_status')) {
            $_where['goods_status'] = 2;
        }
        //商品id
        if (1 == I('get.explode_goods/d')) {
            if (is_array(I('get.explodeGoods'))) {
                $_where['goods_list.goods_id'] = array('in', I('get.explodeGoods'));
            }
        }
        //商品类目
        if (I('get.goods_category')) {
            $_where['top_category'] = I('get.goods_category', 0);
        }
        //仓库名称
        if (I('get.depot')) {
            $_where['depot_id'] = I('get.depot', 0);
        }
        //上架时间 
        if ('sale_time' == I('get.time_type') and ( I('get.startTime') or I('get.endTime') )) {
            $_startTime = I('get.startTime', 0) ? strtotime(I('get.startTime', 0)) : 1;
            $_endTime = I('get.endTime') ? strtotime(I('get.endTime')) : time();
            $_where['conf_time'] = array('BETWEEN', array($_startTime, $_endTime));
        }
        //下架时间
        if ('off_sale_time' == I('get.time_type') and ( I('get.startTime') or I('get.endTime') )) {
            $_startTime = I('get.startTime', 0) ? strtotime(I('get.startTime', 0)) : 1;
            $_endTime = I('get.endTime') ? strtotime(I('get.endTime')) : time();
            $_where['off_sale_time'] = array('BETWEEN', array($_startTime, $_endTime));
        }
        //上传时间
        if ('addtime' == I('get.time_type') and ( I('get.startTime') or I('get.endTime') )) {
            $_startTime = I('get.startTime', 0) ? strtotime(I('get.startTime', 0)) : 1;
            $_endTime = I('get.endTime') ? strtotime(I('get.endTime')) : time();
            $_where['addtime'] = array('BETWEEN', array($_startTime, $_endTime));
        }
        //商品名称或者货号
        if (0 !== I('get.goods_search', 0)) {
            if ('goods_name' != I('get.goods_search') and 'buyer_goods_no' != I('get.goods_search')) {
                if (I('get.search_word') != '') {
                    $_where[I('get.goods_search')] = I('get.search_word');
                }
            } else {
                if (I('get.search_word') != '') {
                    $_where[I('get.goods_search')] = array('like', "%" . I('get.search_word') . "%");
                }
            }
        }
        return $_where;
    }

    /**
     * saveGoods 保存导入的商品
     * @param  [String] $mFilePath [导入商品文件路径]
     * @return  Array|true|false
     */
    public function saveGoods($upload_size, $mFilePath, $user_info, $mPara = array()) {
        //读取csv文件
        $_goods_arrary = goodsFileAnalytic($mFilePath);
        if (count($_goods_arrary) > $upload_size) {
            return false;
        }
        $_goods_key = array();
        $_goods_key_zh = array();
        $_time = time();
        //统计数据
        $_returnData['_total_num'] = 0;
        $_returnData['_total_ok'] = 0;
        $_returnData['_error_num'] = 0;
        $_returnData['_no_error_num'] = 0;
        $_returnData['_re_num'] = 0;
        //解析失败
        if (3 > count($_goods_arrary)) {
            return $_returnData;
        }
        $goods_error_model = new GoodsErrorModel();
        $goods_list_property_model = new GoodsListPropertyModel();
        $goods_sku_comb_model = new GoodsSkuCombModel();
        $goods_ids = array();
        foreach ($_goods_arrary as $key => $value) {

            if (0 == $key) {
                $goods_error_model->where(array('user_name' => $user_info['user_account']))->delete();
                continue;
            }
            if (1 == $key) {
                $_goods_key = $value;
                continue;
            }
            if (2 == $key) {
                $_goods_key_zh = $value;
                continue;
            }
            $_returnData['_total_num'] ++;
            if ('' == trim($value[33]) && '' == trim($value[0]) && '' == trim($value[1])) {
                break;
            }
            if ('' == trim($value[33])) {
                $_returnData['_no_error_num'] ++;
                continue;
            }
            $_data = NULL;
            $_data['depot_id'] = $mPara['depot_id'];
            $_data['goods_name'] = $value[0];
            $_data['buyer_goods_no'] = $value[33];
            $_data['goods_category'] = $value[1];
            $_data['goods_sale'] = 2;
            $_data['goods_status'] = 1;
            $_data['addtime'] = $_time;
            $_data['price'] = $value[7];
            $_data['supplier_id'] = $user_info['id'];
            $_data['platform'] = $user_info['platform'];
            $_data['top_category'] = get_top_category($value[1]);
            $_data['item_weight'] = $value[50];
            $_error = NULL;
            //检测有无重复
            $_e_data['buyer_goods_no'] = $value[33];
            $_e_data['supplier_id'] = $user_info['id'];
            $_e_data['goods_category'] = $_data['goods_category'];
            $_e_data['is_delete'] = 0;
            $_goods_row = $this->where($_e_data)->find();
            //检查是否有违禁词
            $_prohibited_words = C('prohibited_words');
            foreach ($_prohibited_words as $v) {
                if (stristr($value[0], $v)) {
                    $_error['goods_lack_momo']['prohibited_words'] = '有违禁词';
                    break;
                }
                if (stristr($value[20], $v)) {
                    $_error['goods_lack_momo']['prohibited_words'] = '有违禁词';
                    break;
                }
            }
            //检测错误
            if ('' == $value[0]) {
                $_error['goods_lack_momo']['title'] = '宝贝名称';
                $_returnData['_error_num'] ++;
            }
            if (0 == intval($value[1])) {
                $_error['goods_lack_momo']['cid'] = '宝贝类目';
                $_returnData['_error_num'] ++;
            }
            if (strlen($value[20]) <= 5) {
                $_error['goods_lack_momo']['description'] = '宝贝描述';
                $_returnData['_error_num'] ++;
            }
            if ('' == $value[3]) {
                $_error['goods_lack_momo']['stuff_status'] = '新旧程度';
                $_returnData['_error_num'] ++;
            }
            if ('' == $value[4]) {
                $_error['goods_lack_momo']['location_state'] = '省';
                $_returnData['_error_num'] ++;
            }
            if ('' == $value[5]) {
                $_error['goods_lack_momo']['location_city'] = '城市';
                $_returnData['_error_num'] ++;
            }
            //记录错误信息
            if (is_array($_error)) {
                $_data['goods_lack'] = 1;
                $_data['goods_lack_momo'] = serialize($_error);
            } else {
                $_data['goods_lack'] = 0;
                $_data['goods_lack_momo'] = '';
                if (0 == intval($_goods_row['goods_id'])) {
                    $_returnData['_total_ok'] ++;
                }
                if (0 < intval($_goods_row['goods_id']) && $_goods_row['goods_lack'] == 1) {
                    $_returnData['_total_ok'] ++;
                }
            }
            //记录商品上传错误信息--重复
            if (0 < intval($_goods_row['goods_id'])) {
                if (0 == $_goods_row['goods_lack']) {
                    $error_data['goods_id'] = $_goods_row['goods_id'];
                    $error_data['user_name'] = $user_info['user_account'];
                    $error_data['goods_lack_momo'] = serialize(array('goods_lack_momo' => array('re' => '重复')));
                    $error_data['addtime'] = time();
                    $goods_error_model->add($error_data);
                    $_returnData['_re_num'] ++;
                    continue;
                }
            }
            //生成货号并保存数据
            if (intval($_goods_row['goods_id'])) {
                $this->where($_goods_row)->save($_data);
                $_goods_id = $_goods_row['goods_id'];
            } else {
                do {
                    $_goods_no = $this->max('goods_no');
                    $_goods_no = ( $_goods_no < 1000000 ) ? 1000000 : $_goods_no + 1;
                } while (0 < $this->where(array('goods_no' => $_goods_no))->count());
                $_data['goods_no'] = $_goods_no;
                $_goods_id = $this->add($_data);
                $goods_ids[] = $_goods_id;
            }

            //商品被锁定记录
            if (1 == $_data['goods_lack']) {
                $error_data['goods_id'] = $_goods_id;
                $error_data['user_name'] = $user_info['user_account'];
                $error_data['goods_lack_momo'] = serialize($_error);
                $error_data['addtime'] = time();
                $goods_error_model->add($error_data);
            }
            //sku缺失
            if (empty($value[30])) {
                $error_data['goods_id'] = $_goods_id;
                $error_data['user_name'] = $user_info['user_account'];
                $error_data['goods_lack_momo'] = serialize(array('goods_lack_momo' => array('re' => 'sku缺失')));
                $error_data['addtime'] = time();
                $goods_error_model->add($error_data);
                $_returnData['_re_num'] ++;
                continue;
            }
            //goods_list记录成功，更新商品属性，如果错误，则先删除属性再更新
            if (0 < $_goods_id) {
                if (0 < intval($_goods_row['goods_id'])) {
                    $_del_where['goods_id'] = $_goods_id;
                    M('goods_art_no')->where($_del_where)->delete();
                    $goods_list_property_model->where($_del_where)->delete();
                    $goods_sku_comb_model->where($_del_where)->delete();
                    M('goods_list_sku')->where($_del_where)->delete();
                    M('goods_list_desc')->where($_del_where)->delete();
                }
                //添加商品货号
//                M('goods_art_no')->add(array('goods_id' => $_goods_id, 'art_no' => $value[33], 'addtime' => time()));
                $goods_list_property_model->mosaicGoods($_goods_id, $_goods_key, $_goods_key_zh, $value);
                $alias = $this->get_alias_array($value[34]);
                $input_custom_cpv = $this->get_alias_array($value[59]);
                $stock_num = $goods_sku_comb_model->addGoodsSkuComb($_goods_id, $_goods_no, $value[1], $value[30], $alias, $input_custom_cpv);
                //添加desc和无线详情x
                M('goods_list_desc')->add(array('goods_id' => $_goods_id, 'desc' => $value[20], 'wireless_desc' => $value[21]));
                //将图片存入单独的表单、以便脚本程序上传到淘宝
                $img = $this->set_img_path($value[28]);
//                M('goods_list_img')->add(array('goods_id' => $_goods_id, 'img_paths' => $pictures['img_path'], 'is_upload' => 0));
                //添加总库存,图片
                $this->where(array('goods_id' => $_goods_id))->save(array('stock_num' => $stock_num, 'img_path' => $img['first'], 'picture_path' => $img['first'] . '.tbi', 'img_paths' => json_encode($img['img']))); // 'img_path' => $pictures['first'], 'img_paths' => $pictures['img_path']));
            }
        }
        $_returnData['goods_ids'] = $goods_ids;
        unset($_goods_arrary, $goods_ids);
        if (0 < $_returnData['_error_num'] || 0 < $_returnData['_re_num'] || 0 < $_returnData['_total_num']) {
            return $_returnData;
        }
        return true;
    }

    /**
     * 将自定义属性转换成数组
     * @param type $alias
     */
    private function get_alias_array($alias) {
        $data = array();
        if ($alias) {
            $str = array_filter(explode(';', $alias));
            $data = array();
            foreach ($str as $v) {
                $ali_array = array_filter(explode(':', $v));
                $value = array_pop($ali_array);
                $key = implode(':', $ali_array);
                $data[$key] = $value;
            }
        }
        return $data;
    }

    /**
     * 通过商品csv中数据解析出商品图片地址
     * @param type $picture
     */
//    private function get_img_path($picture, $add_time) {
//        $pic = explode('|;', $picture);
//        $return = array();
//        $floder = C('UPLOAD_URL') . date('Ymd', $add_time);
//        foreach ($pic as $key => $value) {
//            if (!empty($value)) {
//                $paths = explode(':', $value);
//                if ($key == 0) {
//                    $return['first'] = $floder . '/' . $paths[0] . '.jpg';
//                }
//                $path = $floder . '/' . $paths[0] . '.tbi';
//                $img_path[] = $path;
//            }
//        }
//        $return['img_path'] = json_encode($img_path);
//        return $return;
//    }
    private function set_img_path($picture) {
        $pic = explode(';', $picture);
        $img_path = array();
        $return_path = array();
        foreach ($pic as $key => $value) {
            if (!empty($value)) {
                $paths = explode(':', $value);
                if ($key == 0) {
                    $return_path['first'] = $paths[0];
                }
                $return_path['img'][] = $paths[0];
                $in_img = M('goods_img_path')->where(array('md5_path' => $paths[0]))->field('md5_path')->find();
                if (empty($in_img)) {
                    $img_path[$key]['md5_path'] = $paths[0];
                }
            }
        }
        if (!empty($img_path)) {
            M('goods_img_path')->addAll($img_path);
        }
        return $return_path;
    }

}
