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
namespace addons\Nsfx;

use addons\Nsfx\data\model\NfxPromoterModel;
use addons\Nsfx\data\service\NfxCommissionCalculate;
use addons\Nsfx\data\service\NfxCommissionConfig;
use addons\Nsfx\data\service\NfxShopConfig;
use addons\Nsfx\data\service\NfxUser;
use data\model\NsOrderModel;
use think\Session;

class NsfxAddon extends \addons\Addons
{
	
	public $info = array(
		'name' => 'Nsfx', // 插件名称标识
		'title' => '分销', // 插件中文名
		'description' => '微信分销功能插件', // 插件概述
		'status' => 1, // 状态 1启用 0禁用
		'author' => 'niushop', // 作者
		'version' => '1.0', // 版本号
		'has_addonslist' => 0, // 是否有下级插件 例如：第三方登录插件下有 qq登录，微信登录
		'content' => '', // 插件的详细介绍或使用方法
		'ico' => 'addons/Nsfx/ico.png'
	);
	
	/**
	 * 关联商品信息查询
	 * @param unknown $params
	 */
	public function getGoodsRelationInfo($params)
	{
		$goods_info = $params["goods_info"];
		$commission_config = new NfxCommissionConfig();
		$res = $commission_config->getGoodsCommissionRate($goods_info["goods_id"]);
		return [ "info" => $res, "key" => "distribution" ];
	}
	
	/**
	 * 关联订单信息查询
	 * @param unknown $params
	 */
	public function getOrderRelationInfo($params)
	{
		$goods_info = $params["order_info"];
		$commission_config = new NfxCommissionConfig();
		$res = $commission_config->getOrderCommission($params);
		return [ "info" => $res, "key" => "distribution" ];
	}
	
	/**
	 * 订单创建成功
	 * @param unknown $param
	 */
	public function orderCreateSuccess($param)
	{
		return AjaxReturn(1);
	}
	
	/**
	 * 订单支付成功
	 * @param unknown $param
	 */
	public function orderPaySuccess($param)
	{
		if (isset($param['order_pay_no'])) {
			return $this->orderCommissionCalculate($param['order_pay_no']);
		} elseif (isset($param['order_id'])) {
			return $this->orderCommissionCalculate("", $param['order_id']);
		} else {
			return true;
		}
		
	}
	
	/**
	 * 订单退款成功
	 * @param unknown $param
	 */
	public function orderRefundSuccess($param)
	{
	
	}
	
	/**
	 * 订单完成
	 * @param unknown $param
	 */
	public function orderCompleteSuccess($param)
	{
		// 结算订单的分销佣金
		$this->updateOrderCommission($param['order_id']);
		$order_model = new NsOrderModel();
		$order_detail = $order_model->getInfo([ 'order_id' => $param['order_id'] ]);
		$shop_fx_config = new NfxShopConfig();
		$config_info = $shop_fx_config->getShopConfigDetail();
		if ($config_info["is_distribution_start"]) {
			// 分销商需要申请 自身消费会产生佣金
			$this->orderDistributionSuccessHook($order_detail['buyer_id'], $order_detail["order_no"], $param['order_id'], $order_detail["order_money"], 1);
		} else {
			// 分销商不需要申请 自身消费只会给上级产生佣金
			$promoter = new NfxPromoterModel();
			$promoter_info = $promoter->getInfo([
				"uid" => $order_detail['buyer_id']
			], "parent_promoter");
			if (!empty($promoter_info) && $promoter_info['parent_promoter'] > 0) {
				$parent_promoter_info = $promoter->getInfo([
					"promoter_id" => $promoter_info['parent_promoter']
				], "uid");
				$this->orderDistributionSuccessHook($parent_promoter_info['uid'], $order_detail["order_no"], $param['order_id'], $order_detail["order_money"], 1);
			}
		}
	}
	
	/**
	 * 退款完成结算
	 * @param unknown $param
	 */
	public function orderGoodsConfirmRefundSuccess($param)
	{
		
		// 重新计算订单的佣金情况
		$this->updateCommissionMoney($param['order_id'], $param['order_goods_id']);
		
	}
	
	/**
	 * 会员注册成功操作
	 * @param unknown $param
	 * @return multitype:unknown
	 */
	public function memberRegisterSuccess($param)
	{
		if (!empty($_SESSION['source_uid'])) {
			// 判断当前版本
			$nfx_user = new NfxUser();
			$nfx_user->userAssociateShop($param['uid'], 0, $_SESSION['source_uid']);
			Session::set("tag_promoter", 0);
		} else {
			// 判断当前版本
			$nfx_user = new NfxUser();
			$nfx_user->userAssociateShop($param['uid'], 0, 0);
			$shop_config = new NfxShopConfig();
			$shop_config_info = $shop_config->getShopConfigDetail();
			if ($shop_config_info['is_distribution_start'] == 0) {
				Session::set("tag_promoter", 1);
			}
			
		}
		return AjaxReturn(1);
	}
	/**
	 * ***********************************************订单的佣金计算--Start******************************************************
	 */
	
