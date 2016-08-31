<?php
namespace System\Controller;
use Common\Controller\AuthController as Auth;
/**
 * 页面管理
 * @author san shui <2881501985@qq.com>
 * @since 201608041312
 */
class PageManageController extends Auth {
    /**
     * 文章列表[默认进入]
     * @author shenlang
     * @return array $_datas
     */
    public function index() {
        $ob = new \System\Model\FxArticleModel();
        //  获取发布者
        $adduser = $ob->getAdduser();
        $this->assign('adduser', $adduser);
        //  获取非上线排序信息
        $show_order = $ob->getNewsOrder();
        $this->assign('show_order', $show_order);
        //  组装搜索条件
        $_where = $this->newsSearchWhere();
        //  获取文章列表
        $this->datas = $ob->getNewsList($_where);
        $this->display('news');
    }

    /**
     * 预览文章信息操作
     * @author shenlang
     */
    public function newsPreview() {
        $_id = I('post.id');
        $ob = new \System\Model\FxArticleModel();
        $msg = $ob->getNewsPreview($_id);
        $this->ajaxReturn($msg);
    }

    /**
     * 文章下线操作
     * @author shenlang
     *  
     */
    public function changeStatus() {
        $id = I("post.id");
        $ob = new \System\Model\FxArticleModel();
        $re = $ob->changeStauts($id);
        if ($re) {
            $this->ajaxReturn("下线成功");
        } else {
            $this->ajaxReturn("操作失败");
        }
    }

    /**
     * 编辑获取要更新的文章原信息
     * @author shenlang
     */
    public function editNews() {
        $id = I("post.id");
        $ob = new \System\Model\FxArticleModel();
        $arr = $ob->getEditNews($id);
        //  获取非上线排序
        $arr['show_order'] = $ob->getNewsOrder();
        $this->ajaxReturn($arr);
    }

    /**
     * 编辑更新文章信息
     * @author shenlang
     */
    public function newsUpdate() {
        $data['title'] = I("post.title");
        $data['content'] = I("post.content");
        $data['show_platform'] = I("post.platform");
        $data['show_order'] = I("post.order");
        $data['id'] = I("post.id");
        $data['addtime'] = date("Y-m-d H-i-s", time());
        //  如果发布为原平台，不更新平台信息
        if (-1 == $data['show_platform']) {
            unset($data['show_platform']);
        }
        //  如果发布为原排序，不更新原排序信息
        if (-1 == $data['show_order']) {
            unset($data['show_order']);
        }
        $data['adduser'] = session('user.name');
        $data['show_status'] = 1;
//        var_dump($data);die;
        $ob = new \System\Model\FxArticleModel();
        $re = $ob->msgUpdate($data);
        if ($re) {
            $this->ajaxReturn("更新成功");
        } else {
            $this->ajaxReturn("操作失败");
        }
    }

    /**
     * 添加文章公告
     * @author shenlang
     */
    public function newsAdd() {
        $data['title'] = I("post.title");
        $data['content'] = I("post.content");
        $data['show_platform'] = I("post.platform");
        $data['show_order'] = I("post.order");
        $data['adduser'] = session('user.name');
        $data['addtime'] = date("Y-m-d H-i-s", time());
//        var_dump($data);die;
        $ob = new \System\Model\FxArticleModel();
        $re = $ob->newsAdd($data);
        if ($re) {
            $this->ajaxReturn("添加成功");
        } else {
            $this->ajaxReturn("操作失败");
        }
    }

    /**
     * 组装搜索时间条件
     * @author shenlang
     * @param type $_time
     * @return array
     */
    public function timeSearch($_time) {
        // 选择时间
        switch ($_time) {
            case 1:
                $startTime = date("Y-m-d 00:00:00", time());
                $endTime = date("Y-m-d 23:59:59", time());
                $_get['addtime'] = array('between', array($startTime, $endTime));
                break;
            case 2:
                $startTime = date("Y-m-d 00:00:00", strtotime('-7 day'));
                $endTime = date("Y-m-d 23:59:59", time());
                $_get['addtime'] = array('between', array($startTime, $endTime));
                break;
            case 3:
                $startTime = date("Y-m-d 00:00:00", strtotime('-30 day'));
                $endTime = date("Y-m-d 23:59:59", time());
                $_get['addtime'] = array('between', array($startTime, $endTime));
                break;
            default:
                break;
        }
        return $_get['addtime'];
    }

