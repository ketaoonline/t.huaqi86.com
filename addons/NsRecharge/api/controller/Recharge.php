<?php
/**
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

namespace addons\NsRecharge\api\controller;

use app\api\controller\BaseApi;
use addons\NsRecharge\data\service\Recharge as RechargeService;
use data\service\Config as SystemConfig;

/**
 * 微页面接口
 */
class Recharge extends BaseApi
{
    /**
     * 获取充值有礼活动
     */
	public function rechargeList(){
        $config = new RechargeService();
        $list = $config->getRechargeList([
            'status' => 1,
            'scene' => ['like', '%member%']
        ]);
        return $this->outMessage('获取充值有礼活动', $list);
	}
	
	/**
	 * 获取充值配置
	 */
	public function rechargeConfig(){
	    $config = new SystemConfig();
	    $info = $config->getConfig($this->instance_id, 'RECHARGECONFIG');
	    $data = [
	        'rechargeMode' => ["fixed_amount","custom_amount"],
	        'fixedAmount' => [20, 30, 50, 150, 300, 500],
	        'customAmount' => 10
	    ];
	    if (!empty($info) && !empty($info['value'])) {
	        $data = json_decode($info['value'], true);
	    }
	    return $this->outMessage('获取充值配置', $data);
	}
}