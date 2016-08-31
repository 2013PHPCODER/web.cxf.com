<?php

namespace api\home;

class Goods_listDao extends Dao {
    /*     * 执行自定义增删改语句 */

    /**
     * 获取7个一级分类下的二级分类
     * @return array 
     * @author John Doe <john.doe@example.com>
     * @since 201608161621
     */
    public function goods_center() {
        //获取排序靠前的7条数据
        $_goods_category_1_sql = 'SELECT ico,name,cid,category_id FROM goods_category'
                . ' WHERE status=:status AND has_goods=:has_goods AND level=:level ORDER BY `order` LIMIT 0,7';
        $_category_1_arr = $this->query($_goods_category_1_sql, array(
            'status' => 1, 'level' => 1,'has_goods'=>1
        ));
        
        //获取4条二级分类
        $_tmp_category_id = '';
        foreach ($_category_1_arr as $_key => $_value) {
            $_tmp_category_id .= '"' . $_value['category_id'] . '",';
        }
        $_tmp_category_id = substr($_tmp_category_id, 0, -1);
        $_category_2_sql = 'SELECT cid,name,parent_id FROM goods_category WHERE '
                . 'status=:status AND level=:level AND has_goods=:has_goods AND parent_id IN (' . $_tmp_category_id . ') ORDER BY `order`';
        $_category_2_arr = $this->query($_category_2_sql, array(
            'status' => 1, 'level' => 2,'has_goods'=>1
        ));
        //归类 筛选
        $_tmp_category = array();
        foreach ($_category_1_arr as $_key => $_value) {
            $_tmp_category[$_key]['ico'] = $_value['ico'];
            $_tmp_category[$_key]['name'] = $_value['name'];
            $_tmp_category[$_key]['cid'] = $_value['cid'];
            $_tmp_category[$_key]['child'] = array();
            $i = 1;
            foreach ($_category_2_arr as $_k => $_v) {
                if ($_value['category_id'] == $_v['parent_id']) {
                    //获取排序前4条
                    if (\goods::category_two_level < $i) {
                        unset($_category_2_arr[$_k]);
                        continue;
                    }
                    $_re_rand_goods = $this->rand_goods($_v['cid']);
                    $_good_arr = empty($_re_rand_goods) ? array() : $_re_rand_goods;
                    $_tmp_category[$_key]['child'][] = array('cid' => $_v['cid'], 'name' => $_v['name'], 'goods' => $_good_arr);
                    unset($_good_arr);
                    //当为第一条加载商品数据
//                    if (1 == $i) {
//                        $_good_arr = $this->rand_goods($_v['cid']);
//                        $_tmp_category[$_key]['child'][] = array('cid' => $_v['cid'], 'name' => $_v['name'], 'goods' => $_good_arr);
//                        unset($_good_arr);
//                    } else {
//                        $_tmp_category[$_key]['child'][] = array('cid' => $_v['cid'], 'name' => $_v['name']);
//                    }
                    $i++;
                }
            }
            unset($_category_1_arr[$_key]);
        }
        return $_tmp_category;
    }

    /**
     * 递归随机多少条商品数据
     * @param int $_goods_category 商品类目
     * @param int $_count 获取条数
     * @return array
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608171059
     */
    public function rand_goods($_goods_category, $_count = 10) {
        $_sql = 'SELECT buyer_goods_no,price,goods_id,goods_name,img_path FROM goods_list WHERE goods_category=:goods_category '
                . 'AND goods_sale=:goods_sale ORDER BY goods_id DESC LIMIT ' . \goods::goods_count_limit;
        $_re_arr = $this->query($_sql, array('goods_category' => $_goods_category, 'goods_sale' => 1));
        if (empty($_re_arr)) return false;
        $_rand_arr = count($_re_arr) > $_count ? array_rand($_re_arr, $_count) : $_re_arr;
        $_img_path_sql = 'SELECT tb_path FROM goods_img_path WHERE md5_path=:md5_path';
        foreach ($_rand_arr as $_key => $_value) {
            $price = change_price($_value['price']);
            $_img_path_arr = $this->query($_img_path_sql, array('md5_path' => $_value['img_path']), 'fetch_row');
            //$dis_price = $price['distribution_price'];
            //unset($price['distribution_price']);
            $_arr[$_key] = array('change_price' => $price,
                'goods_id' => $_value['goods_id'], 'goods_name' => $_value['goods_name'],
                'img_path' => $_img_path_arr['tb_path'], 'buyer_goods_no' => $_value['buyer_goods_no']);
        }
        unset($_rand_arr);
        return $_arr;
    }

