<?php
// +----------------------------------------------------------------------
// | test [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.zzstudio.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Byron Sampson <xiaobo.sun@gzzstudio.net>
// +----------------------------------------------------------------------
namespace addons\NsLksms;

use addons\NsLksms\data\service\LkSmsConfig;

class NsLksmsAddon extends \addons\Addons
{
	public $info = array(
		'name' => 'NsLksms', // 插件名称标识
		'title' => '凌凯短信', // 插件中文名
		'description' => '支持凌凯短信配置与发送', // 插件概述
		'status' => 1, // 状态 1启用 0禁用
		'author' => 'niushop', // 作者
		'version' => '1.0', // 版本号
		'has_addonslist' => 0, // 是否有下级插件 例如：第三方登录插件下有 qq登录，微信登录
		'content' => '', // 插件的详细介绍或使用方法
		'ico' => 'addons/NsLksms/ico.png'
	);
	
	public function smsconfig($param)
	{
		$config_service = new LkSmsConfig();
		$config = $config_service->getLkSmsConfig($param['instance_id']);
		$config["logo"] = "addons/NsLksms/lingkai.jpg";
		$config["pay_name"] = "凌凯短信";
		$config["desc"] = "该系统支持短信接口";
		$config['url'] = __URL('__URL__/NsLksms/' . ADMIN_MODULE . '/Config/lingkaiConfig');
		return $config;
	}
	
	/**
	 * 短信发送（短信插件实现接口）
	 * @param unknown $param 说明传入参数    signName（短信签名） smsParam(短信变量赋值json)   mobile（手机号）  code（模板id）
	 * @return string|multitype:number string |multitype:number unknown Ambigous <number, string, unknown, NULL>
	 */
	public function smssend($param)
	{
		$config_service = new LkSmsConfig();
		$config = $config_service->getLkSmsConfig(0);
		if ($config['is_use'] == 0) {
			return '';
		}
		if (empty($config['value']['appKey']) || empty($config['value']['secretKey']) || empty($config['value']['freeSignName']) || empty($config['is_use'])) {
			return [
				'code' => -1,
				'message' => "短信配置信息有误!",
				'param' => 0
			];
		}
		$result = $config_service->smsSend($config['value']['appKey'], $config['value']['secretKey'], $param['signName'], $param['mobile'], $param['smsParam'], $param['content']);
		return [
			'code' => $result["code"],
			'message' => $result["message"],
			'param' => rand(100000, 999999)
		];
	}
	
	/**
	 * 关闭短信
	 * @param unknown $param
	 */
	public function closeSms($param = []){
	    if (isset($param['name']) && $param['name'] == $this->info['name']) return;
	    $config_service = new LkSmsConfig();
	    $config = $config_service->getLkSmsConfig(0);
	    if ($config['is_use']) {
	        $config_service->setLkSmsConfig(0, $config['value']['appKey'], $config['value']['secretKey'], $config['value']['freeSignName'], 0);
	    }
	}
	
	/**
	 * 插件安装
	 * @see \addons\Addons::install()
	 */
	public function install()
	{
		return true;
	}
	
	/**
	 * 插件卸载
	 * @see \addons\Addons::uninstall()
	 */
	public function uninstall()
	{
		return true;
	}
}