    /*
     * 组装文章搜索条件
     * @author shenlang
     * @return $_get 搜索条件
     */

    public function newsSearchWhere() {

        // 发布的管理员
        $adduser = I('get.adduser', '');
        if (!empty($adduser)) {
            $_get['adduser'] = $adduser;
        }
        // 发布平台
        $show_platform = I('get.show_platform', '');
        if (!empty($show_platform)) {
            $_get['show_platform'] = $show_platform;
        }
        // 排序
        $show_order = I('get.show_order', '');
        if (!empty($show_order)) {
            $_get['show_order'] = $show_order;
        }
        // 选择时间
        $_time = I('get.time');
        if ($_time) {
            $_get['addtime'] = $this->timeSearch($_time);
        }
        //自定义时间
        $startTime = I('get.startTime', '');
        $endTime = I('get.endTime', '');
        if (!empty($startTime) && !empty($endTime)) {
            $_get['addtime'] = array('between', array("$startTime", "$endTime"));
        }
        return $_get;
    }

    /**
     * 敏感词列表
     * @author san shui <2881501985@qq.com>
     * @since 201608041312
     * @return array $_datas
     */
    public function sensitive() {
        $_admin = I('get.admin/d');
        $_type = I('get.type');
        $_grade = I('get.grade');
        $_sensitive = I('get.sensitive');
        if(!empty($_sensitive)) $_where['sensitive'] = array('like',"%{$_sensitive}%");
        if (0 < $_admin) $_where['admin'] = $_admin;
        if (!empty($_type)) $_where['type'] = $_type;
        if (0 < $_grade) $_where['grade'] = $_grade;
        
        $_fx_sensitive_list_model = M('fx_sensitive_list');
        $_count = $_fx_sensitive_list_model
                        ->join('fx_admin_user ON fx_sensitive_list.admin = fx_admin_user.admin_user_id')
                        ->field('fx_admin_user.name,fx_sensitive_list.*')
                        ->where($_where)->count();
        $_page = getpage($_count);
        $this->pager = $_page->show();

        $this->datas = $_fx_sensitive_list_model
                        ->join('fx_admin_user ON fx_sensitive_list.admin = fx_admin_user.admin_user_id')
                        ->field('fx_admin_user.name,fx_sensitive_list.*')
                        ->limit($_page->firstRow . ',' . $_page->listRows)
                        ->where($_where)->order('datetime DESC')->select();

        $this->admin = M('fx_admin_user')->field('name,admin_user_id')->select();
        $this->display();
    }

    /**
     * 添加敏感词
     * @author san shui <2881501985@qq.com>
     * @since 201608041312
     * @return boolean
     */
    public function addSensitive() {
        if (IS_POST) {
            $_fx_sensitive_list_model = D('fx_sensitive_list');
            if ($_fx_sensitive_list_model->create()) {
                if ($_fx_sensitive_list_model->add()) {
                    $this->success(L('ADD_SUCCESS'), 'sensitive');
                } else {
                    $this->error(L('ADD_FAILURE'));
                }
            } else {
                $this->error($_fx_sensitive_list_model->getError());
            }
        } else {
            $this->display();
        }
    }

    /**
     * 修改敏感词
     * @author san shui <2881501985@qq.com>
     * @since 201608041312
     * @return boolean
     */
    public function editSensitive() {
        $_id = I('id');
        $_fx_sensitive_list_model = D('fx_sensitive_list');
        if (IS_POST) {
            if ($_fx_sensitive_list_model->create()) {
                if ($_fx_sensitive_list_model->where(array('id' => $_id))->save() !== FALSE) {
                    $this->success(L('UPDATE_SUCCESS'), 'sensitive');
                } else {
                    $this->error(L('UPDATE_FAILURE'));
                }
            } else {
                $this->error($_fx_sensitive_list_model->getError());
            }
        } else {
            $this->list = $_fx_sensitive_list_model->where(array('id' => $_id))->field('id,sensitive,status')->find();
            $this->display();
        }
    }

