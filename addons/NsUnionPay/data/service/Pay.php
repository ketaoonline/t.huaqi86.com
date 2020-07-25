<?php
/**
 * AlipayConfig.php
 *
 */

namespace addons\NsUnionPay\data\service;

use data\service\BaseService;
use data\service\UnifyPay;

/**
 * 支付宝支付配置
 */
class Pay extends BaseService
{
	/**
	 * 银联交易成功
	 */
	public function backReceive($orderId, $txnTime, $queryId)
	{
		
		$unionpay = new UnionPay();
		$unifypay = new UnifyPay();
		$res = $unionpay->signatureValidate();
		
		if ($res == 1) { //签名验证通过才可
			
			//接口查询是否数据库已更新
			$result_arr = $unionpay->query($orderId, $txnTime);
			
			if (empty($result_arr)) return 0; //为空代表交易失败了
			
			if ($result_arr['txnType'] == '01') {  //消费完成执行
				
				$unifypay->onlinePay($orderId, 3, $queryId);
				return 1;
			} elseif ($result_arr['txnType'] == '04') { //退款执行
			
			}
		}
		
		return 0;
	}
	
	/**
	 * 银联前台通知验证 返回1为成功，其他都为失败
	 * @param unknown $orderId
	 * @param unknown $txnTime
	 */
	public function frontReceive($orderId, $txnTime)
	{
		
		$unionpay = new UnionPay();
		$res = $unionpay->signatureValidate();
		
		if ($res == 1) { //签名验证通过才可
			
			//接口查询是否数据库已更新
			$result_arr = $unionpay->query($orderId, $txnTime);
			
			if (empty($result_arr)) return 0; //为空代表交易失败了
			
			if ($result_arr['txnType'] == '01') {  //消费完成执行
				
				return 1;
			} elseif ($result_arr['txnType'] == '04') { //退款执行
			
			}
		}
		return 0;
	}
	
}