    /**
     * 获取单条商品详情
     * @param type $goods_id
     */
    public function get_goods_detail($goods_id, $platform) {

        $field = '`gl`.goods_id,`gl`.goods_no,`gl`.goods_name,`gl`.goods_sale,`gl`.price,`gl`.collect_count,`gl`.goods_status,`gl`.buyer_goods_no,`gl`.supplier_id,`gd`.`desc`,'
                . '`gl`.depot_id,`gl`.is_missing,`gip`.`tb_path` as `img_path`,`gl`.is_delete,`gl`.addtime,`gl`.stock_num,`gl`.`img_paths`,gl. `collect_count` ';
        $sql = 'select ' . $field . ' from goods_list as `gl` inner join goods_list_desc as `gd` on `gl`.goods_id=`gd`.goods_id '
                . ' left join goods_img_path as gip on gl.img_path=gip.md5_path'
                . ' where `gl`.goods_id=:goods_id and `gl`.platform=:platform';
        $detail = $this->query($sql, array('goods_id' => $goods_id, 'platform' => $platform));
        if (empty($detail[0])) {
            myerror(\StatusCode::msgFailStatus, '错误的商品！');
        }
        $goods_info['detail'] = $detail[0];
        unset($detail);
        //验证商品状态
        if ($goods_info['detail']['goods_sale'] == 2 || $goods_info['detail']['goods_status'] != 3 || $goods_info['detail']['is_missing'] == 1 || $goods_info['detail']['is_delete'] == 1) {
            myerror(\StatusCode::msgFailStatus, '错误的商品！');
        }
        $img_paths = $this->change_tb_imgs($goods_info['detail']['img_paths']);
        unset($goods_info['detail']['img_paths']);
        $goods_info['detail']['img_paths'] = $img_paths;
        $price = $goods_info['detail']['price'];
        unset($goods_info['detail']['price']);
        $goods_info['detail']['price'] = change_price($price);
        $sku_sql = 'SELECT goods_id,sku_name,sku_name_str,sku_val,sku_val_str FROM goods_list_sku WHERE goods_id=:goods_id order by id asc';
        $sku_info = $this->query($sku_sql, array('goods_id' => $goods_id));
        if (empty($sku_info)) {
            myerror(\StatusCode::msgFailStatus, '商品属性为空！');
        }
        $sku = array();
        $sku_list = array();
        if (!empty($sku_info)) {
            foreach ($sku_info as $val) {
                $sku_val = json_decode($val['sku_val'], true);
                $sku_val_str = json_decode($val['sku_val_str'], true);
                $sku[$val['sku_name']]['name'] = $val['sku_name_str'];
                array_push($sku_list, $val['sku_name']);
                $sku[$val['sku_name']]['val'] = array_combine($sku_val, $sku_val_str);
            }
        }
        $goods_info['sku'] = empty($sku) ? $sku_info : $sku;
        $goods_info['sku_list'] = $sku_list;
        $goods_info['most_goods'] = $this->get_most_goods($platform);
        $goods_info['up_taobao_goodlist'] = $this->get_fx_goods($platform);
        $goods_info['keep_good_list'] = $this->get_collect_goods($platform);
        return $goods_info;
    }

    /**
     * 转换商品图片成淘宝图片地址
     * @param type $images
     */
    public function change_tb_imgs($images) {
        $path_array = json_decode($images, true);
        if (empty($path_array)) {
            return array();
        }
        $path_str = '';
        foreach ($path_array as $v) {
            $path_str.= "'" . $v . "',";
        }
        $path_str = trim($path_str, ',');
        $img_sql = 'select tb_path,md5_path from goods_img_path where md5_path in(' . $path_str . ')';
        $img = $this->query($img_sql, array());
        $img_path = array();
        foreach ($img as $v) {
            if (!empty($v['tb_path'])) {
                array_push($img_path, $v['tb_path']);
            }
        }
        return $img_path;
    }

    /**
     * 转换商品图片成淘宝图片地址
     * @param type $images
     */
    public function change_imgs_tb($images) {
        $path_array = json_decode($images, true);
        if (empty($path_array)) {
            return array();
        }
        $path_str = '';
        foreach ($path_array as $v) {
            $path_str.= "'" . $v . "',";
        }
        $path_str = trim($path_str, ',');
        $img_sql = 'select tb_path,md5_path from goods_img_path where md5_path in(' . $path_str . ')';
        $img = $this->query($img_sql, array());
        return $img;
    }

    /**
     * 获取销量最高的2条商品
     * @param type $platform
     */
    public function get_most_goods($platform) {
        $condition = ' platform = :platform and goods_sale=1 and goods_status=3 and is_missing=0 and is_delete=0 ';
        $field = 'goods_id, goods_name, tb_path as `img_path`, `price`';
        $param = array('platform' => $platform);
        $sort = 'sale_count desc';
        $start = 0;
        $end = 2;
        return $this->get_goods_list($condition, $param, $field, $sort, $start, $end); // $this->get_goods_list($condition,$param $sort, $start, $end);
    }

