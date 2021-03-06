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
namespace addons\NsMemberRegister;


use addons\NsMemberRegister\data\service\MemberRegister;
use data\service\Member;
use data\service\promotion\PromoteRewardRule;

class NsMemberRegisterAddon extends \addons\Addons
{
	
	public $info = array(
		'name' => 'NsMemberRegister', // 插件名称标识
		'title' => '会员注册', // 插件中文名
		'description' => '设置会员注册奖励', // 插件概述
		'status' => 1, // 状态 1启用 0禁用
		'author' => 'niushop', // 作者
		'version' => '1.0', // 版本号
		'has_addonslist' => 0, // 是否有下级插件 例如：第三方登录插件下有 qq登录，微信登录
		'content' => '', // 插件的详细介绍或使用方法
		'ico' => 'addons/NsMemberRegister/ico.png'
	);
	
	/**
	 * 获取会员行为设置
	 * @param unknown $params
	 */
	public function getMemberActionConfig($params = [])
	{
		$arr = [
			'name' => $this->info['name'],
			'title' => $this->info['title'],
			'ico' => $this->info['ico'],
			'description' => $this->info['description'],
			'index' => 'MemberRegister/index'
		];
		
		if (isset($params['type'])) {
			if ($params['type'] == 'all' || $params['type'] == $this->info['name']) {
				return $arr;
			}
		}
		return [];
		
	}
	
	/**
	 * 会员注册行为
	 *
	 * @param unknown $params
	 */
	public function memberAction($params = [])
	{
		if (empty($params['uid']) || empty($params['type']) || $params['type'] != $this->info['name']) {
			return 0;
		}
		
		$member_register = new MemberRegister();
		$res = $member_register->registerMemberGivePoint($params['uid']);
		
		// 注册成功送优惠券
		$member_action_config = $member_register->getMemberActionConfig();
		if ($member_action_config['register_coupon'] == 1) {
			$rewardRule = new PromoteRewardRule();
			$reward_rule_info = $rewardRule->getRewardRuleInfo("reg_coupon");
			if ($reward_rule_info['reg_coupon'] != 0) {
				$member = new Member();
				$res += $member->memberGetCoupon($params['uid'], $reward_rule_info['reg_coupon'], 2);
			}
		}
		return $res;
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