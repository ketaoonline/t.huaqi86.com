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
namespace addons\NsRecharge;

use addons\NsRecharge\wap\controller\Member as WapMember;
use addons\NsRecharge\web\controller\Member as WebMember;
use addons\NsRecharge\data\service\Recharge;

class NsRechargeAddon extends \addons\Addons
{
	public $info = array(
		'name' => 'NsRecharge', // 插件名称标识
		'title' => '充值有礼', // 插件中文名
		'description' => '充值即赠，促进消费，增强会员粘性', // 插件概述
		'status' => 1, // 状态 1启用 0禁用
		'author' => 'niushop', // 作者
		'version' => '1.0', // 版本号
		'has_addonslist' => 0, // 是否有下级插件 例如：第三方登录插件下有 qq登录，微信登录
		'content' => '', // 插件的详细介绍或使用方法
		'ico' => 'addons/NsRecharge/ico.png'
	);
	
	/**
	 * 获取会员行为设置
	 * @param array $params
	 */
	public function getMemberActionConfig($params = [])
	{
	    $arr = [
	        'name' => $this->info['name'],
	        'title' => $this->info['title'],
	        'ico' => $this->info['ico'],
	        'description' => $this->info['description'],
	        'index' => 'config/index'
	    ];
	
	    if (isset($params['type'])) {
	        if ($params['type'] == 'all' || $params['type'] == $this->info['name']) {
	            return $arr;
	        }
	    }
	    return [];
	}
	
	/**
	 * 充值
	 */
	public function rechargePage($params = []){
	    if ($params['type'] == 'wap') {
	        $member = new WapMember();
	        return $member->recharge();
	    } elseif($params['type'] == 'web') {
	        $member = new WebMember();
	        return $member->recharge();
	    }
	}
	
	/**
	 * 会员充值成功
	 * @param unknown $params
	 */
	public function memberBalanceRechargeSuccess($params = []){
	    if (!empty($params['out_trade_no'])) {
            $recharge = new Recharge();
            $recharge->memberRechargeSuccess($params['out_trade_no']);	        
	    }
	}
	
	/**
	 * 商家调整余额之后
	 * @param unknown $params
	 */
	public function businessRechargeAfter($params = []) {
	    if (!empty($params['uid']) && !empty($params['recharge_money']) && $params['recharge_money'] > 0) {
	        $recharge = new Recharge();
	        $recharge->businessRechargeAfter($params['recharge_money'], $params['uid']);
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