    /**
     * 分销量最高的商品前10条
     */
    public function get_fx_goods($platform) {
        $condition = ' platform = :platform and goods_sale=1 and goods_status=3 and is_missing=0 and is_delete=0 ';
        $field = 'goods_id, goods_name, tb_path as `img_path`,`price`';
        $param = array('platform' => $platform);
        $sort = 'fx_count desc';
        $start = 0;
        $end = 10;
        return $this->get_goods_list($condition, $param, $field, $sort, $start, $end);
    }

    /**
     * 收藏最多的10条商品
     */
    public function get_collect_goods($platform) {
        $condition = ' platform = :platform and goods_sale=1 and goods_status=3 and is_missing=0 and is_delete=0 ';
        $field = 'goods_id, goods_name, tb_path as `img_path`,`price`';
        $param = array('platform' => $platform);
        $sort = 'collect_count desc';
        $start = 0;
        $end = 10;
        return $this->get_goods_list($condition, $param, $field, $sort, $start, $end);
    }

    /**
     * * 获取商品列表
     * @param string $condition
     * @param string $field
     * @param string $sort
     * @param int $start 开始条数
     * @param int $end 结束条数
     */
    public function get_goods_list($condition, $param, $field, $sort, $start, $end) {
        $sql = 'select ' . $field . ' from goods_list as `gl`  left join goods_img_path as `gi` on gl.img_path=gi.md5_path where ' . $condition . '  order by ' . $sort . ' limit ' . $start . ', ' . $end;
        $data = $this->query($sql, $param);
        if (!empty($data)) {
            foreach ($data as $key => $val) {
                $price = $val['price'];
                $goods_price = change_price($price);
                unset($data[$key]['price']);
                $data[$key]['price'] = $goods_price['basic_price'];
            }
        }
        return $data;
    }

    /**
     * 根据商品id和sku组合查询该属性对应信息
     * @param type $goods_id
     * @param type $sku_attr
     */
    public function get_sku_comb($goods_id, $sku_attr) {
        $sql = 'SELECT id, goods_id, stock_num, stock_lock_num,original_price FROM `goods_sku_comb` where goods_id =:goods_id and sku_attr =:sku_attr limit 1';
        $sku = $this->query($sql, array('goods_id' => $goods_id, 'sku_attr' => $sku_attr), 'fetch_row');
        if (empty($sku)) {
            myerror(\StatusCode::msgFailStatus, '错误的商品属性！');
        }
        return $sku;
    }

    /**
     * 组装一间铺货需要商品信息
     * @param type $goods_id
     */
    public function get_goods_info_tb($goods_id) {
        $fields = '`gl`.price,`gl`.goods_name,`gl`.goods_category,`gli`.tb_path as `img_path`,`gd`.desc,`gd`.wireless_desc,`gl`.img_paths,`gl`.goods_status,`gl`.goods_sale,`gl`.is_delete,`gl`.is_missing ';
        $sql = 'SELECT ' . $fields . ' FROM `goods_list` as gl inner join goods_list_desc as gd on gl.goods_id=gd.goods_id '
                . 'INNER JOIN goods_img_path as `gli` on gl.img_path=gli.md5_path where gl.goods_id=:goods_id';
        $sku = $this->query($sql, array('goods_id' => $goods_id), 'fetch_row');
        if (empty($sku)) {
            myerror(\StatusCode::msgFailStatus, '错误的商品属性！');
        }
        if ($sku['goods_status'] != 3 || $sku['goods_sale'] != 1 || $sku['is_delete'] == 1 || $sku['is_missing'] == 1) {
            myerror(\StatusCode::msgFailStatus, '商品状态错误！');
        }
        return $sku;
    }

    /**
     * 查询商品原始信息
     * @param type $goods_id
     */
    public function get_goods_propety($goods_id
    ) {
        $sql = 'select * from goods_list_property where goods_id=:goods_id';
//                . ' and goods_key in ("num","title","cid","outer_id","cateProps","propAlias","inputPids","location_state","location_city","inputValues","freight_payer","qualification","features","input_custom_cpv")';
        $sku = $this->query($sql, array('goods_id'
            => $goods_id));
        if (empty($sku)) {
            myerror(\StatusCode ::msgFailStatus, '错误的商品属性！');
        }
        return $sku;
    }

