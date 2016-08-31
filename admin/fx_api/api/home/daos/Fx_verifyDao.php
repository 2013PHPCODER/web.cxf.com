<?php

namespace api\home;

class Fx_verifyDao extends Dao {
    /*     * 执行自定义增删改语句 */

    public $table = 'fx_verify';

    /**
     * 查询用户一分钟内是否存在验证码
     * @param string $_field 查询字段
     * @return boolean
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608151401
     */
    public function get_verify_code($_field, $_field_data) {
        $_time = time();
        $_verify_again_send = $_time - \Verify::verify_again_send;
        $_target = __ACTION__;
        //限制一分钟内再次发送
        $_sql = 'SELECT COUNT(*) AS count FROM ' . $this->table . ' WHERE target="' . $_target . '" AND status=:status AND ' . $_field
                . '=:field_data AND add_time>=:add_time';
        $_count_arr = $this->query($_sql, array('field_data' => $_field_data,
            'add_time' => $_verify_again_send, 'status' => \Verify::verify_status_1), 'fetch_row');
        if (0 < $_count_arr['count']) return false;

        //符合再次发送条件 记录数据 并返回验证码
        $_code = getRandomNum(6, 'NUMBER');
        $_add_sql = 'INSERT INTO `fx_verify` (`code`, `target`, ' . $_field
                . ', `add_time`) VALUES (:code,:target,:field_data,:add_time)';
        if (!$this->excute($_add_sql, array('code' => $_code, 'target' => $_target,
                    'field_data' => $_field_data, 'add_time' => $_time))) return false;
        return $_code;
    }

    /**
     * 验证验证码
     * @param int $_code 验证码
     * @param string $_field 需要验证的字段，手机或邮箱
     * @param string $_field_data 验证字段数据
     * @return boolean
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608161312
     */
    public function verify_code($_target, $_code, $_field, $_field_data) {
        //验证码次数
        $_time = time();
        $_verfiy_lose_count = \Verify::verify_error_lose_count;
        $_add_time = $_time - \Verify::verify_lose_time;

        //查询符合条件的验证
        $_sql = 'SELECT code,id,wrong_times FROM ' . $this->table . ' WHERE status=:status '
                . 'AND target="' . $_target . '" AND ' . $_field . '=:field_data '
                . 'AND wrong_times <:wrong_times  AND add_time >=:add_time ORDER BY id DESC LIMIT 1';
        $_re_arr = $this->query($_sql, array(
            'field_data' => $_field_data, 'wrong_times' => \Verify::verify_error_lose_count,
            'add_time' => $_add_time, 'status' => \Verify::verify_status_1), 'fetch_row');
        if (empty($_re_arr)) myerror(\StatusCode::msgCheckFail, \Verify::verify_data_null);

        //比对验证码
        if ($_re_arr['code'] != $_code) {
            $_wrong_times_count = $_re_arr['wrong_times'] + 1;
            $_update_worong_times_sql = 'UPDATE `' . $this->table . '` SET '
                    . '`wrong_times`=:wrong_times, `update_time`=:update_time WHERE (`id`=:id)';
            $this->excute($_update_worong_times_sql, array('wrong_times' => $_wrong_times_count, 'update_time' => time(), 'id' => $_re_arr['id']));
            myerror(\StatusCode::msgCheckFail, \Verify::verify_error);
        }

        //验证码验证成功
        $_verfiy_success = 'UPDATE `' . $this->table . '` SET `status`=:status WHERE (`id`=:id)';
        if (!$this->excute($_verfiy_success, array('status' => \Verify::verify_status_0, 'id' => $_re_arr['id']))) return false;
        return true;
    }


    public function getVerifyDetail($target_code, $to, $type){               //获取有效的验证码详情
        $sql='select code, wrong_times, add_time, update_time from fx_verify where target=:target and '. "$type=:to and status=1 order by id desc limit 1";     //此处获得最新一条目的是防止验证码失效失败引起错误
        $param=['target'=>$target_code, 'to'=>$to];
        return $this->query($sql, $param, 'fetch_row');
    }

    public function setStatusExpire($target_code, $to, $type){               //使得验证码过期
        $sql='update fx_verify set status=0 where target=:target and '. "$type=:to";
        $param=['target'=>$target_code, 'to'=>$to];
        return $this->excute($sql, $param);

    }
    public function setWrongtimes($target_code, $to, $type){            //使得验证码错误次数加1
        $sql='update fx_verify set wrong_times=wrong_times+1 where target=:target and '. "$type=:to";
        $param=['target'=>$target_code, 'to'=>$to];
        return $this->excute($sql, $param);
    }


}
