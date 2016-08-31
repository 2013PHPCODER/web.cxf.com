<?php
namespace api\home;

class MessageController extends Controller {
    
    /**
     * 分销商向供应商发送留言
     * @param int $_order_id 订单号
     * @param int $_user_id 用户ID值
     * @param string $_message 消息内容
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608121640
     */
    public function send_message(){
//        echo json_encode(array('order_id'=>1,'user_id'=>1,'message'=>'每个人都在问我，到底还在等什么，等到春夏秋冬都过了
//                            难道还不够，其实是因为我的心，有一个缺口，等拿走的人把它还给我，每个人都在说这种爱情，
//                            没有结果，我也知道，你永远都不能够 爱我，其实我只是希望你，有时想一想我，你却已经渐渐渐渐，什么都不再说，
//                            我睡不着的时候，会不会有人陪着我，我难过的时候，会不会有人安慰我，我想说话的时候，会不会有人了解我
//                            我忘不了你的时候，你会不会来疼我，你知不知道 你知不知道，我等到花儿也谢了，你知不知道 你知不知道
//                            我等到花儿也谢了 每个人都在说这种爱情 没有结果 我也知道 你永远都不能够 爱我 其实我只是希望你
//                            有时想一想我 你却已经渐渐渐渐 什么都不再说 我睡不着的时候 会不会有人陪着我 我难过的时候 
//                            会不会有人安慰我 我想说话的时候 会不会有人了解我 我忘不了你的时候 你会不会来疼我 你知不知道 你知不知道
//                            我等到花儿也谢了 你知不知道 你知不知道 我等到花儿也谢了 你知不知道 你知不知道 我等到花儿也谢了 你知不知道 
//                            你知不知道 我等到花儿也谢了 你知不知道 你知不知道我等到花儿也谢了'));exit;
        if(!isset($this->request->order_id)) myerror(\StatusCode::msgCheckFail, \Message::message_order_id_not);
        if(!isset($this->request->user_id)) myerror(\StatusCode::msgCheckFail, \Message::message_user_id_not);
        if(!isset($this->request->message)) myerror(\StatusCode::msgCheckFail, \Message::message_data_not);
        
        if(!\Dao::Order_message()->send_message($this->request->order_id,$this->request->user_id,$this->request->message)){
            myerror(\StatusCode::msgCheckFail, \Message::message_send_fail);
        }
        $this->response(array('result'=>array('sucess'=>true,'msg'=>\Message::message_send_success)));
        
    }

        /**
     * 分销商给总台留言接口
     * @return string JSON
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608111932
     */
    public function distribute_to_admin(){
        //echo json_encode(array('page'=>1,'user_id'=>1));exit;
        //{"page":1,"user_id"=>1}
        if(!isset($this->request->page)) myerror(\StatusCode::msgCheckFail, \Message::message_page_not);
        if(!isset($this->request->user_id)) myerror(\StatusCode::msgCheckFail, \Message::message_user_id_not);
        
        $_message_dao = \Dao::order_message();
        $_datas = $_message_dao->distribute_to_admin($this->request->user_id,$this->request->page);
        $this->response($_datas);
    }
    
   /**
     * 留言详情
     * @param int $_id 订单ID
     * @return string JSON
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608111932
     */
    public function message_details(){
        //echo json_encode(array('id'=>1,'order_id'=>1,'user_id'=>1));exit;
        //{"id":1,"order_id":1,"user_id":1}
        if(!isset($this->request->id)) myerror(\StatusCode::msgCheckFail, \Message::message_id_not);
        if(!isset($this->request->order_id)) myerror(\StatusCode::msgCheckFail, \Message::message_order_id_not);
        if(!isset($this->request->user_id)) myerror(\StatusCode::msgCheckFail, \Message::message_user_id_not);
        
        $_message_dao = \Dao::order_message();
        $_datas = $_message_dao->message_details($this->request->id,  $this->request->order_id,  $this->request->user_id);
        if(empty($_datas)) myerror(\StatusCode::msgCheckFail, \Message::message_data_not);
        $this->response($_datas);
    }
}