	/**
	 * 支付后续佣金操作
	 *
	 * @param unknown $order_out_trade_no
	 * @param unknown $order_id
	 */
	private function orderCommissionCalculate($order_out_trade_no = "", $order_id = 0)
	{
		if ($order_out_trade_no != "" && $order_id == 0) {
			$order_model = new NsOrderModel();
			$condition = " out_trade_no=" . $order_out_trade_no;
			$order_list = $order_model->getQuery($condition, "order_id", "");
			foreach ($order_list as $k => $v) {
				$this->oneOrderCommissionCalculate($v["order_id"]);
			}
		} else
			if ($order_out_trade_no == "" && $order_id != 0) {
				$this->oneOrderCommissionCalculate($order_id);
			}
	}
	
	/**
	 * 处理单个 订单佣金计算
	 *
	 * @param unknown $order_id
	 */
	private function oneOrderCommissionCalculate($order_id)
	{
		$commissionCalculate = new NfxCommissionCalculate($order_id);
		// 分销佣金计算
		$res = $commissionCalculate->orderdistributionCommission();
		// 区域分销计算
		$res = $commissionCalculate->orderRegionAgentCommission();
		// 股东分红计算
		$res = $commissionCalculate->orderPartnerCommission();
	}
	
	/**
	 * 订单退款成功后需要重新计算订单的佣金
	 *
	 * @param unknown $order_id
	 * @param unknown $order_goods_id
	 */
	private function updateCommissionMoney($order_id, $order_goods_id)
	{
		$commissionCalculate = new NfxCommissionCalculate($order_id, $order_goods_id);
		// 重新计算分销佣金
		$commissionCalculate->updateOrderDistributionCommission();
		// 重新计算股东分红
		$commissionCalculate->updateOrderPartnerCommission();
		// 重新计算区域分销佣金
		$commissionCalculate->updateOrderRegionAgentCommission();
		// 订单退款成功后 发放佣金
		$this->updateOrderCommission($order_id);
	}
	
	/**
	 * 订单完成交易进行 佣金结算
	 *
	 * @param unknown $order_id
	 */
	private function updateOrderCommission($order_id)
	{
		
		$order_model = new NsOrderModel();
		$order_model->startTrans();
		try {
			$shop_obj = $order_model->get($order_id);
			$order_sataus = $shop_obj["order_status"];
			// 判断当前订单的状态是否 已经交易完成 或者 已退款的状态
			if ($order_sataus == ORDER_COMPLETE_SUCCESS || $order_sataus == ORDER_COMPLETE_REFUND || $order_sataus == ORDER_COMPLETE_SHUTDOWN) {
				// 得到订单的店铺id
				$shop_id = $shop_obj["shop_id"];
				// 得到订单用户id
				$uid = $shop_obj["buyer_id"];
				$user_service = new NfxUser();
				// 发放订单的三级分销佣金
				$user_service->updateCommissionDistributionIssue($order_id);
				// 更新当前用户的分销商等级
				$user_service->updatePromoterLevel($uid, $shop_id);
				// /发放订单的区域分销佣金
				$user_service->updateCommissionRegionAgentIssue($order_id);
				// 发放订单的股东分红佣金
				$user_service->updateCommissionPartnerIssue($order_id);
				// 更新用户的股东等级
				$user_service->updatePartnerLevel($uid, $shop_id);
			}
			$order_model->commit();
		} catch (\Exception $e) {
			$order_model->rollback();
		}
	}
	
	private function orderDistributionSuccessHook($uid, $order_no, $order_id, $order_money, $level)
	{
		if ($level > 3) return;
		$title = '本店分销订单提成通知';
		$tag = "distribution_commission";
		switch ($level) {
			case 2:
				$tag = "distribution_child_commission";
				$title = '下级分店分销订单提成通知';
				break;
			case 3:
				$title = '下下级分店分销订单提成通知';
				$tag = "distribution_subchild_commission";
				break;
		}
		
		//        hook('orderDistributionSuccess', [
		//            'uid' => $uid,
		//            'order_no' => $order_no,
		//            'order_id' => $order_id,
		//            'order_money' => $order_money,
		//            'title' => $title,
		//            'notice_time' => time()
		//        ]);
		message($tag, [
			'uid' => $uid,
			'order_no' => $order_no,
			'order_id' => $order_id,
			'order_money' => $order_money,
			'title' => $title,
			'notice_time' => time()
		]);
		
		$promoter = new NfxPromoterModel();
		$promoter_info = $promoter->getInfo([
			"uid" => $uid
		], "parent_promoter");
		
		if ($promoter_info['parent_promoter'] > 0) {
			$level = $level + 1;
			$parent_promoter_info = $promoter->getInfo([
				"promoter_id" => $promoter_info['parent_promoter']
			], "uid");
			
			$this->orderDistributionSuccessHook($parent_promoter_info['uid'], $order_no, $order_id, $order_money, $level);
		}
	}
	
	/**
	 * ***********************************************订单的佣金计算--End******************************************************
	 */
	
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