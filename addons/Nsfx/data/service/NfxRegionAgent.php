<?php
/**
 * NfxRegionAgent.php
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

use addons\Nsfx\data\model\NfxCommissionRegionAgentModel;
use addons\Nsfx\data\model\NfxPromoterModel;
use addons\Nsfx\data\model\NfxPromoterRegionAgentModel;
use addons\Nsfx\data\model\NfxShopMemberAssociationModel;
use addons\Nsfx\data\model\NfxShopRegionAgentConfigModel;
use data\model\CityModel;
use data\model\DistrictModel;
use data\model\ProvinceModel;
use data\model\UserModel as UserModel;
use data\service\BaseService;
use data\service\Member;
use data\service\OrderQuery;

/**
 * 区域分销服务层
 */
class NfxRegionAgent extends BaseService
{
	
	/**
	 * 获取店铺区域分红配置
	 */
	public function getShopRegionAgentConfig($shop_id)
	{
		$shop_region_agent = new NfxShopRegionAgentConfigModel();
		$count = $shop_region_agent->where([ "shop_id" => $shop_id ])->count();
		if ($count == 0) {
			//默认添加
			$shop_region_agent = new NfxShopRegionAgentConfigModel();
			$data = array(
				"shop_id" => $shop_id,
				"create_time" => time()
			);
			$shop_region_agent->save($data);
		}
		$data = $shop_region_agent->get([ "shop_id" => $shop_id ]);
		return $data;
	}
	
	/**
	 * 配置店铺区域分红
	 */
	public function updateShopRegionAgentConfig($shop_id, $province_rate, $city_rate, $district_rate, $application_require_province, $application_require_city, $application_require_district)
	{
		$shop_region_agent = new NfxShopRegionAgentConfigModel();
		$shop_region_agent->startTrans();
		try {
			$data = array(
				"province_rate" => $province_rate,
				"city_rate" => $city_rate,
				"district_rate" => $district_rate,
				"application_require_province" => $application_require_province,
				"application_require_city" => $application_require_city,
				"application_require_district" => $application_require_district
			
			);
			$shop_region_agent->where([ "shop_id" => $shop_id ])->update($data);
			$shop_region_agent->commit();
			return 1;
		} catch (\Exception $e) {
			$shop_region_agent->rollback();
			return $e->getMessage();
		}
	}
	
	/**
	 * 获取区域分销
	 */
	public function getPromoterRegionAgent($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$promoter_region_agent = new NfxPromoterRegionAgentModel();
		$list = $promoter_region_agent->pageQuery($page_index, $page_size, $condition, $order, '*');
		if (!empty($list['data'])) {
			foreach ($list['data'] as $k => $v) {
				$province_name = "";
				$city_name = "";
				$district_name = "";
				$user = new UserModel();
				$userinfo = $user->where([ 'uid' => $v['uid'] ])->select();
				$list['data'][ $k ]['real_name'] = $userinfo[0]["nick_name"];
				$list['data'][ $k ]['user_tel'] = $userinfo[0]["user_tel"];
				
				$promoter = new NfxPromoterModel();
				$prometerinfo = $promoter->getInfo([ 'uid' => $v['uid'] ]);
				$list['data'][ $k ]['promoter_no'] = $prometerinfo['promoter_no'];
				$province = new ProvinceModel();
				$province_info = $province->getInfo(array( "province_id" => $v["agent_provinceid"] ), "*");
				if (!empty($province_info)) {
					$province_name = $province_info["province_name"];
				}
				$list['data'][ $k ]['province_name'] = $province_name;
				$city = new CityModel();
				$city_info = $city->getInfo(array( "city_id" => $v["agent_cityid"] ), "*");
				if (!empty($city_info)) {
					$city_name = $city_info["city_name"];
				}
				$list['data'][ $k ]['city_name'] = $city_name;
				$district = new DistrictModel();
				$district_info = $district->getInfo(array( "district_id" => $v["agent_districtid"] ), "*");
				if (!empty($district_info)) {
					$district_name = $district_info["district_name"];
				}
				$list['data'][ $k ]['district_name'] = $district_name;
			}
			
		}
		return $list;
		
	}
	
