<?php
namespace api\home;

class Fx_noticeDao extends Dao {
    /*     * 执行自定义增删改语句 */
    public $table = 'fx_notice';
    /**
     * 消息中心
     * @param int $_to_client 发布对象(1,web站点 2，开店助理客户端)
     * @param int $_page 翻译页码
     * @return array
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608101539
     */
    public function notice_list($_to_client=1,$_page=1){
        $fx_article = \MODEL::Fx_notice();  
        $fx_article->to_client=$_to_client;
        return $this->getList($fx_article, array('title','content','addtime'),$_page);
    }
    
    /**
     * 首页公告-取六条，倒叙
     * @param int $_to_clien 发布对象(1,web站点 2，开店助理客户端)
     * @return array
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608111300
     */
    public function notice_index($_to_client=1){
        $_sql = 'SELECT id,title,addtime FROM '.$this->table.' WHERE to_client=:to_client ORDER BY addtime DESC LIMIT 0,6';
        return $this->query($_sql, array('to_client'=>$_to_client));
    }
}
