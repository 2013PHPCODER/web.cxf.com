<?php

/*
 * 文章管理Model
 * @author  shenlang
 */

namespace System\Model;

use Think\Model;

class FxArticleModel extends Model {

    /**
     * 获取选择项:非上线排序
     * @author  shenlang
     * @return array
     */
    public function getAdduser() {
        $arr = M('fx_admin_user')->field('name')->select();
        foreach ($arr as $k => $v) {
            $adduser[$k] = $v['name'];
        }
        return $adduser;
    }

    /**
     * 获取选择项非上线排序
     * @author  shenlang
     * @return array
     */
    public function getNewsOrder() {
        $arr = $this->field('show_order')->where(array('show_status' => 2))->select();
        foreach ($arr as $k => $v) {
            $data[$k] = $v['show_order'];
        }
        $newArr = array_unique($data);
        return $newArr;
    }

    /**
     * 获取文章列表
     * @param type $_where
     * @return type
     * 
     */
    public function getNewsList($_where) {
        $_count = $this->where($_where)->count('id');
        $_page = getpage($_count);
        $field = "id,title,adduser,show_platform,addtime,show_status,show_order";
        $arr = $this->field($field)
                ->where($_where)
                ->order('id desc')
                ->limit($_page->firstRow . ',' . $_page->listRows)
//                ->fetchSql(true)
                ->select();
//        var_dump($arr);die;
        //  转换显示 发布平台 1web端，2客户端
        foreach ($arr as $k => &$v) {
            if (1 == $v['show_platform']) {
                $v['show_platform'] = "Web端";
            } elseif (2 == $v['show_platform']) {
                $v['show_platform'] = "客户端";
            }
        }
        $_data['list'] = $arr;
        $_data['page'] = $_page->show();
        return $_data;
    }

    /**
     * 获取预览信息
     * @param type $_id 主键ID
     * @return type array
     */
    public function getNewsPreview($_id) {
        return $this->field('title,content')->where('id=' . $_id)->find();
    }

    /**
     * 文章下线
     * @param type $_id 主键id
     * 
     */
    public function changeStauts($_id) {
        $data['show_status'] = 2;
        $result = $this->where(array('id' => $_id))->save($data);
//        $this->execute("update fx_article set show_status={$new_status} where id={$_id}");
        if (false !== $result || 0 !== $result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取要更新的原文章信息
     * @param type $_id 主键ID
     * @return type array
     */
    public function getEditNews($_id) {
        return $this->field('title,content')->where(array('id' => $_id))->find();
    }

    /**
     * 更新文章信息
     * @param type $msg 文章信息:id主键ID  title标题 content内容 show_platform发布平台 show_order排序
     * @return type array
     */
    public function msgUpdate($data) {
        $result = $this->filter('strip_tags')->save($data);
        if (false !== $result || 0 !== $result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 添加文章
     * @param type $newsArr
     * 
     */
    public function newsAdd($newsArr) {
        $result = $this->data($newsArr)->add();
        if (false !== $result || 0 !== $result) {
            return true;
        } else {
            return false;
        }
    }

}
