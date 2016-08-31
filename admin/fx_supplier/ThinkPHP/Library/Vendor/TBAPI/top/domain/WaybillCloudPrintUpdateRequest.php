<?php

/**
 * 更新请求信息
 * @author auto create
 */
class WaybillCloudPrintUpdateRequest
{
	
	/** 
	 * 物流公司CODE
	 **/
	public $cp_code;
	
	/** 
	 * 物流服务内容
	 **/
	public $logistics_services;
	
	/** 
	 * x
	 **/
	public $object_id;
	
	/** 
	 * 包裹信息
	 **/
	public $package_info;
	
	/** 
	 * 收件信息
	 **/
	public $recipient;
	
	/** 
	 * 发件信息
	 **/
	public $sender;
	
	/** 
	 * 模板URL
	 **/
	public $template_url;
	
	/** 
	 * 面单号
	 **/
	public $waybill_code;	
}
?>