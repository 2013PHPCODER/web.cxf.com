<?php

/**
 * 入参信息
 * @author auto create
 */
class WaybillCloudPrintApplyNewRequest
{
	
	/** 
	 * 物流公司Code
	 **/
	public $cp_code;
	
	/** 
	 * 产品类型编码
	 **/
	public $product_code;
	
	/** 
	 * 发货人信息
	 **/
	public $sender;
	
	/** 
	 * 请求面单信息
	 **/
	public $trade_order_info_dtos;	
}
?>