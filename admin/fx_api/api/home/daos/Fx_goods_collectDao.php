<?php

namespace api\home;

class Fx_goods_collectDao extends Dao {

    /**
     * 加减商品列表各商品收藏次数
     * @param type $goods_id 收藏商品id
     * @param type $oper 添加或减少收藏商品
     */
    public function changeCollectCount($goods_id, $oper) {
        if (is_array($goods_id)) {
            $gids = implode(',', $goods_id);
            $sql = "UPDATE goods_list SET collect_count=collect_count+:oper WHERE goods_id in ({$gids})";
            $arr = array('oper' => $oper);
        } else {
            $sql = 'UPDATE goods_list SET collect_count=collect_count+:oper WHERE goods_id=:gid';
            $arr = array('oper' => $oper, 'gid' => $goods_id);
        }

        return $this->excute($sql, $arr);
    }

    /**
     * 获取收藏夹列表
     * @param type $user_id
     * @param type $page
     * @param type $pagesize 每页显示数据量
     * @param type $is_up_taobao 是否上传到淘宝（是否铺货）
     * @return string
     * 
     */
    public function getCollectList($user_id, $page, $pagesize, $is_up_taobao = '') {
        $field = '`a`.addtime,`a`.is_up_taobao,`a`.goods_id,`g`.goods_name,`g`.stock_num as total_stock_num,`g`.buyer_goods_no,`g`.img_path,`g`.price';
        //数据条数
        //统计数据条数sql
        if (!empty($is_up_taobao)) {
            $countsql = 'SELECT COUNT(*) FROM fx_goods_collect a INNER JOIN goods_list g ON a.goods_id=g.goods_id WHERE `a`.user_id=:uid AND `a`.is_up_taobao=:tb';
            $arr = array("uid" => $user_id, 'tb' => $is_up_taobao);
        } else {
            $countsql = 'SELECT COUNT(*) FROM fx_goods_collect a INNER JOIN goods_list g ON a.goods_id=g.goods_id WHERE `a`.user_id=:uid';
            $arr = array("uid" => $user_id);
        }
        $countarr = $this->query($countsql, $arr);
        $count = $countarr[0]['COUNT(*)'];
        //  总页数
        $totalpage = ceil($count / $pagesize);
        //  当前页所在起始位置
        $start = ($page - 1) * $pagesize;
        if (!empty($is_up_taobao)) {
            $sql = 'SELECT ' . $field . ' FROM fx_goods_collect a INNER JOIN goods_list g ON a.goods_id=g.goods_id WHERE `a`.user_id=:uid AND `a`.is_up_taobao=:tb LIMIT ' . $start . ',' . $pagesize;
        } else {
            $sql = 'SELECT ' . $field . ' FROM fx_goods_collect a INNER JOIN goods_list g ON a.goods_id=g.goods_id WHERE `a`.user_id=:uid LIMIT ' . $start . ',' . $pagesize;
        }
        $list = $this->query($sql, $arr);
        if (empty($list)) {
            return NULL;
        }
        //计算不同版本价格
        foreach ($list as $k => $v) {
            $list[$k]['price'] = change_price($v['price']);
        }
        //获取淘宝上面的主图图片路径
        foreach ($list as $k => &$v) {
            $v['img_path'] = $this->getMainImg($v['img_path']);
        }
        $goods_id_arr = array_unique(array_column($list, 'goods_id'));
        $gids = implode(',', $goods_id_arr);
        $sqlr = "SELECT goods_id,sku_str_zh,stock_num FROM goods_sku_comb WHERE  1=:placeholder and goods_id in ({$gids})";
        $param = ['placeholder' => 1];
        $skuarr = $this->query($sqlr, $param);
        foreach ($list as &$list_value) {
            foreach ($skuarr as $sku) {
                if ($sku['goods_id'] == $list_value['goods_id']) {
                    $list_value['sku'][] = $sku;
                }
            }
        }
        $info['item'] = $list;
        $info['page'] = $page;
        $info['per_page'] = $pagesize;
        $info['total'] = $count;
        return $info;
    }

    /**
     * 删除收藏
     * @param type $user_id
     * @param type $goods_id
     * @return int
     */
    public function delCollect($user_id, $goods_id) {
//        var_dump($goods_id);die;
        if (is_array($goods_id)) {
            $gids = implode(',', $goods_id);
            $sql = "delete from fx_goods_collect where user_id= :user_id and goods_id in ({$gids})";
            $arr = array('user_id' => $user_id);
        } else {
            $sql = 'delete from fx_goods_collect where user_id= :user_id and goods_id= :goods_id';
            $arr = array('user_id' => $user_id, 'goods_id' => $goods_id);
        }

        $result = $this->excute($sql, $arr);
//        var_dump($result);die;
//        var_dump(\Sql::get());
        //减去商品列表中该收藏商品次数
        if (is_numeric($result) && 0 !== $result) {
            $this->changeCollectCount($goods_id, -1);
        }
        return $result;
    }

    /**
     * 获取淘宝上面主图
     * @param type 
     * @return int
     */
    public function getMainImg($img) {
        $sql = 'SELECT tb_path FROM goods_img_path WHERE md5_path=:img';
        $arr = array('img' => $img);
        $pathArr = $this->query($sql, $arr);
        if(empty($pathArr)) return false;
        return $pathArr[0]['tb_path'];
    }

    public function check_collect($user_id, $goods_id) {
        $sql = 'select id from fx_goods_collect where user_id=:user_id and goods_id=:goods_id';
        $id = $this->query($sql, array('user_id' => $user_id, 'goods_id' => $goods_id), 'fetch_row');
        if ($id['id']) {
            return true;
        }
        return false;
    }

}
