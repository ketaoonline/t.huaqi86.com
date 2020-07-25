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
namespace addons\NsMemberExtension;

class NsMemberExtensionAddon extends \addons\Addons
{
	
	public $info = array(
		'name' => 'NsMemberExtension', // 插件名称标识
		'title' => '会员推广', // 插件中文名
		'description' => '会员推广设置', // 插件概述
		'status' => 1, // 状态 1启用 0禁用
		'author' => 'niushop', // 作者
		'version' => '1.0', // 版本号
		'has_addonslist' => 0, // 是否有下级插件 例如：第三方登录插件下有 qq登录，微信登录
		'content' => '', // 插件的详细介绍或使用方法
		'ico' => 'addons/NsMemberExtension/ico.png'
	);
	
	/**
	 * 获取行为设置
	 * @param unknown $params
	 */
	public function getMemberActionConfig($params = [])
	{
		$arr = [
			'name' => $this->info['name'],
			'title' => $this->info['title'],
			'ico' => $this->info['ico'],
			'description' => $this->info['description'],
			'index' => 'MemberExtension/index'
		];
		
		if (isset($params['type'])) {
			if ($params['type'] == 'all' || $params['type'] == $this->info['name']) {
				return $arr;
			}
		}
		return [];
	}
	
	// 钩子名称（需要该钩子调用的页面）
	
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