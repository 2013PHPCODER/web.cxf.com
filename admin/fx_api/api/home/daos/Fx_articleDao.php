<?php
namespace api\home;

class Fx_articleDao extends Dao {
    /*     * 执行自定义增删改语句 */
    public $table = 'fx_article';
    /**
     * 帮助文档列表--文章表
     * @param  int $_show_status 在线状态
     * @param int $_show_platforme 发布平台 1web端，2客户端
     * @param int $_page 翻译页码
     * @return string JSON
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608101555
     */
    public function article_list($_show_platform=1,$_page=1){
        $fx_article = \MODEL::Fx_article();  
        $fx_article->show_platform=$_show_platform;
        $fx_article->show_status=\Article::up_status;
        $result= $this->getList($fx_article, array("id","title"),$_page);
        return $result;
    }
    
    /**
     * 帮助文档详情--文章表
     * @param  int $_show_status 在线状态
     * @param int $_show_platforme 发布平台 1web端，2客户端
     * @param int $_aid 文章ID值
     * @return string JSON
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608101555
     */
    public function article_details($_show_platform=1,$_id){
        $_sql = 'SELECT addtime,content,title FROM '.$this->table.' WHERE id=:id AND show_status='.\Article::up_status.' AND show_platform =:show_platform';
        $_where = array('show_platform'=>$_show_platform,'id'=>$_id);
        return $this->query($_sql, $_where,'fetch_row');    
    }
}