    /**
     * 根据淘宝助理数据获取sku props array（用于淘宝上传商品taobao.item.add，用正则截取字符串，兼容性较高，推荐使用）
     * @param float $price 商品单价，示例：180
     * @param int $num 商品总数量，示例：3000
     * @param string $skuprops 淘宝助理sku字符串，示例：'180:1000::1627207:28327;20509:28383;180:1000::1627207:28331;20509:28383;180:1000::1627207:28866;20509:28383;';
     * @param int $item_id 平台商品ID，示例：101
     * @return array 返回数组元素：sku_prop_array、sku_num_array、sku_price_array、sku_outer_id_array
     */
    private function get_sku_props_array($price, $num, $skuprops, $item_id = 0) {
        //$pattern = '/(\d+:\d+;)+/'; //匹配sku部分(1627207:28327;20509:28383;)的正则
        $pattern = '/(\d+:(-|\+)?\d+;)+/'; //匹配sku部分(1627207:28327;20509:28383;)的正则（兼容自定义sku，前面有负号的情况）
        $preg_match_count = preg_match_all($pattern, $skuprops, $skuprops_arr);
        $skuprops_arr = $skuprops_arr[0];
        array_walk($skuprops_arr
                , function(&$sku) {
            if (str_equals(mb_substr($sku, -1), ';')) {
                $sku = mb_substr($sku, 0, mb_strlen($sku) - 1);
            }
        });

        if ($preg_match_count <= 0) return array(
            );
        //正则截取sku价格和数量字符串(180:1000::)
        $sku_price_num_arr = preg_split($pattern, $skuprops);
        //去除空元素
        $sku_price_num_arr = array_filter($sku_price_num_arr);
        //取得 sku price 数组、sku num 数组、sku outer_id 数组
        array_walk($sku_price_num_arr, function($v) use(&$sku_price_arr, &$sku_num_arr, &$sku_outer_id_arr) {
            $sku_price_arr[] = mb_substr($v, 0, mb_strpos($v, ':'));
            $v = mb_substr($v, mb_strpos($v, ':') + 1);
            $sku_num_arr[] = mb_substr($v, 0, mb_strpos($v, ':'));
            $v = mb_substr($v, mb_strpos($v, ':') + 1);
            $sku_outer_id_arr[] = mb_substr($v, 0, mb_strlen($v) - 1);
        });
        return array(
            'sku_prop_array' => array_filter($skuprops_arr),
            'sku_num_array' => $sku_num_arr,
            'sku_price_array' => array_filter($sku_price_arr),
            'sku_outer_id_array' => $sku_outer_id_arr
        );
    }

    /**
     * 根据淘宝助理数据获取sku字符串（用于淘宝上传商品taobao.item.add）
     * @param float $price 商品单价，示例：180
     * @param int $num 商品总数量，示例：3000
     * @param string $skuprops 淘宝助理sku字符串，示例：'180:1000::1627207:28327;20509:28383;180:1000::1627207:28331;20509:28383;180:1000::1627207:28866;20509:28383;';
     * @param int $item_id 平台商品ID，示例：101
     * @return array 返回数组元素：sku_properties、sku_quantities、sku_prices、sku_outer_ids
     */
    public function get_sku_props_string_array($price, $num, $skuprops, $item_id = 0) {
        $sku_props_array = $this->get_sku_props_array($price, $num, $skuprops, $item_id);
        if (empty($sku_props_array)) return array();
        //拼接sku字符串
        $sku_properties = implode(',', $sku_props_array['sku_prop_array']);
        $sku_quantities = implode(',', $sku_props_array['sku_num_array']);
        $sku_prices = implode(',', $sku_props_array['sku_price_array']);
        $sku_outer_ids = implode(',', $sku_props_array['sku_outer_id_array']);
        return array(
            'sku_properties' => $sku_properties,
            'sku_quantities' => $sku_quantities,
            'sku_prices' => $sku_prices,
            'sku_outer_ids' => $sku_outer_ids
        );
    }

