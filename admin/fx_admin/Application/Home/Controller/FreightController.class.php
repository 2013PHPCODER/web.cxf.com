<?php

namespace Home\Controller;
use Common\Controller\AuthController as AuthController;

class IndexController extends AuthController{

    public function index(){
    	
       $this->display();
    }

}