	/**
	 * 区域分销审核
	 */
	public function modifyPromoterRegionAgentIsAudit($shop_id, $is_audit, $region_agent_id, $province_id, $city_id, $district_id)
	{
		$promoter_region_agent = new NfxPromoterRegionAgentModel();
		$promoter_region_agent->startTrans();
		$promoter_region_agent_info = $promoter_region_agent->getInfo(array( "shop_id" => $shop_id, "region_agent_id" => $region_agent_id ), "agent_type,uid");
		try {
			if ($is_audit == 1) {
				$promoter_region_agent = new NfxPromoterRegionAgentModel();
				$data["is_audit"] = $is_audit;
				$agent_type = $promoter_region_agent_info["agent_type"];
				if ($agent_type == 1) {
					if ($province_id > 0) {
						$promoter_region_agent = new NfxPromoterRegionAgentModel();
						$count = $promoter_region_agent->where(array( "agent_provinceid" => $province_id, "shop_id" => $shop_id, "agent_type" => 1))->count();
						
						if ($count > 0) {
							return 0;
						}
					} else {
						return 0;
					}
					$data["agent_provinceid"] = $province_id;
				} else if ($agent_type == 2) {
					if ($city_id > 0) {
						$promoter_region_agent = new NfxPromoterRegionAgentModel();
						$count = $promoter_region_agent->where(array( "agent_provinceid" => $province_id, "agent_cityid" => $city_id, "shop_id" => $shop_id, "agent_type" => 2 ))->count();
						if ($count > 0) {
							return 0;
						}
					} else {
						return 0;
					}
					$data["agent_provinceid"] = $province_id;
					$data["agent_cityid"] = $city_id;
				} else if ($agent_type == 3) {
					if ($city_id > 0) {
						$promoter_region_agent = new NfxPromoterRegionAgentModel();
						$count = $promoter_region_agent->where(array( "agent_provinceid" => $province_id, "agent_cityid" => $city_id, "shop_id" => $shop_id, "agent_districtid" => $district_id, "agent_type" => 3 ))->count();
						if ($count > 0) {
							return 0;
						}
					} else {
						return 0;
					}
					$data["agent_provinceid"] = $province_id;
					$data["agent_cityid"] = $city_id;
					$data["agent_districtid"] = $district_id;
				}
				
				//修改
				$shop_member_association = new NfxShopMemberAssociationModel();
				$shop_member_association->save([ 'region_center_id' => $region_agent_id ], [ 'shop_id' => $shop_id, 'uid' => $promoter_region_agent_info['uid'] ]);
				
			} else if ($is_audit == -1) {
				$data["is_audit"] = -1;
			}
			
			if ($is_audit == 1 || $is_audit == -1) {
				$data["audit_time"] = time();
			} elseif ($is_audit == 1) {
				$data["cancel_time"] = time();
			}
			$condition = array(
				"shop_id" => $shop_id,
				"region_agent_id" => $region_agent_id
			);
			$retval = $promoter_region_agent->where($condition)->update($data);
			$promoter_region_agent->commit();
			return $retval;
		} catch (\Exception $e) {
			$promoter_region_agent->rollback();
			return 0;
		}
		
	}
	
	/**
	 * 申请区域分销
	 */
	public function promoterRegionAgentApplay($shop_id, $uid, $agent_type, $real_name, $mobile, $address)
	{
		$res = $this->getPromoterRegionAgentApplicationRequire($shop_id, $agent_type, $uid);
		if ($res > 0) {
			$shop_member_association = new NfxShopMemberAssociationModel();
			$shop_member_association_info = $shop_member_association->get(array( "uid" => $uid ));
			$promoter_id = $shop_member_association_info["promoter_id"];
			$promoter_region_agent = new NfxPromoterRegionAgentModel();
			$data = array(
				"shop_id" => $shop_id,
				"promoter_id" => $promoter_id,
				"uid" => $uid,
				"agent_type" => $agent_type,
				"reg_time" => time(),
				"real_name" => $real_name,
				"agent_mobile" => $mobile,
				"agent_address" => $address
			);
			$promoter_region_agent->save($data);
			return $promoter_region_agent->region_agent_id;
			
		} else {
			return 0;
		}
	}
	
