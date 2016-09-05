<?php

namespace api\home;

class Fx_statementDao extends Dao {
    /*     * 执行自定义增删改语句 */

    public $table = 'fx_statement';

    /**
     * 资金明细
     * @param int $_trade_type 交易 类型
     * @param int $_start_time 开始时间
     * @param int $_end_time 结束时间
     * @param string $_trade_no 订单号
     * @param int $_page 分页
     * @param int $_user_id 分销商ID
     * @param string $_user_name 用户名
     * @return array 
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608112018
     */
    public function statement_list($_user_id, $_user_name, $_trade_type = '', $_start_time = '', $_end_time = '', $_trade_no = '', $_page = 1) {
        $_where_str = '';
        if (!empty($_trade_type)) {
            $_where_str .= ' AND trade_type=:trade_type';
            $_where_arr['trade_type'] = $_trade_type;
        }  else {
            $_where_str .= ' AND trade_type in (1,2,3,5)';
        }
        if (!empty($_trade_no)) {
            $_where_str .= ' AND trade_no=:trade_no';
            $_where_arr['trade_no'] = $_trade_no;
        }
        if (!empty($_start_time) && !empty($_end_time)) {
            $_tmp_start_time = strtotime($_start_time);
            $_tmp_end_time = strtotime($_end_time);
            $_where_str .= ' AND (add_time BETWEEN :start_time AND :end_time)';
            $_where_arr['start_time'] = $_tmp_start_time;
            $_where_arr['end_time'] = $_tmp_end_time;
        } else if (empty($_start_time) && !empty($_end_time)) {
            $_tmp_end_time = strtotime($_end_time) + 86400;
            $_where_str .= ' AND (add_time BETWEEN :start_time AND :end_time)';
            $_where_arr['start_time'] = 0;
            $_where_arr['end_time'] = $_tmp_end_time;
        } else if (!empty($_start_time) && empty($_end_time)) {
            $_tmp_start_time = strtotime($_start_time);
            $_tmp_end_time = time();
            $_where_str .= ' AND (add_time BETWEEN :start_time AND :end_time)';
            $_where_arr['start_time'] = $_tmp_start_time;
            $_where_arr['end_time'] = $_tmp_end_time;
        }
        $_where_arr['user_name'] = $_user_name;
        $_where_arr['user_id'] = $_user_id;
        $_where_arr['user_type'] = 2;
        $_count_sql = 'SELECT count(*) AS count FROM '
                . $this->table . ' WHERE user_id=:user_id AND user_name=:user_name AND user_type=:user_type ' . $_where_str;
        $_count = $this->query($_count_sql, $_where_arr, 'fetch_row');
        $_page_num = \Config('page_num');
        $_tmp_page = ($_page - 1) * $_page_num;
        $_tmp_page = $_tmp_page . ',' . $_page_num;
        $_sql = 'SELECT add_time,trade_type,trade_no,out_money,in_money,now_balance,trade_account_type, trade_account,remark FROM '
                . $this->table . ' WHERE user_id=:user_id AND user_name=:user_name AND user_type=:user_type ' . $_where_str . ' ORDER BY add_time DESC LIMIT ' . $_tmp_page;
        $_datas = $this->query($_sql, $_where_arr);
//        print_r(\Sql::get());
//        die;
        $_tmp_arr = '';
        if (!empty($_datas)) {
            foreach ($_datas as $_key => $_value) {
                $_datas[$_key]['trade_type_str'] = '';
                switch ($_value['trade_type']) {
                    case 1:
                        $_datas[$_key]['trade_type_str'] = '余额提现';
                        break;
                    case 2:
                        $_datas[$_key]['trade_type_str'] = '余额补款';
                        break;
                    case 3:
                        $_datas[$_key]['trade_type_str'] = '售后退款';
                        break;
                    case 4:
                        $_datas[$_key]['trade_type_str'] = '供货商完结订单';
                        break;
                    case 5:
                        $_datas[$_key]['trade_type_str'] = '订单付款';
                        break;
                    case 6:
                        $_datas[$_key]['trade_type_str'] = '分销商充值';
                        break;
                    case 7:
                        $_datas[$_key]['trade_type_str'] = '供货商补款';
                        break;
                    default:
                        break;
                }
                $_datas[$_key]['add_time'] = date('Y-m-d H:i:s', $_value['add_time']);
            }
        } else {
            $_datas = array();
        }
        $_tmp_arr['pageIndex'] = $_page;
        $_allPage = ceil($_count['count'] / $_page_num); //总的分页条数
        $_tmp_arr['rows'] = $_count['count'];
        $_tmp_arr['allPage'] = $_allPage;
        $_tmp_arr['list'] = $_datas;
        return $_tmp_arr;
    }

}
