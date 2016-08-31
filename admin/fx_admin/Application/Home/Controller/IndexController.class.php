<?php

namespace Home\Controller;

use Common\Controller\AuthController as Auth;

class IndexController extends Auth{


    public function index(){
    	
        $this->redirect('goods/goods/index');
    }

}
