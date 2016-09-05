<?php

namespace api\home;

class Fx_tb_userDao extends Dao {
    /*     * 执行自定义增删改语句 */

    public $table = 'fx_tb_user';

    /**
     * 查询用户淘宝key
     * @param type $tb_user_id
     */
    public function get_taobao_access_token($tb_user_id) {
        $sql = 'select access_token from fx_tb_user where tb_user_id=:tb_user_id order by `default` desc limit 1';
        $token = $this->query($sql, array('tb_user_id' => $tb_user_id), 'fetch_row');
        if (empty($token)) {
            myerror(\StatusCode::msgFailStatus, '错误的用户信息！');
        }
        return $token['access_token'];
    }

    /**
     * 查询用户淘宝信息
     * @param type $user_id
     */
    public function get_taobao_user_info($user_id, $shop_id) {
        $sql = 'select nick,access_token,addtime,expire_time,updatetime from fx_tb_user where userid=:u_id and tb_user_id=:shop_id order by `default` desc limit 1';
        $token = $this->query($sql, array('u_id' => $user_id, 'shop_id' => $shop_id),'fetch_row');
        if (empty($token)) {
            myerror(\StatusCode::msgFailStatus, '错误的用户信息！');
        }
        if (empty($token['access_token'])) {
            myerror(\StatusCode::msgFailStatus, '店铺未授权，请授权！');
        }
        if ((strtotime($token['addtime']) + $token['expire_time'] / 1000) < time() && (strtotime($token['updatetime']) + $token['expire_time'] / 1000) < time()) {
            myerror(\StatusCode::msgFailStatus, '店铺授权过期，请重新授权！');
        }
        return $token;
    }

    /**
     * 获取淘宝店铺列表
     * @param type $user_id
     * @return type
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function getShopList($user_id) {
        $sql_count = "select tb_user_id,nick,access_token,expire_time,addtime from fx_tb_user "
                . "where userid=:userid";
        $result = $this->query($sql_count, array("userid" => $user_id));
        return $result;
    }

    /**
     * 写入或更新淘宝用户数据--对应淘宝第三方登录接口返回数据
     * @param array $_tb_data_arr 淘宝返回JSON数据
     * @return boolean 
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608131614
     */
    public function user_data_operation($_tb_data_arr, $_custom_uid) {
        //$_query_sql = 'SELECT COUNT(*) AS count FROM ' . $this->table . ' WHERE tb_user_id=:tb_user_id';
        $_query_sql = 'SELECT COUNT(*) AS count FROM ' . $this->table . ' WHERE userid=:userid';
        //$_user_count_arr = $this->query($_query_sql, array('tb_user_id' => $_tb_data_arr['taobao_user_id']), 'fetch_row');
        $_user_count_arr = $this->query($_query_sql, array('userid' => $_custom_uid), 'fetch_row');
        $_tmp_data['tb_user_id'] = $_tb_data_arr['taobao_user_id'];
        $_tmp_data['nick'] = urldecode($_tb_data_arr['taobao_user_nick']);
        $_tmp_data['access_token'] = $_tb_data_arr['access_token'];
        $_tmp_data['refresh_token'] = $_tb_data_arr['refresh_token'];
        $_tmp_data['expire_time'] = $_tb_data_arr['expire_time'];
        $_tmp_data['refresh_token_valid_time'] = $_tb_data_arr['refresh_token_valid_time'];
        $_tmp_data['addtime'] = date('Y-m-d H:i;s', time());
        $_tmp_data['userid'] = $_custom_uid;
        if (\TbUser::tb_user_data_binding <= $_user_count_arr['count']) return false; //用户只能绑定五个店铺

        if (0 < $_user_count_arr['count']) {
            $_update_sql = 'UPDATE ' . $this->table . ' SET `tb_user_id`=:tb_user_id,'
                    . '`nick`=:nick,`access_token`=:access_token,`refresh_token`=:refresh_token,'
                    . '`expire_time`=:expire_time,`refresh_token_valid_time`=:refresh_token_valid_time,'
                    . '`updatetime`=:addtime WHERE (`userid`=:userid)';
            if (!$this->excute($_update_sql, $_tmp_data)) return false;
        }else {
            $_insert_sql = 'INSERT INTO ' . $this->table . ' (`userid`,`tb_user_id`,`nick`,'
                    . ' `access_token`,`refresh_token`,`expire_time`,`refresh_token_valid_time`'
                    . ',`addtime`,default) VALUES (:userid,:tb_user_id,:nick,:access_token,'
                    . ':refresh_token,:expire_time,:refresh_token_valid_time,:addtime,1)';
            if (!$this->excute($_insert_sql, $_tmp_data)) return false;
        }
        return true;
    }

    /**
     * 根据商家编码查询商品销售数量
     * @param type $outer_no
     */
    public function goods_sell_count($outer_no) {
        $sql = 'SELECT SUM(og.goods_num) as `num`,gl.price,goods_sale FROM  goods_list as `gl` LEFT JOIN `order_goods` as og on og.buyer_goods_no=gl.buyer_goods_no WHERE gl.buyer_goods_no=:outer_no limit 1';
        $num = $this->query($sql, array('outer_no' => $outer_no), 'fetch_row');
        $count = $num['num'] ? $num['num'] : 0;
        $price = $num['price'] ? $num['price'] : 0;
        $goods_sale = $num['goods_sale'] ? $num['goods_sale'] : 2;
        return array('num' => $count, 'price' => $price, 'goods_sale' => $goods_sale);
    }

}
