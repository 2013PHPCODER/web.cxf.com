<?php
namespace api\home;

class Order_messageDao extends Dao {
    public $table='order_message';
    /**
     * 分销商向供应商发送留言
     * @param int $_order_id 订单号
     * @param int $_user_id 用户ID值
     * @param string $_message 消息内容
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608121640
     */
    public function send_message($_user_id,$_order_id,$_message,$_user_type=3,$_to_user_type=2){
        $_sql = 'INSERT INTO `fx_back`.`order_message` ( `order_id`, `user_type`, '
                . '`user_id`, `message`, `addtime`, `to_user_type`) VALUES ( :order_id, :user_type, :user_id, :message, :addtime, :to_user_type)';
        $re = $this->excute($_sql, array('order_id'=>$_order_id,'user_type'=>$_user_type,
                'user_id'=>$_user_id,'message'=>$_message,'addtime'=>time(),'to_user_type'=>$_to_user_type
            ));
        if(!$re) return false;
        return true;
    }
    
    /**
     * 分销商给总台留言接口
     * @return string JSON
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608111932
     */
    public function distribute_to_admin($_user_id,$_page){
        $_order_message_model = \MODEL::order_message();  
        $_order_message_model->user_type=  \Order::order_detail_orderto_user_type;
        $_order_message_model->to_user_type=  \Order::order_message_to_admin;
        $_order_message_model->user_id = $_user_id;
        return $this->getList($_order_message_model, array('id','order_id','user_type','message','addtime','to_user_type'),$_page);
    }
    
     /**
     * 留言详情
     * @param int $_id 订单ID
     * @return string JSON
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608111932
     */
    public function message_details($_id,$_order_id,$_user_id){
        $_sql = 'SELECT order_id,user_type,message,addtime,to_user_type FROM '.$this->table.' WHERE id=:id AND order_id=:order_id AND user_id=:user_id';
        return $this->query($_sql, array('id'=>$_id,'order_id'=>$_order_id,'user_id'=>$_user_id),'fetch_row');
    }
}
