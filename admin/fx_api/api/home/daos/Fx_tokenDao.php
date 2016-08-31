<?php
namespace api\home;

class Fx_tokenDao extends Dao {


    private $table='fx_token';
    private $id;
    private $fields='access_token, refresh_token, create_access_time, create_refresh_time, use_refresh_time';


    public function getTokenWithId($id, $auto_login=0){          //通过用户id获得token,
        $this->id=$id;
        $sql='select '.$this->fields. ' from '. $this->table. ' where user_id=:id and type=1 limit 1';
        $param=['id'=>$id];
        $data=$this->query($sql, $param, 'fetch_row');

        if ($auto_login) {                                                                                  //自动登录,需生成新的refresh
            if (!$data) {
                $data=$this->new_token(); 
            }else{
                $this->check_update_token($data, 'refresh');                                                        //必须重新生成refreshtoken
            }
            
        }else{                                                                                              //非自动登录
            if (!$data) {                   //没有token生成token
                $data=$this->new_token();  
            }else{
                $this->check_update_token($data);              //检查access_token是否失效以及更新token
            }
            unset($data['refresh_token'], $data['create_refresh_time'], $data['use_refresh_time']);
        }

        return $data;


    }
    public function getTokenWithRefresh($id, $refresh_token){                   //根据refresh_token获得token， 该方法需要验证id和refresh_token是否正确
        $this->id=$id;

        $sql='select '.$this->fields. ' from '. $this->table. ' where user_id=:id and type=1 limit 1';
        $param=['id'=>$id ];
        $data=$this->query($sql, $param, 'fetch_row');

        if (!$data || f_refresh_token($data['refresh_token'])!==$refresh_token ) {                         //refresh错误, 注意需要格式化原始数据进行比对
            myerror(\StatusCode::msgTokenRefreshError, 'refresh_token错误');
        }
        if (Config('token.refresh_frequency') + $data['use_refresh_time'] > time()) {                 //检查refresh使用频率
            myerror(\StatusCode::msgTokenRefreshFrequent, 'refresh_token使用太过频繁');
        }
  
        $sql_uptae_refresh='update '.$this->table. " set use_refresh_time=:time where user_id=$this->id";
        $param=['time'=>time()];
        $data['use_refresh_time']=time();
        $this->excute($sql_uptae_refresh, $param);
        return $data;
    }


    public function getAccessTokenForCheck($user_id){                       //拿到accesstoken用于检测
        $sql='select access_token, create_access_time from fx_token where user_id=:id and type=1';
        $param=['id'=>$user_id];
        return $this->query($sql, $param);
    }




    /**
    *检查token是否失效然后更新，该类里最重要的操作
    *@param string $type  检查更新类型，可选值access|refresh ，为refresh时多一步操作，生成新的refresh
    */
    private function check_update_token(&$data, $type='access'){      
        /*
        1查询access_token是否失效 ,此处不做单点登录限制
        */               
        if (Config('token.access_overtime') + $data['create_access_time'] < time()) {     //已过期
            $sql='update '.$this->table. ' set access_token=:access, create_access_time=:time '. "where user_id=$this->id and type=1";

            $new_access=$this->create_access();
            $time=time();
            $param=['access'=>$new_access, 'time'=>$time];

            if ( $this->excute($sql, $param) ) {
                $data['access_token']=$new_access;
                $data['create_access_time']=$time;
            }else{
                myerror(\StatusCode::msgTokenAccessFail, 'access_token更新失败，请重新请求'); 
            }
        }                                                                                                   
        /*
            2查询refreshtoken是否失效
        */
        if ($type ==='refresh') {
            //自动登录只能在一处登录，所以需要更新refresh
            $sql='update '.$this->table. ' set refresh_token=:refresh, create_refresh_time=:create_time, use_refresh_time=:use_time '. "where user_id=$this->id and type=1";
            $new_refresh=$this->create_refresh();
            $time=time();
            $param=['refresh'=>$new_refresh, 'create_time'=>$time, 'use_time'=>$time];

            if ( $this->excute($sql, $param) ) {
                $data['refresh_token']=$new_refresh;
                $data['create_refresh_time']=$time;
                $data['use_refresh_time']=$time;
            }else{
                myerror(\StatusCode::msgTokenRefreshFail, 'refresh_token更新失败，请重新请求'); 
            }
        }

    }

    private function new_token(){            
        $sql='insert into '. $this->table. ' (user_id, access_token, refresh_token, create_access_time, create_refresh_time, use_refresh_time) ';
        $sql.='values(:user_id, :access_token, :refresh_token, :create_access_time, :create_refresh_time, :use_refresh_time)';
        $param=[
            'user_id'=>$this->id,
            'access_token'=>$this->create_access(),
            'refresh_token'=>$this->create_refresh(),
            'create_access_time'=>time(),
            'create_refresh_time'=>time(),
            'use_refresh_time'=>time(),
        ];
        $r=$this->excute($sql, $param);

        if (!$r) {                      //写入失败
            myerror(\StatusCode::msgTokenNewFail, 'token生成失败，请重新请求'); 
        }
        return $param;    
    }

    private function create_access(){           //生成新accesstoken
        $t=microtime();
        $rand=mt_rand();
        return md5($t.$rand);
    }
    private function create_refresh(){           //生成新refreshtoken
        $t=microtime();
        $rand=mt_rand();
        return md5(crypt($rand.$t));        
    }


}

