<?php

namespace api\home;

class TestDao extends Dao {

    /** 执行自定义查询语句 * */
    public function query_list($id) {
        $sql = "select test_id from test where test_id=:gid";
        $arr = array("gid" => $id);
        return $this->query($sql, $arr);
    }

    /* 执行自定义增删改语句 */

    public function excute_sql($content) {
        $sql = "insert into test (text) values(i_text)";
        $arr = array("text" => $content);
        return $this->excute($sql, $arr);
    }

}