    /**
     * 铺货
     * @param type $access_token
     * @param type $params
     * @param type $pictures
     * @param type $tb_images
     * @param type $err_msg
     * @return boolean
     */
    public function internal_upload_item($access_token, $params, $pictures, $tb_images, &$err_msg) {
        import('Taobao');
        $taobao_result = \Taobao::curl_taobao_api('taobao.item.add', $access_token, $params);
        if (!\Taobao::get_taobao_response($taobao_result, 'item_add_response', $response)) {
            $err_msg = isset($response->sub_msg) ? $response->sub_msg : $response->msg;
            if (strlen($err_msg) <= 0) $err_msg = $response->sub_msg;
            return false;
        }
        $num_iid = $response->item->num_iid;
        $picture = $this->get_item_pictures_all_info_filter($pictures);
        //sleep(2);
        //关联商品子图
        foreach ($picture['pictures_joint'] as $pic) {
            if (mb_strlen($pic['pic_path']) <= 0) continue;
            $is_major = 'false';
            if (str_equals($pic['pic_pos'], '0')) $is_major = 'true';
            $pic_path = $this->get_tb_img($pic['pic_md5'], $tb_images);
            $path = mb_substr($pic_path, mb_strpos($pic_path, 'imgextra/') + 9);
            $params = array(
                'num_iid' => $num_iid,
                'pic_path' => $path, // mb_substr($pic['pic_path'], mb_strpos($pic['pic_path'], 'imgextra/') + 9),
                'is_major' => $is_major,
                'position' => $pic['pic_pos']
            );
            $taobao_result = \Taobao::curl_taobao_api('taobao.item.joint.img', $access_token, $params);
        }
        //关联商品属性图
        foreach ($picture['pictures_props'] as $pic) {
            if (mb_strlen($pic['pic_path']) <= 0) continue;
            $pic_path = $this->get_tb_img($pic['pic_md5'], $tb_images);
            $sku_path = mb_substr($pic_path, mb_strpos($pic_path, 'imgextra/') + 9);
            $params = array(
                'properties' => $pic['pic_props'],
                'num_iid' => $num_iid,
                'pic_path' => $sku_path, // mb_substr($pic['pic_path'], mb_strpos($pic['pic_path'], 'imgextra/') + 9),
                'position' => $pic['pic_pos']
            );
            $taobao_result = \Taobao::curl_taobao_api('taobao.item.joint.propimg', $access_token, $params);
        }
        return true;
    }

    /**
     * 获取淘宝店铺图片
     * @param type $file
     * @param type $tb_paths
     * @param type $img_paths
     */
    public function get_tb_img($file, $tb_paths) {
        foreach ($tb_paths as $val) {
            if ($file == $val['md5_path']) {
                return $val['tb_path'];
            }
        }
    }

    /**
     * 根据淘宝助理picture字段获取所有图片链接（包括属性信息，用户上传商品关联商品子图）
     * @param string $picture 淘宝助理picture字段，示例：da874ee6f105d2e80d377ed28e496cf7:1:0:|https://img.alicdn.com/bao/uploaded/i3/TB1UwctKVXXXXbLXpXXSutbFXXX.jpg;8295d11960c19ac3104b8cc29d751566:1:1:|https://img.alicdn.com/bao/uploaded/i1/TB1oikmKVXXXXbkXFXXSutbFXXX.jpg;01043d5f53c096225173812b4fc0d145:1:2:|https://img.alicdn.com/bao/uploaded/i4/TB1.AEqKVXXXXXoXFXXSutbFXXX.jpg;93d374d45d3524b49e0caa4fb92314c9:2:2:1627207:7080923|https://img.alicdn.com/bao/uploaded/i4/TB146oiKVXXXXXBXVXXSutbFXXX.jpg;66bc2b63115bccd2ad796d9dfcdfc42f:2:1:1627207:28340|https://img.alicdn.com/bao/uploaded/i4/TB1v33iKVXXXXXiXVXXSutbFXXX.jpg;
     * @return array
     */
    private function get_item_pictures_all_info_filter($picture) {
        $pictures = $this->get_item_pictures_all_info($picture);
        $pictures_joint = array_filter($pictures, function($pic) {
            return str_equals($pic['pic_type'], '1');
        });
        $pictures_props = array_filter($pictures, function($pic) {
            return str_equals($pic['pic_type'], '2');
        });
        return array(
            'pictures_joint' => $pictures_joint,
            'pictures_props' => $pictures_props
        );
    }

    /**
     * 根据淘宝助理picture字段获取所有图片链接（包括属性信息，用户上传商品关联商品子图）
     * @param string $picture 淘宝助理picture字段，示例：da874ee6f105d2e80d377ed28e496cf7:1:0:|https://img.alicdn.com/bao/uploaded/i3/TB1UwctKVXXXXbLXpXXSutbFXXX.jpg;8295d11960c19ac3104b8cc29d751566:1:1:|https://img.alicdn.com/bao/uploaded/i1/TB1oikmKVXXXXbkXFXXSutbFXXX.jpg;01043d5f53c096225173812b4fc0d145:1:2:|https://img.alicdn.com/bao/uploaded/i4/TB1.AEqKVXXXXXoXFXXSutbFXXX.jpg;93d374d45d3524b49e0caa4fb92314c9:2:2:1627207:7080923|https://img.alicdn.com/bao/uploaded/i4/TB146oiKVXXXXXBXVXXSutbFXXX.jpg;66bc2b63115bccd2ad796d9dfcdfc42f:2:1:1627207:28340|https://img.alicdn.com/bao/uploaded/i4/TB1v33iKVXXXXXiXVXXSutbFXXX.jpg;
     * @return array
     */
    private function get_item_pictures_all_info($picture) {
        $pictures = array_filter(explode(';', $picture));
        //取得商品子图数组和商品属性图片数组
        $pictures = array_map(function($pic) {
            $pic_md5 = mb_substr($pic, 0, 32);
            $pic_type = mb_substr($pic, 33, 1);
            $pic_pos = mb_substr($pic, 35);
            $pic_props = mb_substr($pic_pos, mb_strpos($pic_pos, ':') + 1, mb_strpos($pic_pos, '|') - mb_strpos($pic_pos, ':') - 1);
            $pic_pos = mb_substr($pic_pos, 0, mb_strpos($pic_pos, ':'));
            $pic_path = mb_substr($pic, mb_strpos($pic, '|') + 1);
            return array(
                'pic_md5' => $pic_md5,
                'pic_type' => $pic_type,
                'pic_pos' => $pic_pos,
                'pic_props' => $pic_props,
                'pic_path' => $pic_path
            );
        }, $pictures);
        return $pictures;
    }

