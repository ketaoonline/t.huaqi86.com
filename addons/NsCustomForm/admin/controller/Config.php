<?php
/**
 * Config.php
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2015-2025 山西牛酷信息科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: http://www.niushop.com.cn
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用。
 * 任何企业和个人不允许对程序代码以任何形式任何目的再发布。
 * =========================================================
 * @author : niuteam
 * @date : 2015.1.17
 * @version : v1.0.0.0
 */
namespace addons\NsCustomForm\admin\controller;

use addons\NsAlipay\data\service\AlipayConfig;
use app\admin\controller\BaseController;
use addons\NsCustomForm\data\service\Config as configService;

/**
 * 网站设置模块控制器
 */
class Config extends BaseController
{
	public $addon_view_path;
	
	public function __construct()
	{
		parent::__construct();
		$this->addon_view_path = ADDON_DIR . '/NsCustomForm/template/';
	}
	
	public function orderCustom(){
		return view($this->addon_view_path.$this->style . "Config/orderCustom.html");
	}
    
	public function customDataList(){
		$oc_id = request()->get("oc_id", "");
		$this->assign("oc_id", $oc_id);
		return view($this->addon_view_path.$this->style . "Config/customDataList.html");
	}
	/**
	 * 创建自定义表单
	 * @return Ambigous <boolean, number, \think\false, string>
	 */	
	public function saveCustom(){
		$config_sevice = new configService();
		
		$oc_name = request()->post("oc_name", "");
		$name_alias = request()->post("name_alias", "");
		$oc_id = request()->post("oc_id", "");
		
		$res = $config_sevice->saveOrderCustom($oc_name, $name_alias, $oc_id);
		
		return $res;
	}

	/**
	 * 	自定义表单列表
	 */
	public function getOrderCustomList(){
		$config_sevice = new configService();
		
		$list = $config_sevice->getOrderCustomList();
		
		return $list;
	}
	
	/**
	 * 设置表单自定义字段
	 */
	public function saveUpdateCustomData(){
		$config_sevice = new configService();
		
		$field_name = request()->post("field_name", "");
		$field_e_name = request()->post("field_e_name", "");
		$oc_id = request()->post("oc_id", "");
		$is_fill = request()->post("is_fill", 0);
		$field_type = request()->post("field_type", "");
		$id = request()->post("id", "");
		$option_list = request()->post("option_list", "");
		$res = $config_sevice->saveUpdateCustomData($id, $field_name, $field_e_name, $oc_id, $is_fill, $field_type, $option_list);
		
		return $res;
	}
	
	/**
	 * 获取表单字段列表
	 */
	public function getCustomDataList(){
		$config_sevice = new configService();
		
		$page_index = request()->post("page_index", "");
		$oc_id = request()->post("oc_id", $oc_id);
		$condition['oc_id'] = $oc_id;
		
		$list = $config_sevice->getCustomDataList($page_index, 0, $condition);
		
		return $list;
	}
	
	/**
	 * 删除表单字段
	 */
	public function deleteCustom(){
		$config_sevice = new configService();
		
		$id = request()->post("id", "");
		
		$res = $config_sevice->deleteCustomData($id);
		
		return AjaxReturn($res);
	}
	
	/**
	 * 删除自定义表单
	 */
	public function deleteOrderCoupon(){
		$config_sevice = new configService();
		
		$oc_id = request()->post("oc_id", "");
		
		$res = $config_sevice->deleteOrderCoupon($oc_id);
		
		return AjaxReturn($res);
	}
	
	/**
	 * 修改自定义表单的状态
	 */
	public function setOrderCustomStatus(){
		$config_sevice = new configService();
		
		$oc_id = request()->post("oc_id", "");
		$status = request()->post("status", 0);
		
		$res = $config_sevice->setOrderCustomStatus($oc_id, $status);
		
		return AjaxReturn($res);
	}
	
	/**
	 *获取自定义字段信息
	 * 
	 */
	public function getCustomDataDetail(){
		$config_sevice = new configService();
		
		$id = request()->post("id", "");
		
		$res = $config_sevice->getOrderCustomDataDetail($id);
		
		return $res;
	}
	
}