<?php
/*
*by 林澜叶
*/
namespace Storage\Controller;
use Common\Controller\BasicController;

class FreightController extends BasicController {

    public function index() {
    	$p=(int) $_GET['p']? : 1;			//参数处理
    	$key=htmlspecialchars(trim($_GET['key']));

    	$para=['p'=>$p, 'key'=>$key];
    	$r=R('QuerySql/freightList', [$para], 'Dal');
    	foreach ($r['list'] as &$v) {					//处理数据
    		if ($v['is_free']) {
    			$v['is_free']='是';
    		}else{
    			$v['is_free']='否';
    		}
    		if ($v['special']) {
    			$v['special']='是';
    		}else{
    			$v['special']='否';
    		}
    	}

    	$this->assign('list', $r['list']);
    	$this->assign('total', $r['total']);

        $this->display();
    }


    public function detail(){
    	$id=(int) $_GET['id'];			//参数处理
    	$para=['id'=>$id];
    	$r=R('QuerySql/freightDetail', [$para], 'Dal');

        $r['main']['is_free_code']=$r['main']['is_free'];       //保留原有的状态值
    	if ($r['main']['is_free']) {
    		$r['main']['is_free']='是';
    	}else{
    		$r['main']['is_free']='否';
    	}

        foreach ($r['sub'] as $k => $v) {
            $r['code'][$k]=$v['code'];
        }
        $r['code']=json_encode($r['code']);


    	$this->assign('main', $r['main']);
    	$this->assign('sub', $r['sub']);
        $this->assign('code', $r['code']);

        $this->display();
    }


    public function add(){          //新增模板
        $data=$this->createData($_POST);

    	$r=R('AddSql/freight', [$data], 'Dal'); 
    	if ($r) {
    		$this->success('新增邮费模板成功','', 3);
    	}else{
    		$this->error('新增邮费模板失败','', 3);
    	}
    }

    public function update(){
        $data=$this->createData($_POST);
        $data['id']=(int) $_POST['id'];

        foreach ($data['sub'] as &$v) {
            $v['freight_template_id']=$data['id'];
        }


        $condition=['freight_template_id'=>$data['id'], 'supplier_user_id'=>$this->user_info['id']];
        $para=['data'=>$data, 'condition'=>$condition];
    	$r=R('UpdateSql/freight', [$para], 'Dal');


    	if ($r) {
    		$this->success('修改邮费模板成功','', 3);
    	}else{
    		$this->error('修改邮费模板失败','', 3);
    	}    	
    }

    public function del(){
        $id=(int) $_POST['id'];
        $condition=['freight_template_id'=>$id, 'supplier_user_id'=>$this->user_info['id']];
        $condition2=['freight'=>$id, 'supplier_user_id'=>$this->user_info['id']];
        $check=R('QuerySql/checkFreight', [$condition2], 'Dal');

        $check &&  $this->error('已有仓库使用当前物流模板，请先删除仓库后再尝试', U('storage/freight/index'), 3);

        $r=R('DeleteSql/freight', [$condition], 'Dal');
        if ($r) {
            $this->log('删除物流模板，模板编号：'. $id);
            $this->success('删除物流模板成功',U('storage/freight/index'), 3);
        }else{
            $this->error('删除物流模板失败',U('storage/freight/index'), 3);
        }           

    }

    private function createData($tmp){
        $data=[];
        
        $data['main']=['name'=>$tmp['name'],            //生成主data
            'is_free'=>$tmp['is_free'], 
            'start_heavy'=>$tmp['start_heavy'],
            'start_freight'=>$tmp['start_freight'],
            'continue_heavy'=>$tmp['continue_heavy'],
            'continue_freight'=>$tmp['continue_freight'],
            'add_time'=>time(),
            'supplier_user_id'=>session('user_info.id'),
        ];        
        $valid=new \valid();                

        if (!$tmp['is_free']) {             //不包邮需要验证
            $rules=[                                    //验证主data
                'valid'=>[  
                    'is_numeric'=>['start_heavy', 'continue_heavy', 'start_freight', 'continue_freight'],
                    'has_value'=>['name'],
                ],
                'format'=>[
                    'intval'=>['start_heavy', 'continue_heavy'],
                    'round'=>['start_freight', 'continue_freight'],
                ],
            ]; 
        }else{
            $rules=[                                    
                'valid'=>[  
                    'has_value'=>['name'],
                ],
            ];             //包邮不要的数据赋予0
            $data['main']['start_heavy']=0;
            $data['main']['start_freight']=0;
            $data['main']['continue_heavy']=0;
            $data['main']['continue_freight']=0;
        }


       
        $data['name']=$data['name']? : '默认模板';
        $valid->run($rules, $data['main']);    
        if ($valid->err) {
            $this->error($valid->err.'验证不通过，请重新提交','', 3);
        }
        $data['main']=$valid->data;


        if (!empty($tmp['sub']['sub_start_heavy'][0])) {            //如果存在子data
            $n=count($tmp['sub']['sub_start_heavy']);               //生成子data，用于特例
            for ($i=0; $i < $n; $i++) { 
                $data['sub'][$i]=[
                    'start_heavy'=>$tmp['sub']['sub_start_heavy'][$i],
                    'start_freight'=>$tmp['sub']['sub_start_freight'][$i],
                    'continue_heavy'=>$tmp['sub']['sub_continue_heavy'][$i],
                    'continue_freight'=>$tmp['sub']['sub_continue_freight'][$i],
                ];
                $province=$tmp['sub']['province'][$i];             //判断区域
                $city=$tmp['sub']['city'][$i];
                $district=$tmp['sub']['district'][$i];
                if ($district) {                                //获得省市区数据
                   $data['sub'][$i]['area']=(int) $district;
                   $data['sub'][$i]['name']=getAreaByCode($data['sub'][$i]['area'], 'district');
                } elseif ($city){
                   $data['sub'][$i]['area']=(int) $city;
                   $data['sub'][$i]['name']=getAreaByCode($data['sub'][$i]['area'], 'city');
                } elseif ($province){
                   $data['sub'][$i]['area']=(int) $province;
                   $data['sub'][$i]['name']=getAreaByCode($data['sub'][$i]['area'], 'province');
                } else {
                   $data['sub'][$i]['area']=110000;         //默认北京市
                   $data['sub'][$i]['name']=getAreaByCode($data['sub'][$i]['area']);
                }
                  
            }
            foreach ($data['sub'] as  &$v) {                    //验证子数据
                $valid->run($rules, $v);    
                if ($valid->err) {
                    $this->error($valid->err.'验证不通过，请重新提交','', 3);
                }
            }

        }else{
            $data['sub']='';
        }    
        return $data;    
    }
}