    /**
     * 根据pic_md5获取图片地址
     * @param type $pic_md5
     * @param type $images
     * @return type
     */
//    private function get_taobao_img_url($pic_md5, $images) {
//        if (!empty($images)) {
//            foreach ($images as $img) {
//                if ($pic_md5 == $img['pic_md5']) return $img['pic_path'];
//            }
//        }
//        return false;
//    }

    /**
     * 热销商品-读取8个随机商品
     * @return array 
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608111321
     */
    public function hot_goods_rand_eight() {
        $_count = \goods::rand_num;
        $_sql = 'SELECT goods_id FROM goods_list '
                . 'WHERE goods_sale = ' . \goods::goods_sale . ' ORDER BY sale_count DESC LIMIT ' . \goods::goods_count_limit;
        $_re_id_arr = $this->query($_sql, array());
        if (empty($_re_id_arr)) return false;
        $_rand_id_arr = array_rand($_re_id_arr, $_count);
        $_str_in_id = '';
        foreach ($_rand_id_arr as $_value) {
            $_str_in_id .='"' . $_re_id_arr[$_value]['goods_id'] . '",';
        }
        $_tmp_str_in_id = substr($_str_in_id, 0, -1); //echo $_tmp_str_in_id;exit;
        $_tem_sql = 'SELECT goods_id,goods_name,img_path FROM goods_list WHERE goods_id IN (' . $_tmp_str_in_id . ')';
        $_data = $this->query($_tem_sql, array());
        $_img_path_sql = 'SELECT tb_path FROM goods_img_path WHERE md5_path=:md5_path';
        foreach ($_data as $_key => $_value) {
            $_img_path_arr = $this->query($_img_path_sql, array('md5_path' => $_value['img_path']), 'fetch_row');
            $_data[$_key]['img_path'] = $_img_path_arr['tb_path'];
        }
        return $_data;
    }

    /**
     * 获取商品详情
     * @param type $goods_id
     * @return type
     */
    public function get_goods_info($goods_id) {
        $field = '`gl`.supplier_id,`gl`.platform,`gl`.goods_id,`gl`.goods_no,`gl`.depot_id,`gl`.goods_name,`gl`.price as distribution_price,'
                . '`gl`.buyer_goods_no,`gl`.goods_category,`gl`.top_category,`g_i_p`.tb_path as img_path,`gl`.top_category';
        $sql = 'select ' . $field . ' from goods_list as `gl` left join goods_img_path as g_i_p on gl.img_path=g_i_p.md5_path where `gl`.goods_id=:goods_id';
        $detail = $this->query($sql, array('goods_id' => $goods_id));
        return $detail;
    }

