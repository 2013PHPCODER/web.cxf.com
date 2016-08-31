<?php
namespace api\home;
use BaseController;

/**
*基础类控制器，可在此实现各个模块的前置或后置逻辑
*/
class Controller extends BaseController{

	public function _init(){
		//$this->_validRequest();
		$this->_start();
	}

}