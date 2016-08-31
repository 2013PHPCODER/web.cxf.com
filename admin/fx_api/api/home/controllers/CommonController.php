<?php
/***
 * 公共接口
 */
namespace api\home;
class CommonController extends Controller{
    /**
     * 菜单
     * @return string JSON 
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608091706
     */
    public function category(){
        $_goods_category_dao = \Dao::Goods_category();
        $_list = $_goods_category_dao->all_status_1_menu();
        foreach ($_list as $_key=>$_value){
            if(1 == $_value['level']){
                $_level_1[] = $_value;
            }else{
                $_level_2[] = $_value;
            }
        }
        unset($_list);
        foreach ($_level_1 as $_key=>$_value){
            $_tmp_child = array();
            foreach($_level_2 as $_v){
                if($_value['category_id'] == $_v['parent_id']){
                    $_tmp_child[] = array('cid'=>$_v['cid'],'name'=>$_v['name']);
                }
            }
            $_datas[] = array('name'=>$_value['name'],'cid'=>$_value['cid'],'ico'=>$_value['ico'],'child'=>$_tmp_child);
            unset($_tmp_child);
        }
        $this->response($_datas);
    }
    /**
     * 消息中心
     * @param int $_to_client 发布对象(1,web站点 2，开店助理客户端)
     * @param int $_page 翻译页码
     * @return string JSON
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608101539
     */
    public function notice(){
        //echo json_encode(array('to_client'=>1,'page'=>1)); exit;
        //{"to_client":1,"page":1}
        if(!isset($this->request->to_client)) myerror(\StatusCode::msgCheckFail, \Notice::to_client_not_null);
        if(!isset($this->request->page)) myerror(\StatusCode::msgCheckFail, \Notice::page_not_null);
        
        $_notice_dao = \Dao::Fx_notice();
        $_datas = $_notice_dao->notice_list($this->request->to_client,  $this->request->page);
        if(empty($_datas)) {
            $this->response(\Notice::to_client_error);
        }else{
            $this->response($_datas);
        }
    }
    
    /**
     * 帮助文档列表--文章表
     * @param  int $_show_status 在线状态
     * @param int $_show_platforme 发布平台 1web端，2客户端
     * @param int $_page 翻译页码
     * @return string JSON
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608101555
     */
    public function article_list(){
        //echo json_encode(array('show_platform'=>1,'page'=>1)); exit;
        //{"show_platform":1,"page":1}
        if(!isset($this->request->show_platform)) myerror(\StatusCode::msgCheckFail, \Article::show_platform);
        if(!isset($this->request->page)) myerror(\StatusCode::msgCheckFail, \Article::page_not_null);
        
        $_article_dao = \Dao::Fx_article();
        $_datas = $_article_dao->article_list($this->request->show_platform,  $this->request->page);
        if(empty($_datas)){
            $this->response(\Article::show_platform);
        }else{
            $this->response($_datas);
        }
    }
    
    /**
     * 帮助文档详情
     * @param  int $_show_status 在线状态
     * @param int $_show_platforme 发布平台 1web端，2客户端
     * @param int aid 文章ID值
     * @return string JSON
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608101555
     */
    public function article_details(){
        //echo json_encode(array('show_platform'=>1,'aid'=>1)); exit;
        //{"show_platform":1,"aid":1}
//        \Valid::has_number($this->request->show_platform)->withError(\Article::show_platform);
//        \Valid::has_number($this->request->show_platform)->withError(\Article::article_id_null);
        if(!isset($this->request->show_platform)) myerror(\StatusCode::msgCheckFail, \Article::show_platform);
        if(!isset($this->request->aid)) myerror(\StatusCode::msgCheckFail, \Article::article_id_null);
        
        $_article_dao = \Dao::Fx_article();
        $_datas = $_article_dao->article_details($this->request->show_platform,  $this->request->aid);
        if(empty($_datas)){
            $this->response(\Article::show_platform);
        }else{
            $this->response($_datas);
        }
    }
}