	/**
	 * 区域分销分红佣金
	 */
	public function getCommissionRegionAgentList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$order_query = new OrderQuery();
		$order_list = $order_query->getOrderList($page_index, $page_size, $condition, $order);
		foreach ($order_list["data"] as $k => $v) {
			$commission_money = 0;
			
			foreach ($v["order_item_list"] as $l => $b) {
				$order_item = $v["order_item_list"][ $l ];
				$commission_region_agent = new NfxCommissionRegionAgentModel();
				$commission_region_agent_condition = array( "order_id" => $b["order_id"], "order_goods_id" => $b["order_goods_id"] );
				$commission_region_agent_list = $commission_region_agent->all($commission_region_agent_condition);
				if (count($commission_region_agent_list) > 0) {
					foreach ($commission_region_agent_list as $commission_k => $commission_v) {
						$user = new UserModel();
						$userinfo = $user->getInfo([ 'uid' => $commission_v['uid'] ]);
						$commission_region_agent_list[ $commission_k ]['real_name'] = $userinfo["nick_name"];
						$commission_money = $commission_money + $commission_v["commission"];
						$promoter = new NfxPromoterModel();
						$prometerinfo = $promoter->getInfo([ 'uid' => $commission_v['uid'] ]);
						$commission_region_agent_list[ $commission_k ]['promoter_no'] = $prometerinfo['promoter_no'];
						$commission_region_agent_list[ $commission_k ]['promoter_shop_name'] = $prometerinfo['promoter_shop_name'];
					}
				}
				$order_item["commission_partner_list"] = $commission_region_agent_list;
			}
			$order_list["data"][ $k ]["commission_money"] = $commission_money;
		}
		return $order_list;
	}
	
	/**
	 * 获取代理详情
	 */
	public function getPromoterRegionAgentValidDetail($shop_id, $uid)
	{
		$promoter_region_agent = new NfxPromoterRegionAgentModel();
		$data = $promoter_region_agent->where(array( "shop_id" => $shop_id, "uid" => $uid ))->order("region_agent_id desc")->limit(0, 1)->select();
		return empty($data) ? '' : $data[0];
	}
	
	/**
	 * 获取代理
	 */
	public function getPromoterRegionAgentAll($condition)
	{
		$promoter_region_agent = new NfxPromoterRegionAgentModel();
		$promoter_region_agent_all = $promoter_region_agent->all($condition);
		return $promoter_region_agent_all;
	}
	
	/**
	 * 获取区域分销申请条件
	 */
	public function getPromoterRegionAgentApplicationRequire($shop_id, $agent_type, $uid)
	{
		$shop_region_agent = new NfxShopRegionAgentConfigModel();
		$application_require = $shop_region_agent->getInfo(array( "shop_id" => $shop_id ), "*");
		if ($agent_type == 1) {
			$application_require_money = $application_require["application_require_province"];
		} else if ($agent_type == 2) {
			$application_require_money = $application_require["application_require_city"];
		} else {
			$application_require_money = $application_require["application_require_district"];
		}
		$member_service = new Member();
		$shop_user_account = $member_service->getShopUserConsume($uid);
		if ($shop_user_account < $application_require_money) {
			return 0;
		} else {
			return 1;
		}
	}
	
	/**
	 * 获取区域分销分红
	 */
	public function getRegionAgentCommissionCount($condition)
	{
		$region_agent_commission = new NfxCommissionRegionAgentModel();
		$result = $region_agent_commission->getQuery($condition, "sum(commission) as sum");
		return $result[0]["sum"];
	}
	
	/**
	 * 删掉区域分销资格
	 */
	public function removePromoterRegionAgent($shop_id, $region_agent_id)
	{
		$promoter_region_agent = new NfxPromoterRegionAgentModel();
		$promoter_region_agent->startTrans();
		$promoter_region_agent_info = $promoter_region_agent->getInfo(array( "shop_id" => $shop_id, "region_agent_id" => $region_agent_id ), "agent_type,uid");
		try {
			$retval = $promoter_region_agent->destroy(array( "shop_id" => $shop_id, "region_agent_id" => $region_agent_id ));
			//修改
			$shop_member_association = new NfxShopMemberAssociationModel();
			$shop_member_association->save([ 'region_center_id' => 0 ], [ 'shop_id' => $shop_id, 'uid' => $promoter_region_agent_info['uid'] ]);
			$promoter_region_agent->commit();
			return $retval;
		} catch (\Exception $e) {
			$promoter_region_agent->rollback();
			return 0;
		}
	}
	
	/**
	 * 获取推广员佣金列表
	 */
	public function getCommissionPageList($page_index = 1, $page_size = PAGESIZE, $condition = [], $order = '', $field = '*')
	{
		$model = new NfxCommissionRegionAgentModel();
		$order_query = new OrderQuery();
		$list = $model->getViewList($page_index, $page_size, $condition, $order, $field);
		
		if (!empty($list['data'])) {
			foreach ($list['data'] as $item) {
				$order_status_info = $order_query->getOrderStatusInfo([ "order_type" => $item['order_type'], "order_status" => $item['order_status'], "shipping_type" => $item["shipping_type"] ]);
				$item['status_name'] = $order_status_info['status_name'];
			}
		}
		return $list;
	}
}