    /**
     * 修改商品库存信息
     * @param type $goods_id
     * @param type $goods_sku_id
     * @param type $goods_count
     * @return boolean
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function change_goods_stock($goods_id, $goods_sku_id, $goods_count) {
        $_goods_list_data = array(
            'goods_count' => $goods_count,
            'goods_id' => $goods_id
        );
        $_goods_sku_comb_data = array(
            'goods_count' => $goods_count,
            'goods_sku_id' => $goods_sku_id
        );
        $result_1 = $this->update_goods_list($_goods_list_data);
        $result_2 = $this->update_goods_sku_comb($_goods_sku_comb_data);
        if ($result_1 > 0 && $result_2 > 0) {
            return true;
        }
        return false;
    }

    /**
     * 更新goods_sku_comb库存信息
     * @param type $parmeters
     * @return type
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function update_goods_sku_comb($parmeters) {
        $sql = "UPDATE goods_sku_comb SET stock_num = stock_num-:goods_count,sale_count = sale_count+:goods_count WHERE stock_num>=:goods_count AND id = :goods_sku_id";
        $result = $this->excute($sql, $parmeters);
        if ($result <= 0) {
            throw new \Exception('库存更新异常！');
        }
        return $result;
    }

    /**
     * 更新goods_list库存信息
     * @param type $parmeters
     * @return type
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function update_goods_list($parmeters) {
        $sql = "UPDATE goods_list SET stock_num = stock_num-:goods_count,sale_count = sale_count+:goods_count WHERE stock_num>=:goods_count AND goods_id = :goods_id";
        $result = $this->excute($sql, $parmeters);
        if ($result <= 0) {
            throw new \Exception('库存更新异常！');
        }
        return $result;
    }

    public function searchGoods($ids) {          //搜索商品
        $fields = 'goods_id, goods_name, price, collect_count, picture_path as img_path, buyer_goods_no';
        $sql = 'select ' . $fields . ' from goods_list where 1=:none and goods_id in(' . $ids . ') order by field(goods_id, ' . $ids . ')';
        $param = ['none' => 1];
        return $this->query($sql, $param);
    }

    /**
     * 生成csv商品数据包获取商品数据
     * @param type $goods_ids
     * @return type
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    function get_good_data($goods_ids) {
        $data = [];
        $sql = 'select goods_id,goods_value from goods_list_property where goods_id in (' . $goods_ids . ') order by id asc';
        $result = $this->query($sql, array());
        if (count($result) < 1) return array();
        $n = 0;
        foreach ($result as $key => $val) {
            $sql = 'select stock_num,sku_attr from goods_sku_comb where goods_id=:goods_id';
            $result = $this->query($sql, array('goods_id' => $val['goods_id']));
            $stock_num_arr = array_combine(array_column($result, 'sku_attr'), array_column($result, 'stock_num'));
            if (($key % 63 + 1) % 31 == 0 && ($key % 63 + 1) < 32) {//销售属性库存修改
                $return_array = [];
                $_count = preg_match_all('/[\.0-9]*:[0-9]*:[^:]*:([-0-9]+:[-0-9]+;)*/', $val['goods_value'], $return_array);
                $val['goods_value'] = $this->get_good_sku_stock_num($stock_num_arr, $return_array[0]);
            }

            if (($key % 63 + 1) % 10 == 0 && ($key % 63 + 1) < 11) {//宝贝数量修改
                $val['goods_value'] = $this->get_good_stock_num($val['goods_id']);
            }

            if ($key % 63 > 0) {
                $data[$n][] = $val['goods_value'];
            } else {
                $n++;
                if (count($data) == 0) $n = 0;
                $data[$n][] = $val['goods_value'];
            }
        }
        return $data;
    }

    /**
     * 获取宝贝销售属性数量
     * @param type $stock_num_arr
     * @param type $sku_val_arr
     * @return type
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    function get_good_sku_stock_num($stock_num_arr, $sku_val_arr) {
        $result = '';
        foreach ($sku_val_arr as $value) {
            $sku_val = explode(':', $value);
            $sku_str = $sku_val[3] . ':' . $sku_val[4] . ':' . $sku_val[5];
            $sku_val[1] = $stock_num_arr[$sku_str];
            $result .= implode(':', $sku_val);
        }
        return $result;
    }

    /**
     * 获取宝贝数量
     * @param type $goods_id
     * @return array
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    function get_good_stock_num($goods_id) {
        $sql = 'select stock_num from goods_list where goods_id=:goods_id';
        $result = $this->query($sql, array('goods_id' => $goods_id), 'fetch_row');
        return $result['stock_num'];
    }

    /**
     * 生成csv商品数据包获取图片
     * @param type $goods_ids
     * @return type
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    function getImgs($arr) {
        foreach ($arr as $item) {
            $data = [];
            $tmp_img_arr = goodsPicture($item[28]); //解析数据包图片数据
            if (1 > count($tmp_img_arr)) continue;
            $sql = "select upyun_path,tb_path from goods_img_path where md5_path in ('" . implode("','", $tmp_img_arr) . "')";
            $result = $this->query($sql, array());
            if (1 > count($result)) continue;
            foreach ($result as $k => $v) {
                $pic_md5 = basename($v['upyun_path']);
                $data[$pic_md5] = $v['tb_path'];
            }
        }
        return $data;
    }

    /**
     * 组装CSV 数据 并转码为GBK
     * @param $arr
     * @return array|null
     */
    function GetCsvContent($arr) {
        if (true) {
            /** 更新 By aidi 201607227 S */
            $data = array('version 1.00',
                'title$cid$seller_cids$stuff_status$location_state$location_city$item_type$price$auction_increment$num$valid_thru$freight_payer$post_fee$ems_fee$express_fee$has_invoice$has_warranty$approve_status$has_showcase$list_time$description$cateProps$postage_id$has_discount$modified$upload_fail_msg$picture_status$auction_point$picture$video$skuProps$inputPids$inputValues$outer_id$propAlias$auto_fill$num_id$local_cid$navigation_type$user_name$syncStatus$is_lighting_consigment$is_xinpin$foodparame$features$buyareatype$global_stock_type$global_stock_country$sub_stock_type$item_size$item_weight$sell_promise$custom_design_flag$wireless_desc$barcode$sku_barcode$newprepay$subtitle$cpv_memo$input_custom_cpv$qualification$add_qualification$o2o_bind_service',
                '宝贝名称$宝贝类目$店铺类目$新旧程度$省$城市$出售方式$宝贝价格$加价幅度$宝贝数量$有效期$运费承担$平邮$EMS$快递$发票$保修$放入仓库$橱窗推荐$开始时间$宝贝描述$宝贝属性$邮费模版ID$会员打折$修改时间$上传状态$图片状态$返点比例$新图片$视频$销售属性组合$用户输入ID串$用户输入名-值对$商家编码$销售属性别名$代充类型$数字ID$本地ID$宝贝分类$用户名称$宝贝状态$闪电发货$新品$食品专项$尺码库$采购地$库存类型$国家地区$库存计数$物流体积$物流重量$退换货承诺$定制工具$无线详情$商品条形码$sku 条形码$7天退货$宝贝卖点$属性值备注$自定义属性值$商品资质$增加商品资质$关联线下服务');
            //$propsChildDal = new PropsChildDal();
            /** 转码 */
            foreach ($data as $i => $v) {
                $data[$i] = iconv('utf-8', 'gbk', $v);
            }

            foreach ($arr as $key => $val) {
                $str = implode("$", $arr[$key]);
                $str = iconv('utf-8', 'gbk', $str);

                /** 更新 By aidi 201607227 E */
                if (strlen($str) > 0) {
                    $str = substr($str, 0, strlen($str) - 1);
                }

                array_push($data, $str);
            }
            return $data;
        }
        return NULL;
    }

    /*     * 格式化字符串，类似string.format* */

    function format() {
        $args = func_get_args();
        if (count($args) == 0) {
            return;
        }
        if (count($args) == 1) {
            return $args[0];
        }
        $str = array_shift($args);
        $str = preg_replace_callback('/\\{(0|[1-9]\\d*)\\}/', create_function('$match', '$args = ' . var_export($args, true) . '; return isset($args[$match[1]]) ? $args[$match[1]] : $match[0];'), $str);
        return $str;
    }

    /* 检查是否存在文件，存在追加，不存在创建 */

    function mk_dir($dir, $mode = 0755) {
        $ff = dirname($dir);
        if (!file_exists($ff)) {
            mkdir($ff, 0777, true);
        }
        //  file_put_contents($ff . "/test.txt", "This is another something.", FILE_APPEND);
    }

    /* 检查是否存在文件，存在追加，不存在创建 */

    function mk_file($dir, $filename, $mode = 0755) {
        $ff = dirname($dir);
        if (!file_exists($ff)) {
            mkdir($ff, 0777, true);
        }
        file_put_contents($ff . "/" . $filename, "This is another something.", FILE_APPEND);
    }

    /**
     * 增加上传淘宝记录
     * @param type $user_id
     * @param type $user_account
     * @param type $goods_id
     * @param type $goods_name
     * @param type $price
     * @param type $is_success
     * @param type $tb_nick
     * @param type $fail_msg
     * @return type
     */
    public function add_uptaobao_log($user_id, $user_account, $goods_id, $goods_name, $price, $is_success, $tb_nick, $fail_msg = '') {
        $sql = 'insert into fx_uptaobao_good_logs (user_id,goods_id,user_account,goods_name,price,is_success,tb_nick,addtime,fail_msg)'
                . ' value (:user_id,:goods_id,:user_account,:goods_name,:price,:is_success,:tb_nick,:addtime,:fail_msg)';
        return $this->excute($sql, array('user_id' => $user_id, 'goods_id' => $goods_id, 'user_account' => $user_account, 'goods_name' => $goods_name, 'price' => $price,
                    'is_success' => $is_success, 'tb_nick' => $tb_nick, 'addtime' => time(), 'fail_msg' => $fail_msg));
    }

    /**
     * 铺货成功，修改收藏表记录
     * @param type $user_id
     * @param type $goods_id
     */
    public function update_collect_log($user_id, $goods_id) {
        $sql = 'update fx_goods_collect set is_up_taobao=1 where user_id=:user_id and goods_id=:goods_id';
        return $this->excute($sql, array('user_id' => $user_id, 'goods_id' => $goods_id));
    }

}
