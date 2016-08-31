<?php

namespace Home\Controller;
use Think\Controller;


class DebugController extends Controller{


	public function index(){
		// C('LAYOUT_ON', 'TRUE');
		$this->display();
	}


}
