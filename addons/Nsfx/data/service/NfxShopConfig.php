<?php
/**
 * NfxShopConfig.php
 *
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

namespace addons\Nsfx\data\service;

use addons\Nsfx\data\model\NfxPromoterModel;
use addons\Nsfx\data\model\NfxShopConfigModel;
use data\model\UserModel as UserModel;
use data\service\BaseService;

class NfxShopConfig extends BaseService
{
	/**
	 * 店铺是否开启分销及分销商是否需要审核及分销商是否需要开启申请
	 */
	public function modifyShopConfigIsDistributionOrPromoterIsAudit($shop_id, $is_distribution_enableopen, $is_audit, $is_start, $is_set, $distribution_use)
	{
		$shop_config = new NfxShopConfigModel();
		$data = array(
			"is_distribution_enable" => $is_distribution_enableopen,
			"modify_date" => time() );
		if ($is_distribution_enableopen == 0) {
			$data["is_regional_agent"] = 0;
			$data["is_partner_enable"] = 0;
			$data["is_global_enable"] = 0;
			$data["is_distribution_audit"] = 0;
			$data["is_distribution_start"] = 0;
			$data["is_distribution_set"] = 0;
			$data["distribution_use"] = 0;
		} else {
			$data["is_distribution_audit"] = $is_audit;
			$data["is_distribution_start"] = $is_start;
			$data["distribution_use"] = $distribution_use;
			$data["is_distribution_set"] = $is_set;
			if ($is_set == 1) {
				//设置所有会员为分销商
				$user_model = new UserModel();
				$user_list = $user_model->getQuery('1=1');
				foreach ($user_list as $user_item) {
					$nfx_promoter_model = new NfxPromoterModel();
					$nfx_count = $nfx_promoter_model->getInfo([ 'uid' => $user_item['uid'] ], '*');
					if (empty($nfx_count)) {
						$nfx_promoter = new NfxPromoter();
						$nfx_promoter->promoterApplay($user_item['uid'], 0, empty($user_item['nick_name']) ? $user_item['user_name'] : $user_item['nick_name']);
					}
				}
				
			}
		}
		$retval = $shop_config->save($data, [ 'shop_id' => $shop_id ]);
		return $retval;
	}
	
	/**
	 * 是否开启区域分销
	 */
	public function modifyShopConfigIsRegionalAgent($shop_id, $is_open)
	{
		$shop_config = new NfxShopConfigModel();
		$data = [ "is_regional_agent" => $is_open, "modify_date" => time() ];
		$retval = $shop_config->where([ 'shop_id' => $shop_id ])->update($data);
		return $retval;
	}
	
	/**
	 * 股东分红是否开启
	 */
	public function modifyShopConfigIsPartnerEnable($shop_id, $is_open)
	{
		$shop_config = new NfxShopConfigModel();
		$data = [ "is_partner_enable" => $is_open, "modify_date" => time() ];
		$retval = $shop_config->where([ 'shop_id' => $shop_id ])->update($data);
		return $retval;
	}
	
	/**
	 * 全球分红
	 */
	public function modifyShopConfigIsGlobalEnable($shop_id, $is_open)
	{
		$shop_config = new NfxShopConfigModel();
		$data = array(
			"is_global_enable" => $is_open,
			"modify_date" => time()
		);
		$retval = $shop_config->where([ 'shop_id' => $shop_id ])->update($data);
		return $retval;
	}
	
	/**
	 * 店铺分销设置
	 */
	public function getShopConfigDetail()
	{
		$shop_config = new NfxShopConfigModel();
		$info = $shop_config->getInfo([ 'shop_id' => 0 ]);
		if (empty($info)) {
			//默认添加
			$data = array(
				"shop_id" => 0,
				"create_date" => time()
			);
			$shop_config->save($data);
			$shop_config = new NfxShopConfigModel();
			$info = $shop_config->getInfo([ 'shop_id' => 0 ]);
		}
		
		return $info;
	}
	
}