    /**
     * 删除敏感词
     * @author san shui <2881501985@qq.com>
     * @since 201608041312
     * @return boolean
     */
    public function delSensitive() {
        $_id = I('id');
        if (IS_POST && !empty($_id)) {
            $_fx_sensitive_list_model = M('fx_sensitive_list');
            if ($_fx_sensitive_list_model->where(array('id' => $_id))->delete() !== FALSE) {
                $this->success(L('DELETE_SUCCESS'));
            } else {
                $this->error(L('DELETE_FAILURE'));
            }
        } else {
            $this->error(L('_PARAM_FAILURE_'));
        }
    }

    /**
     * 客服账号列表
     * @author san shui <2881501985@qq.com>
     * @since 201608041312
     * @return array $_datas
     */
    public function service() {
        $_admin = I('get.admin/d');
        $_type = I('get.type');
        $_status = I('get.status');
        //var_dump($_status);exit;
        if (0 < $_admin) {
            $_where['admin'] = $_admin;
        }
        if (!empty($_type)) {
            $_where['type'] = $_type;
        }
        if (!empty($_status)) {
            $_where['fx_customer_service.status'] = $_status;
        }
        $_fx_customer_service_model = M('fx_customer_service');
        $_count = $_fx_customer_service_model
                        ->join('fx_admin_user ON fx_customer_service.admin = fx_admin_user.admin_user_id')
                        ->field('fx_admin_user.name,fx_customer_service.*')
                        ->where($_where)->count();
        $_page = getpage($_count);
        $this->pager = $_page->show();

        $this->datas = $_fx_customer_service_model
                        ->join('fx_admin_user ON fx_customer_service.admin = fx_admin_user.admin_user_id')
                        ->field('fx_admin_user.name,fx_customer_service.*')
                        ->limit($_page->firstRow . ',' . $_page->listRows)
                        ->where($_where)->order('datetime DESC')->select();

        $this->admin = M('fx_admin_user')->field('name,admin_user_id')->select();
        $this->display();
    }

    /**
     * 客服账号列表
     * @author san shui <2881501985@qq.com>
     * @since 201608041312
     * @return array $_datas
     */
    public function addService() {
        if (IS_POST) {
            $_fx_customer_service_model = D('fx_customer_service');
            if ($_fx_customer_service_model->create()) {
                if ($_fx_customer_service_model->add()) {
                    $this->log(L('ADD_SUCCESS'));//添加日志
                    $this->success(L('ADD_SUCCESS'), 'service');
                } else {
                    $this->error(L('ADD_FAILURE'));
                }
            } else {
                $this->error($_fx_customer_service_model->getError());
            }
        } else {
            $this->display();
        }
    }

    /**
     * 客服账号列表
     * @author san shui <2881501985@qq.com>
     * @since 201608041312
     * @return array $_datas
     */
    public function editService() {
        $_id = I('id');
        $_fx_customer_service_model = D('fx_customer_service');
        if (IS_POST) {
            if ($_fx_customer_service_model->create()) {
                if ($_fx_customer_service_model->where(array('id' => $_id))->save() !== FALSE) {
                    $this->log(L('UPDATE_SUCCESS'));//添加日志
                    $this->success(L('UPDATE_SUCCESS'), 'service');
                } else {
                    $this->error(L('UPDATE_FAILURE'));
                }
            } else {
                $this->error($_fx_customer_service_model->getError());
            }
        } else {
            $this->list = $_fx_customer_service_model->where(array('id' => $_id))->field('id,qq,type,status')->find();
            $this->display();
        }
    }

    /**
     * 客服账号列表
     * @author san shui <2881501985@qq.com>
     * @since 201608041312
     * @return array $_datas
     */
    public function delService() {
        $_id = I('id');
        if (IS_POST && !empty($_id)) {
            $_fx_customer_service_model = M('fx_customer_service');
            if ($_fx_customer_service_model->where(array('id' => $_id))->delete() !== FALSE) {
                $this->success(L('DELETE_SUCCESS'));
            } else {
                $this->error(L('DELETE_FAILURE'));
            }
        } else {
            $this->error(L('_PARAM_FAILURE_'));
        }
    }

}
