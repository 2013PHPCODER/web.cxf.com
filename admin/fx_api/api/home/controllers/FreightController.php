<?php
namespace api\home;
class FreightController extends Controller{


	public function compute(){				//计算运费

		$q=$this->request;
		// $q=new \stdclass();
		// $q->send_address=12312;
		// $q->receiver_address=134312;
		// $q->goods_id=1;

		$must=['send_address', 'receiver_address', 'goods_id'];
		batch_isset($q, $must);



		$dao=\Dao::Fx_freight_template();
		$r=$dao->getInfo($q->goods_id);

		if (!$r) {				//包邮
			$data['freight']=0;
			$this->response($data);
			return;
		}
		$main=$r['main'];
		$sub=$r['sub'];
		$heavy=$main['heavy'];

		if (!$sub) {				//不存在特例 
			if ($main['is_free']) {
				$fee['freight']=0;
			}else{
				$fee['freight']=$this->calculate($heavy, $main['start_heavy'], $main['start_freight'], $main['continue_heavy'], $main['continue_freight']);	
			}
		}else{						//存在特例
			$have_computed=0;
			foreach ($sub as $v) {							//查看是否落在特例中
				if ($v['area']==$q->receiver_address) {
					$fee['freight']=$this->calculate($heavy, $v['start_heavy'], $v['start_freight'], $v['continue_heavy'], $v['continue_freight']);				
					$have_computed=1;
					break;
				}
			}
			if (!$have_computed) {					//没有在特例中
				if ($main['is_free']) {
					$fee['freight']=0;
				}else{
					$fee['freight']=$this->calculate($heavy, $main['start_heavy'], $main['start_freight'], $main['continue_heavy'], $main['continue_freight']);	
				}						
			}

		}
		$this->response($fee);

	}

	public function calculate($heavy, $s_heavy, $s_fee,$c_heavy,$c_fee){
		$heavy=floatval($heavy);
		$s_heavy=floatval($s_heavy);
		$s_fee=floatval($s_fee);
		$c_heavy=floatval($c_heavy);
		$c_fee=floatval($c_fee);		
		$rest=$heavy-$s_heavy;
		
		if ($rest<=0) {				//在首重内
			return $s_fee;
		}
		$per=ceil($rest/$c_heavy);			//超出部分费用
		$sub_fee=$per*$c_fee;
		$total=$s_fee+$sub_fee;
		return floatval($total);

	}

}	