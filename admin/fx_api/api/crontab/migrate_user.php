<?php
/**
 * 用户数据迁移脚本
 * @author ximeng <1052214395@qq.com> <http://xinzou.cn>
 * @since 20160829
 */
require_once 'core/init.php';
$fx_db = get_fxDB();
$kd_db = get_kdDB();
echo "migrate begin\n";
while (true) {
    $param = [];
    $kd_db->executeMySQL('select * from m_user_info where is_migrate=0 limit 1', $param);
    $m_user_info = $kd_db->rowFetch();
    if (!$m_user_info) break;
    $kd_db->executeMySQL('select * from m_user_token where userid=?', [$m_user_info['userid']]);
    $m_user_token = $kd_db->rowFetch();
    $kd_db->executeMySQL('select * from f_stock where userid=?', [$m_user_info['userid']]);
    $f_stock = $kd_db->rowFetch();
    $insert_param = array(
        $m_user_info['email'],
        $m_user_token['password'],
        2,
        2,
        1,
        date('Y-m-d h:i:s', time()),
        date('Y-m-d h:i:s', time()),
        time(),
        $m_user_info['nickname'],
        0,
        0,
        $m_user_info['province'],
        $m_user_info['city'],
        $m_user_info['district'],
        $m_user_info['idcard_area'],
        $m_user_info['mobile'],
        $m_user_info['mobile'],
        $m_user_info['email'],
        $m_user_info['qq'],
        $m_user_info['wangwang'],
        1,//用户来源
        $m_user_info['idcard'],
        $m_user_info['truename'],
        $f_stock['balance'],
        0,
        $m_user_token['safepass']
    );
    $insert_sql = "INSERT INTO `fx_distribute_user` (`user_account`, `userpwd`, `reg_type`, `account_status`, `leavel`, `addtime`, `lastupdatetime`, `last_login_time`, `usernick`, `sex`, `age`,
        `province`, `city`, `area`, `address`, `mobile`, `phone`, `email`, `qq`, `wangwang`, `source`, `idcard`, `realname`, `balance`, `parent_id`, `pay_pwd`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $fx_db->executeMySQL($insert_sql, $insert_param);
    if (0 < $fx_db->isInserted()) {
        $kd_db->executeMySQL("update m_user_info set is_migrate=1 where userid=?", [$m_user_info['userid']]);
        echo "\n{$m_user_info['email']}--------->migrate success!----------time=".time();
        continue;
    }
    echo "\n{$m_user_info['email']}--------->migrate fail!----------time=".time();
}
echo "\nok!migrate finish----------time=".time();
