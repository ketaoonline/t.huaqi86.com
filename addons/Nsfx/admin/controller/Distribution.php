<?php
/**
 * Distribution.php
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

namespace addons\Nsfx\admin\controller;

use addons\Nsfx\data\service\NfxCommissionConfig;
use addons\Nsfx\data\service\NfxPartner;
use addons\Nsfx\data\service\NfxPartnerGlobalCalculate;
use addons\Nsfx\data\service\NfxPromoter;
use addons\Nsfx\data\service\NfxPromoter as NfxPromoterService;
use addons\Nsfx\data\service\NfxRegionAgent;
use addons\Nsfx\data\service\NfxShopConfig;
use addons\Nsfx\data\service\NfxUser;
use addons\Nsfx\data\service\NfxUser as NfxUserService;
use app\admin\controller\BaseController;
use data\service\Address;
use data\service\GoodsGroup as GoodsGroup;
use data\service\Member;
use data\service\promotion\PromoteRewardRule;


/**
 * 分销控制器
 */
class Distribution extends BaseController
{
	
	public $addon_view_path;
	
	public function __construct()
	{
		parent::__construct();
		$this->addon_view_path = ADDON_DIR . '/Nsfx/template/';
	}
	
	/**
	 * 分销商列表
	 */
	public function promoterList()
	{
		if (request()->isAjax()) {
			$promoter = new NfxPromoterService();
			$pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : '';
			$is_audit = request()->post('is_audit', '');
			$start_date = request()->post('start_date') == "" ? 0 : getTimeTurnTimeStamp(request()->post('start_date'));
			$end_date = request()->post('end_date') == "" ? 0 : getTimeTurnTimeStamp(request()->post('end_date'));
			$up_bianhao = request()->post("up_bianhao", "");
			
			if ($up_bianhao) {
				$tuiguang_member = $promoter->getTuiGuangDetail($up_bianhao);
				$condition['parent_promoter'] = $tuiguang_member['promoter_id'];
			}
			
			if ($start_date != 0 && $end_date != 0) {
				$condition["regidter_time"] = [
					[
						">",
						$start_date
					],
					[
						"<",
						$end_date
					]
				];
			} elseif ($start_date != 0 && $end_date == 0) {
				$condition["regidter_time"] = [
					[
						">",
						$start_date
					]
				];
			} elseif ($start_date == 0 && $end_date != 0) {
				$condition["regidter_time"] = [
					[
						"<",
						$end_date
					]
				];
			}
			if ($is_audit === "") {
				$condition["is_audit"] = [
					"<>",
					1
				];
			} else {
				$condition["is_audit"] = $is_audit;
			}
			
			$where = array();
			if ($_POST['user_name'] != "") {
				$where["nick_name"] = array(
					"like",
					"%" . trim($_POST['user_name']) . "%"
				);
			}
			if ($_POST['user_phone'] != "") {
				$where["user_tel"] = trim($_POST['user_phone']);
			}
			if (!empty($where)) {
				
				$uid_string = $this->getUserUids($where);
				
				if ($uid_string != "") {
					$condition["uid"] = array(
						"in",
						$uid_string
					);
				} else {
					$condition["uid"] = 0;
				}
			}
			$condition["shop_id"] = $this->instance_id;
			$list = $promoter->getPromoterList($pageindex, PAGESIZE, $condition, 'regidter_time desc');
			return $list;
		} else {
			$is_audit = isset($_GET['is_audit']) ? $_GET['is_audit'] : 1;
			$this->assign("is_audit", $is_audit);
			
			if ($is_audit == 1) {
				$promoter = new NfxPromoterService();
				$level_list = $promoter->getPromoterLevelAll($this->instance_id);
				$this->assign("level_list", $level_list);
				$child_menu_list = array(
					array(
						'module' => 'nsfx',
						'url' => "Distribution/promoterList",
						'menu_name' => "分销商",
						"active" => 1
					),
					array(
						'module' => 'nsfx',
						'url' => "Distribution/promoterList?is_audit=0",
						'menu_name' => "待审核",
						"active" => 0
					)
				);
				$this->assign('child_menu_list', $child_menu_list);
				return view($this->addon_view_path . $this->style . "Distribution/promoterList.html");
			} else {
				$child_menu_list = array(
					array(
						'module' => 'nsfx',
						'url' => "Distribution/promoterList",
						'menu_name' => "分销商",
						"active" => 0
					),
					array(
						'module' => 'nsfx',
						'url' => "Distribution/promoterList?is_audit=0",
						'menu_name' => "待审核",
						"active" => 1
					)
				);
				$this->assign('child_menu_list', $child_menu_list);
				return view($this->addon_view_path . $this->style . "Distribution/promoterAuditList.html");
			}
		}
	}
	
	/**
	 * 分销商审核
	 */
	public function promoterAudit()
	{
		$promoter_id = request()->post("promoter_id", 0);
		$is_audit = request()->post("is_audit", 0);
		$uid = request()->post("uid", 0);
		$promoter = new NfxPromoterService();
		$res = $promoter->promoterAudit($promoter_id, $is_audit, $this->instance_id);
		return AjaxReturn($res);
	}
	
	/**
	 * 分销商等级
	 */
	public function promoterLevelList()
	{
		if (request()->isAjax()) {
			$promoter = new NfxPromoterService();
			$pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : '';
			$condition = array(
				'shop_id' => $this->instance_id
			);
			$list = $promoter->getPromoterLevelList($pageindex, PAGESIZE, $condition, '');
			return $list;
		} else {
			$child_menu_list = array(
				array(
					'module' => 'nsfx',
					'url' => "distribution/threeLeveldistributionconfig",
					'menu_name' => "基本设置",
					"active" => 0
				),
				array(
					'module' => 'nsfx',
					'url' => "distribution/promoterlevelList",
					'menu_name' => "分销商等级",
					"active" => 1
				)
			);
			$this->assign('child_menu_list', $child_menu_list);
			return view($this->addon_view_path . $this->style . "Distribution/promoterLevelList.html");
		}
	}
	
	/**
	 * 添加店铺分销商等级
	 */
	public function addPromoterLevel()
	{
		if (request()->isAjax()) {
			$level_name = request()->post("level_name", 0);
			$level_money = request()->post("level_money", 0);
			$level_0 = request()->post("level_0", 0);
			$level_1 = request()->post("level_1", 0);
			$level_2 = request()->post("level_2", 0);
			$promoter = new NfxPromoterService();
			$res = $promoter->addPromoterLevel($this->instance_id, $level_name, $level_money, $level_0, $level_1, $level_2);
			return AjaxReturn($res);
		} else {
			return view($this->addon_view_path . $this->style . "Distribution/addPromoterLevel.html");
		}
	}
	
	/**
	 * 商品分销列表
	 */
	public function goodsCommissionRateList()
	{
		if (request()->isAjax()) {
			$commission_config = new NfxCommissionConfig();
			$pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : '';
			$start_date = request()->post('start_date') == "" ? 0 : getTimeTurnTimeStamp(request()->post('start_date'));
			$end_date = request()->post('end_date') == "" ? 0 : getTimeTurnTimeStamp(request()->post('end_date'));
			$goods_name = isset($_POST['goods_name']) ? $_POST['goods_name'] : '';
			$is_open = isset($_POST['is_open']) ? $_POST['is_open'] : '';
			if ($start_date != 0 && $end_date != 0) {
				$condition["ng.create_time"] = [
					[
						">",
						$start_date
					],
					[
						"<",
						$end_date
					]
				];
			} elseif ($start_date != 0 && $end_date == 0) {
				$condition["create_time"] = [
					[
						">",
						$start_date
					]
				];
			} elseif ($start_date == 0 && $end_date != 0) {
				$condition["create_time"] = [
					[
						"<",
						$end_date
					]
				];
			}
			if (!empty($goods_name)) {
				$condition["ng.goods_name"] = array(
					"like",
					"%" . $goods_name . "%"
				);
			}
			$condition["ng.shop_id"] = $this->instance_id;
			$list = $commission_config->getGoodsCommissionRateList($pageindex, PAGESIZE, $condition, 'ng.create_time desc');
			// 根据商品分组id，查询标签名称
			foreach ($list['data'] as $k => $v) {
				if (!empty($v['group_id_array'])) {
					$goods_group_id = explode(',', $v['group_id_array']);
					$goods_group_name = '';
					foreach ($goods_group_id as $key => $val) {
						$goods_group = new GoodsGroup();
						$goods_group_info = $goods_group->getGoodsGroupDetail($val);
						if (!empty($goods_group_info)) {
							$goods_group_name .= $goods_group_info['group_name'] . ',';
						}
					}
					$goods_group_name = rtrim($goods_group_name, ',');
					$list["data"][ $k ]['goods_group_name'] = $goods_group_name;
				}
			}
			return $list;
		} else {
			$goods_group = new GoodsGroup();
			$groupList = $goods_group->getGoodsGroupList(1, 0, [
				'shop_id' => $this->instance_id,
				'pid' => 0
			]);
			if (!empty($groupList['data'])) {
				foreach ($groupList['data'] as $k => $v) {
					$v['sub_list'] = $goods_group->getGoodsGroupList(1, 0, 'pid = ' . $v['group_id']);
				}
			}
			$this->assign("goods_group", $groupList['data']);
			return view($this->addon_view_path . $this->style . "Distribution/goodsCommissionRateList.html");
		}
	}
	
	/**
	 * 商品开启或关闭分销
	 */
	public function modifyGoodsDistribution()
	{
		$is_open = request()->post("is_open", 0);
		$condition = request()->post("goods_ids", 0);
		$commission_config = new NfxCommissionConfig();
		$res = $commission_config->modifyGoodsIsOpenDistribution($condition, $is_open);
		return AjaxReturn($res);
	}
	
	/**
	 * 获取商品分销信息
	 */
	public function getGoodsCommissionRateDetail()
	{
		$goods_id = request()->post("goods_id", 0);
		$commission_config = new NfxCommissionConfig();
		$res = $commission_config->getGoodsCommissionRate($goods_id);
		return $res;
	}
	
	/**
	 * 商品分销修改
	 */
	public function updateGoodsCommissionRate()
	{
		$commission_config = new NfxCommissionConfig();
		if (request()->isAjax()) {
			$condition_type = request()->post("condition_type", 1);
			$condition = request()->post("condition", 0);
			$distribution_commission_rate = request()->post("distribution_commission_rate", 0);
			$partner_commission_rate = request()->post("partner_commission_rate", 0);
			$global_commission_rate = request()->post("global_commission_rate", 0);
			$distribution_team_commission_rate = request()->post("distribution_team_commission_rate", 0);
			$partner_team_commission_rate = request()->post("partner_team_commission_rate", 0);
			$regionagent_commission_rate = request()->post("regionagent_commission_rate", 0);
			$channelagent_commission_rate = request()->post("channelagent_commission_rate", 0);
			$is_open = request()->post("is_open", 0);
			$retval = $commission_config->updateGoodsCommissionRate($condition, $condition_type, $distribution_commission_rate, $partner_commission_rate, $global_commission_rate, $distribution_team_commission_rate, $partner_team_commission_rate, $regionagent_commission_rate, $channelagent_commission_rate, $this->instance_id, $is_open);
			return AjaxReturn($retval);
		} else {
			$goods_id = $_GET["goods_id"];
			$this->assign("goods_id", $goods_id);
			$goods_info = $commission_config->getGoodsCommissionRate($goods_id);
			$this->assign("goods_info", $goods_info);
			return view($this->addon_view_path . $this->style . "Distribution/updateGoodsCommissionRate.html");
		}
	}
	
	/**
	 * 分销商详情
	 */
	public function getPromoterDetail()
	{
		$promoter_id = request()->post("promoter_id", 0);
		$promoter = new NfxPromoter();
		$res = $promoter->getPromoterDetail($promoter_id);
		return $res;
	}
	
	/**
	 * 修改分销商父级
	 */
	public function modifyPromoterParent()
	{
		if (request()->isAjax()) {
			$promoter_id = request()->post("promoter_id", 0);
			$parent_promoter = request()->post("parent_promoter", 0);
			$up_id = request()->post("up_id", "");
			$promoter = new NfxPromoterService();
			$retval = $promoter->modifyPromoterParent($promoter_id, $parent_promoter, $this->instance_id, $up_id);
			return AjaxReturn($retval);
		} else {
			$promoter_id = $_GET["promoter_id"];
			$parent_promoter = $_GET["parent_promoter"];
			$this->assign("promoter_id", $promoter_id);
			$this->assign("parent_promoter", $parent_promoter);
			return view($this->addon_view_path . $this->style . "Distribution/modifyPromoterParent.html");
		}
	}
	
	/**
	 * 判断分销商的下级
	 */
	public function selectUpTuiGuang()
	{
		$promoter = new NfxPromoterService();
		$up_id = request()->post("up_id", "");
		$parent_promoter = request()->post("parent_promoter", "");
		$res = $promoter->panduanTuiguan($up_id, $parent_promoter);
		return $res;
	}
	
	/**
	 * 分销商冻结/解冻
	 */
	public function modifyPromoterLock()
	{
		$is_lock = request()->post("is_lock", 0);
		$promoter_id = request()->post("promoter_id", 0);
		$promoter = new NfxPromoterService();
		$retval = $promoter->modifyPromoterLock($promoter_id, $is_lock);
		return AjaxReturn($retval);
	}
	
	/**
	 * 修改分销商等级
	 */
	public function updatePromoterLevel()
	{
		if (request()->isAjax()) {
			$level_id = request()->post("level_id", 0);
			$level_name = request()->post("level_name", '');
			$level_money = request()->post("level_money", 0);
			$level_0 = request()->post("level_0", 0);
			$level_1 = request()->post("level_1", 0);
			$level_2 = request()->post("level_2", 0);
			$promoter = new NfxPromoterService();
			$retval = $promoter->updatePromoterLevel($level_id, $level_name, $level_money, $level_0, $level_1, $level_2);
			return AjaxReturn($retval);
		} else {
			$level_id = $_GET["level_id"];
			$promoter = new NfxPromoterService();
			$res = $promoter->getPromoterLevalDetail($level_id);
			$this->assign("premoter_level_info", $res);
			$this->assign("level_id", $level_id);
			return view($this->addon_view_path . $this->style . "Distribution/updatePromoterLevel.html");
		}
	}
	
	/**
	 * 三级分销
	 */
	public function threeLevelDistributionConfig()
	{
		$shop_config = new NfxShopConfig();
		$shop_config_info = $shop_config->getShopConfigDetail();
		$this->assign("shop_config_info", $shop_config_info);
		$child_menu_list = array(
			array(
				'module' => 'nsfx',
				'url' => "Distribution/threeLevelDistributionConfig",
				'menu_name' => "基本设置",
				"active" => 1
			),
			array(
				'module' => 'nsfx',
				'url' => "Distribution/promoterLevelList",
				'menu_name' => "分销商等级",
				"active" => 0
			)
		);
		$this->assign('child_menu_list', $child_menu_list);
		return view($this->addon_view_path . $this->style . "Distribution/threeLevelDistributionConfig.html");
	}
	
	/**
	 * 是否开启三级分销及是否开启分销商shenhe
	 *
	 * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
	 */
	public function modifyShopConfigIsDistributionOrPromoterIsAudit()
	{
		$is_open = request()->post("is_open", 0);
		$is_audit = request()->post("is_audit", 0);
		$is_start = request()->post("is_start", 0);
		$is_set = request()->post("is_set", 0);
		$distribution_use = request()->post("distribution_use", 0);
		$shop_config = new NfxShopConfig();
		$retval = $shop_config->modifyShopConfigIsDistributionOrPromoterIsAudit($this->instance_id, $is_open, $is_audit, $is_start, $is_set, $distribution_use);
		return AjaxReturn($retval);
	}
	
	/**
	 * 区域分销
	 */
	public function regionalAgent()
	{
		$shop_config = new NfxShopConfig();
		$shop_config_info = $shop_config->getShopConfigDetail();
		$this->assign("shop_config_info", $shop_config_info);
		$child_menu_list = array(
			array(
				'module' => 'nsfx',
				'url' => "Distribution/regionalAgent",
				'menu_name' => "基本设置",
				"active" => 1
			),
			array(
				'module' => 'nsfx',
				'url' => "Distribution/promoterRegionAgentList",
				'menu_name' => "人员管理",
				"active" => 0
			)
		);
		$region_agent = new NfxRegionAgent();
		$region_agent_info = $region_agent->getShopRegionAgentConfig(0);
		$this->assign("region_agent_info", $region_agent_info);
		$this->assign('child_menu_list', $child_menu_list);
		return view($this->addon_view_path . $this->style . "Distribution/regionalAgent.html");
	}
	
	/**
	 * 店铺代理配置
	 */
	public function UpdateShopRegionAgentConfig()
	{
		if (request()->isAjax()) {
			// 修改区域分销配置
			$province_rate = request()->post("province_rate", 0);
			$city_rate = request()->post("city_rate", 0);
			$district_rate = request()->post("district_rate", 0);
			$application_require_province = request()->post("application_require_province", 0);
			$application_require_city = request()->post("application_require_city", 0);
			$application_require_district = request()->post("application_require_district", 0);
			$region_agent = new NfxRegionAgent();
			$retval = $region_agent->updateShopRegionAgentConfig($this->instance_id, $province_rate, $city_rate, $district_rate, $application_require_province, $application_require_city, $application_require_district);
			return ajaxReturn($retval);
		} else {
			$child_menu_list = array(
				array(
					'module' => 'nsfx',
					'url' => "Distribution/regionalAgent",
					'menu_name' => "基本设置",
					"active" => 0
				),
				array(
					'module' => 'nsfx',
					'url' => "Distribution/promoterRegionAgentList",
					'menu_name' => "人员管理",
					"active" => 0
				)
			);
			$this->assign('child_menu_list', $child_menu_list);
			$region_agent = new NfxRegionAgent();
			$region_agent_info = $region_agent->getShopRegionAgentConfig($this->instance_id);
			$this->assign("region_agent_info", $region_agent_info);
			return view($this->addon_view_path . $this->style . "Distribution/UpdateShopRegionAgentConfig.html");
		}
	}
	
	/**
	 * 获取区域列表
	 *
	 */
	public function getAddressList()
	{
		$address = new Address();
		$province_list = $address->getProvinceList();
		$city_list = $address->getCityList();
		$district_list = $address->getDistrictList();
		$address_list = array();
		$address_list["province_list"] = $province_list;
		$address_list["city_list"] = $city_list;
		$address_list["district_list"] = $district_list;
		return $address_list;
	}
	
	/**
	 * 获得省级列表
	 */
	public function getProvinceList()
	{
		$address = new Address();
		$list = $address->getProvinceList();
		return $list;
	}
	
	/**
	 *获得市
	 */
	public function getCityList()
	{
		$province_id = request()->post("province_id", 0);
		$address = new Address();
		$list = $address->getCityList($province_id);
		return $list;
	}
	
	/**
	 * 获得县
	 */
	public function getDistrictList()
	{
		$city_id = request()->post("city_id", 0);
		$address = new Address();
		$list = $address->getDistrictList($city_id);
		return $list;
	}
	
	/**
	 * 区域分销审核
	 */
	public function modifyPromoterRegionAgentIsAudit()
	{
		$is_audit = isset($_POST["is_audit"]) ? $_POST["is_audit"] : "";
		$region_agent_id = isset($_POST["region_agent_id"]) ? $_POST["region_agent_id"] : "";
		
		$province_id = isset($_POST["province_id"]) ? $_POST["province_id"] : 0;
		$city_id = isset($_POST["city_id"]) ? $_POST["city_id"] : 0;
		$district_id = isset($_POST["district_id"]) ? $_POST["district_id"] : 0;
		
		$region_agent = new NfxRegionAgent();
		$retval = $region_agent->modifyPromoterRegionAgentIsAudit($this->instance_id, $is_audit, $region_agent_id, $province_id, $city_id, $district_id);
		return AjaxReturn($retval);
	}
	
	/**
	 * 区域分销人员管理
	 */
	function promoterRegionAgentList()
	{
		if (request()->isAjax()) {
			$region_agent = new NfxRegionAgent();
			$pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : '';
			$start_date = request()->post('start_date') == "" ? 0 : getTimeTurnTimeStamp(request()->post('start_date'));
			$end_date = request()->post('end_date') == "" ? 0 : getTimeTurnTimeStamp(request()->post('end_date'));
			$agent_type = !empty($_POST['agent_type']) ? $_POST['agent_type'] : 0;
			$is_audit = !empty($_POST['is_audit']) ? $_POST['is_audit'] : '10';
			
			$condition = array( 'shop_id' => $this->instance_id );
			
			if ($is_audit != 10) {
				$condition["is_audit"] = $is_audit;
			}
			
			if ($agent_type != 0) {
				$condition["agent_type"] = $agent_type;
			}
			if ($start_date != 0 && $end_date != 0) {
				$condition["reg_time"] = [
					[
						">",
						$start_date
					],
					[
						"<",
						$end_date
					]
				];
			} elseif ($start_date != 0 && $end_date == 0) {
				$condition["reg_time"] = [
					[
						">",
						$start_date
					]
				];
			} elseif ($start_date == 0 && $end_date != 0) {
				$condition["reg_time"] = [
					[
						"<",
						$end_date
					]
				];
			}
			if ($_POST['user_name'] != "") {
				$where = array(
					"nick_name" => array(
						"like",
						"%" . $_POST['user_name'] . "%"
					)
				);
				$uid_string = $this->getUserUids($where);
				if ($uid_string != "") {
					$condition["uid"] = array(
						"in",
						$uid_string
					);
				}
			}
			
			$list = $region_agent->getPromoterRegionAgent($pageindex, PAGESIZE, $condition, 'reg_time desc');
			return $list;
		} else {
			// $address = new Address();
			// $province_list = $address->getProvinceList();
			// $city_list = $address->getCityList();
			// $district_list = $address->getDistrictList();
			// $this->assign("province_list",$province_list);
			// $this->assign("city_list",$city_list);
			// $this->assign("district_list",$district_list);
			$child_menu_list = array(
				array(
					'module' => 'nsfx',
					'url' => "Distribution/regionalAgent",
					'menu_name' => "基本设置",
					"active" => 0
				),
				array(
					'module' => 'nsfx',
					'url' => "Distribution/promoterRegionAgentList",
					'menu_name' => "人员管理",
					"active" => 1
				)
			);
			
			$this->assign('child_menu_list', $child_menu_list);
			return view($this->addon_view_path . $this->style . "Distribution/promoterRegionAgentList.html");
		}
	}
	
	/**
	 * 是否开启区域分销
	 *
	 * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
	 */
	public function modifyShopConfigIsRegionalAgent()
	{
		$is_open = request()->post("is_open", 0);
		$shop_config = new NfxShopConfig();
		$retval = $shop_config->modifyShopConfigIsRegionalAgent($this->instance_id, $is_open);
		return AjaxReturn($retval);
	}
	
	/**
	 * 股东分红
	 */
	public function shareholderDividendsConfig()
	{
		$partner = new NfxPartner();
		$partner_level_list = $partner->getPartnerLevelAll($this->instance_id);
		$this->assign("partner_level_list", $partner_level_list);
		$shop_config = new NfxShopConfig();
		$shop_config_info = $shop_config->getShopConfigDetail();
		$this->assign("shop_config_info", $shop_config_info);
		$child_menu_list = array(
			array(
				'module' => 'nsfx',
				'url' => "Distribution/shareholderDividendsConfig",
				'menu_name' => "基本设置",
				"active" => 1
			),
			array(
				'module' => 'nsfx',
				'url' => "Distribution/partnerList",
				'menu_name' => "人员管理",
				"active" => 0
			)
		);
		
		$this->assign('child_menu_list', $child_menu_list);
		
		return view($this->addon_view_path . $this->style . "Distribution/shareholderDividendsConfig.html");
	}
	
	
	/**
	 * 具体项的佣金明细
	 */
	public function userAccountRecordsDetail()
	{
		$condition['uid'] = request()->post('uid', '');
		$condition['shop_id'] = request()->post('shop_id', '');
		$condition['account_type'] = request()->post('type_id', '');
		$nfx_user = new NfxUserService();
		
		$account_records_detail = $nfx_user->getNfxUserAccountRecordsList(1, 0, $condition, 'create_time desc');
		return $account_records_detail;
	}
	
	
	/**
	 * 是否开启股东分红
	 *
	 * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
	 */
	public function modifyShopConfigIsPartnerEnable()
	{
		$is_open = request()->post("is_open", 0);
		$shop_config = new NfxShopConfig();
		$retval = $shop_config->modifyShopConfigIsPartnerEnable($this->instance_id, $is_open);
		return AjaxReturn($retval);
	}
	
	/**
	 * 全球分红
	 */
	public function globalBonusPoolConfig()
	{
		$shop_config = new NfxShopConfig();
		$shop_config_info = $shop_config->getShopConfigDetail();
		$this->assign("shop_config_info", $shop_config_info);
		$partner = new NfxPartner();
		$partner_level_list = $partner->getPartnerLevelAll($this->instance_id);
		$this->assign("partner_level_list", $partner_level_list);
		$child_menu_list = array(
			array(
				'module' => 'nsfx',
				'url' => "Distribution/globalBonusPoolConfig",
				'menu_name' => "基本设置",
				"active" => 1
			),
			array(
				'module' => 'nsfx',
				'url' => "Distribution/globalBonusPoolPut",
				'menu_name' => "发放分红",
				"active" => 0
			),
			array(
				'module' => 'nsfx',
				'url' => "Distribution/commissionPartnerGlobalRecordsList",
				'menu_name' => "发放记录",
				"active" => 0
			)
		);
		$this->assign('child_menu_list', $child_menu_list);
		// $partner = new NfxPartner();
		// $partner_level_list = $partner->getPartnerLevelAll($this->instance_id);
		// $this->assign("partner_level_list",$partner_level_list);
		return view($this->addon_view_path . $this->style . "Distribution/globalBonusPoolConfig.html");
	}
	
	/**
	 * 全球分红发放流水
	 *
	 * @return multitype:number unknown |Ambigous <\think\response\View, \think\response\$this, \think\response\View>
	 */
	public function commissionPartnerGlobalRecordsList()
	{
		if (request()->isAjax()) {
			$partner = new NfxPartner();
			$pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : '';
			$condition = array(
				'shop_id' => $this->instance_id
			);
			$list = $partner->getCommissionPartnerGlobalRecordsList($pageindex, PAGESIZE, $condition, '');
			return $list;
		} else {
			$child_menu_list = array(
				array(
					'module' => 'nsfx',
					'url' => "Distribution/globalBonusPoolConfig",
					'menu_name' => "基本设置",
					"active" => 0
				),
				array(
					'module' => 'nsfx',
					'url' => "Distribution/globalBonusPoolPut",
					'menu_name' => "发放分红",
					"active" => 0
				),
				array(
					'module' => 'nsfx',
					'url' => "Distribution/commissionPartnerGlobalRecordsList",
					'menu_name' => "发放记录",
					"active" => 1
				)
			);
			$this->assign('child_menu_list', $child_menu_list);
			return view($this->addon_view_path . $this->style . "Distribution/commissionPartnerGlobalRecordsList.html");
		}
	}
	
	/**
	 * 分红权重设置
	 */
	public function updateGlobalBonusPoolConfig()
	{
		if (request()->isAjax()) {
			$partner_level_string = request()->post("partner_level_string", '');
			$level_array = explode(';', $partner_level_string);
			foreach ($level_array as $k => $v) {
				$level_array[ $k ] = explode(",", $v);
			}
			$partner = new NfxPartner();
			$retval = $partner->updatePartnerGlobal($level_array, $this->instance_id);
			return AjaxReturn($retval);
		} else {
			$child_menu_list = array(
				array(
					'module' => 'nsfx',
					'url' => "Distribution/globalBonusPoolConfig",
					'menu_name' => "基本设置",
					"active" => 0
				),
				array(
					'module' => 'nsfx',
					'url' => "Distribution/globalBonusPoolPut",
					'menu_name' => "发放分红",
					"active" => 0
				),
				array(
					'module' => 'nsfx',
					'url' => "Distribution/commissionPartnerGlobalRecordsList",
					'menu_name' => "发放记录",
					"active" => 0
				)
			);
			$this->assign('child_menu_list', $child_menu_list);
			$partner = new NfxPartner();
			$partner_level_list = $partner->getPartnerLevelAll($this->instance_id);
			$this->assign("partner_level_list", $partner_level_list);
			return view($this->addon_view_path . $this->style . "Distribution/updateGlobalBonusPoolConfig.html");
		}
	}
	
	/**
	 * 是否开启全球分红
	 *
	 * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
	 */
	public function modifyShopConfigIsGlobalEnable()
	{
		$is_open = $_POST["is_open"];
		$shop_config = new NfxShopConfig();
		$retval = $shop_config->modifyShopConfigIsGlobalEnable($this->instance_id, $is_open);
		return AjaxReturn($retval);
	}
	
	/**
	 * ******************************************************股东 分销商分界线************************************************
	 */
	
	/**
	 * 股东列表
	 */
	public function partnerList()
	{
		if (request()->isAjax()) {
			$partner = new NfxPartner();
			$pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : '';
			$is_audit = isset($_POST['is_audit']) ? $_POST['is_audit'] : '';
			$condition = array(
				'shop_id' => $this->instance_id
			);
			if ($is_audit != "") {
				$condition["is_audit"] = $is_audit;
			}
			if ($_POST['user_name'] != "") {
				$where = array(
					"nick_name" => array(
						"like",
						"%" . $_POST['user_name'] . "%"
					)
				);
				$uid_string = $this->getUserUids($where);
				if ($uid_string != "") {
					$condition["uid"] = array(
						"in",
						$uid_string
					);
				}
			}
			$list = $partner->getPartnerList($pageindex, PAGESIZE, $condition, 'register_time desc');
			return $list;
		} else {
			$child_menu_list = array(
				array(
					'module' => 'nsfx',
					'url' => "Distribution/shareholderDividendsConfig",
					'menu_name' => "基本设置",
					"active" => 0
				),
				array(
					'module' => 'nsfx',
					'url' => "Distribution/partnerList",
					'menu_name' => "人员管理",
					"active" => 1
				)
			);
			$partner = new NfxPartner();
			$partner_level_list = $partner->getPartnerLevelAll($this->instance_id);
			$this->assign("partner_level_list", $partner_level_list);
			$this->assign('child_menu_list', $child_menu_list);
			return view($this->addon_view_path . $this->style . "Distribution/partnerList.html");
		}
	}
	
	/**
	 * 股东等级列表
	 */
	public function partnerLevelList()
	{
		if (request()->isAjax()) {
			$partner = new NfxPartner();
			$pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : '';
			$condition = isset($_POST['condition']) ? $_POST['condition'] : '';
			$list = $partner->getPartnerLevelList($pageindex, PAGESIZE, $condition, '');
			return $list;
		} else {
			$child_menu_list = array(
				array(
					'module' => 'nsfx',
					'url' => "Distribution/shareholderDividendsConfig",
					'menu_name' => "基本设置",
					"active" => 0
				),
				array(
					'module' => 'nsfx',
					'url' => "Distribution/partnerList",
					'menu_name' => "人员管理",
					"active" => 0
				)
			);
			$partner = new NfxPartner();
			$partner_level_list = $partner->getPartnerLevelAll($this->instance_id);
			$this->assign("partner_level_list", $partner_level_list);
			
			$shop_config = new NfxShopConfig();
			$shop_config_info = $shop_config->getShopConfigDetail();
			$this->assign("shop_config_info", $shop_config_info);
			$this->assign('child_menu_list', $child_menu_list);
			return view($this->addon_view_path . $this->style . "Distribution/partnerLevelList.html");
		}
	}
	
	/**
	 * 修改股东上级
	 */
	public function modifyPartherParnet()
	{
		$partner_id = request()->post('partner_id', '');
		$parent_no = request()->post('parent_no', '');
		$partner = new NfxPartner();
		$res = $partner->modifyPartherParnet($partner_id, $parent_no, $this->instance_id);
		return AjaxReturn($res);
	}
	
	/**
	 * 股东审核
	 */
	public function partnerAudit()
	{
		$partner_id = request()->post("partner_id", 0);
		$is_audit = request()->post("is_audit", 0);
		$uid = request()->post("uid", 0);
		
		$partner = new NfxPartner();
		$retval = $partner->partnerAudit($partner_id, $is_audit, $this->instance_id);
		if ($is_audit == 1 && $retval) {
			$promote_reward_rule = new PromoteRewardRule();
			$promote_reward_rule->RegisterPartnerSendPoint($this->instance_id, $uid);
			return AjaxReturn($retval);
		} else {
			return AjaxReturn($retval);
		}
	}
	
	/**
	 * 获取股东等级详情
	 */
	public function getPartnerLevelDetail()
	{
		$level_id = request()->post("level_id", 0);
		$partner = new NfxPartner();
		$res = $partner->getPartnerLevelDetail($level_id);
		return $res;
	}
	
	/**
	 * 修改股东等级
	 */
	public function updatePartnerLevel()
	{
		if (request()->isAjax()) {
			$level_id = request()->post("level_id", 0);
			$level_name = request()->post("level_name", '');
			$level_money = request()->post("level_money", '0');
			$commission_rate = request()->post("commission_rate", '0');
			$partner = new NfxPartner();
			$retval = $partner->updatePartnerLevel($level_id, $level_name, $level_money, $commission_rate, $this->instance_id);
			return AjaxReturn($retval);
		} else {
			$level_id = $_GET["level_id"];
			$partner = new NfxPartner();
			$partner_level_info = $partner->getPartnerLevelDetail($level_id);
			$this->assign("level_id", $level_id);
			$this->assign("partner_level_info", $partner_level_info);
			return view($this->addon_view_path . $this->style . "Distribution/updatePartnerLevel.html");
		}
	}
	
	/**
	 * 添加股东等级
	 */
	public function addPartnerLevel()
	{
		if (request()->isAjax()) {
			$level_name = request()->post("level_name", '');
			$level_money = request()->post("level_money", '');
			$commission_rate = request()->post("commission_rate", 0);
			$partner = new NfxPartner();
			$retval = $partner->addPartnerLevel($level_money, $level_name, $commission_rate, $this->instance_id);
			return AjaxReturn($retval);
		} else {
			return view($this->addon_view_path . $this->style . "Distribution/addPartnerLevel.html");
		}
	}
	
	/**
	 * 股东冻结/解冻
	 */
	public function modifyPartnerLock()
	{
		$partner_id = request()->post("partner_id", 0);
		$is_lock = request()->post("is_lock", 0);
		$partner = new NfxPartner();
		$retval = $partner->modifyPartnerLock($partner_id, $is_lock);
		return AjaxReturn($retval);
	}
	
	/**
	 * 发放分红
	 */
	public function globalBonusPoolPut()
	{
		if (request()->isAjax()) {
			$start_time = request()->post('start_time') == "" ? 0 : getTimeTurnTimeStamp(request()->post('start_time'));
			$end_time = request()->post('end_time') == "" ? 0 : getTimeTurnTimeStamp(request()->post('end_time'));
			$global_money = !empty($_POST['global_money']) ? $_POST['global_money'] : 0;
			$partner_global_calculate = new NfxPartnerGlobalCalculate();
			$retval = $partner_global_calculate->getPartnerGlobalCommission($this->instance_id, $start_time, $end_time, $global_money);
			return AjaxReturn($retval);
		} else {
			$child_menu_list = array(
				array(
					'module' => 'nsfx',
					'url' => "Distribution/globalBonusPoolConfig",
					'menu_name' => "基本设置",
					"active" => 0
				),
				array(
					'module' => 'nsfx',
					'url' => "Distribution/globalBonusPoolPut",
					'menu_name' => "发放分红",
					"active" => 1
				),
				array(
					'module' => 'nsfx',
					'url' => "Distribution/commissionPartnerGlobalRecordsList",
					'menu_name' => "发放记录",
					"active" => 0
				)
			);
			$this->assign("end_time", date('Y-m-d', time()));
			$this->assign('child_menu_list', $child_menu_list);
			$partner_global_calculate = new NfxPartnerGlobalCalculate();
			$partner_global_calculate_info = $partner_global_calculate->getPartnerGlobalLastInfo();
			$partner = new NfxPartner();
			$partnerLevelGlobalList = $partner->getPartnerLevelGlobalList($this->instance_id);
			
			$shop_config = new NfxShopConfig();
			$shop_config_info = $shop_config->getShopConfigDetail();
			$this->assign("is_global_enable", $shop_config_info["is_global_enable"]);
			if (!empty($partner_global_calculate_info)) {
				$partner_global_calculate_info["end_time"] = date("Y-m-d", $partner_global_calculate_info["end_time"]);
			}
			$this->assign("partner_global_calculate_info", $partner_global_calculate_info);
			$this->assign("partner_level_global_list", $partnerLevelGlobalList);
			return view($this->addon_view_path . $this->style . "Distribution/globalBonusPoolPut.html");
		}
	}
	
	/**
	 * 查询某个店铺指定之间内可分红金额
	 */
	public function getPartnerGlobalLastInfo()
	{
		$start_time = request()->post('start_time') == "" ? 0 : getTimeTurnTimeStamp(request()->post('start_time'));
		$end_time = request()->post('end_time') == "" ? 0 : getTimeTurnTimeStamp(request()->post('end_time'));
//         $start_time = ! empty($_POST['start_time']) ? $_POST['start_time'] : '';
//         $end_time = ! empty($_POST['end_time']) ? $_POST['end_time'] : '';
		$partner_global_calculate = new NfxPartnerGlobalCalculate();
		$partner_global_last_info = $partner_global_calculate->getPartnerGlobalMoney($start_time, $end_time);
		return $partner_global_last_info;
	}
	
	/**
	 * 修改所有股东等级
	 *
	 * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
	 */
	public function updatePartnerLevelAll()
	{
		$partner_level_string = request()->post("partner_level_string", "");
		$level_array = explode(';', $partner_level_string);
		foreach ($level_array as $k => $v) {
			$level_array[ $k ] = explode(",", $v);
		}
		$partner = new NfxPartner();
		$retval = $partner->updatePartnerLevelAll($level_array, $this->instance_id);
		return AjaxReturn($retval);
	}
	
	/**
	 * 删除股东等级
	 *
	 * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
	 */
	function deletePartnerLevel()
	{
		$level_id = $_POST["level_id"];
		$partner = new NfxPartner();
		$retval = $partner->deletePartnerLevel($this->instance_id, $level_id);
		return ajaxReturn($retval);
	}
	
	/**
	 * 修改股东用户等级
	 *
	 * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
	 */
	public function modifyPartnerLevelNum()
	{
		$level_id = $_POST["level_id"];
		$uid = $_POST["uid"];
		$partner = new NfxPartner();
		$retval = $partner->modifyPartnerLevelNum($this->instance_id, $uid, $level_id);
		return ajaxReturn($retval);
	}
	
	/**
	 * 查寻符合条件的数据并返回id （多个以“,”隔开）
	 *
	 * @param unknown $condition
	 * @return string
	 */
	public function getUserUids($condition)
	{
		$member = new Member();
		$list = $member->getMemberAll($condition);
		$uid_string = "";
		foreach ($list as $k => $v) {
			$uid_string = $uid_string . "," . $v["uid"];
		}
		if ($uid_string != "") {
			$uid_string = substr($uid_string, 1);
		}
		return $uid_string;
	}
	
	/**
	 * 查寻符合条件的数据并返回id （多个以“,”隔开）
	 *
	 * @param unknown $condition
	 * @return string
	 */
	public function getGoodsCommissionGoodsids($condition)
	{
		$commission_config = new NfxCommissionConfig();
		$list = $commission_config->getGoodsCommiddionAll($condition);
		$goodsid_string = "";
		foreach ($list as $k => $v) {
			$goodsid_string = $goodsid_string . "," . $v["goods_id"];
		}
		if ($goodsid_string != "") {
			$goodsid_string = substr($goodsid_string, 1);
		}
		return $goodsid_string;
	}
	
	/**
	 * 删除分销商等级
	 *
	 * @return Ambigous <number, unknown>
	 */
	public function deletePromoterLevel()
	{
		$level_id = $_POST["level_id"];
		$promoter = new NfxPromoter();
		$retval = $promoter->deletePromoterLevel($this->instance_id, $level_id);
		return ajaxReturn($retval);
	}
	
	/**
	 * 删除分销商
	 *
	 * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
	 */
	public function deletePromoter()
	{
		$promoter_id = $_POST["promoter_id"];
		$promoter = new NfxPromoter();
		$retval = $promoter->deletePromoter($this->instance_id, $promoter_id);
		return ajaxReturn($retval);
	}
	
	/**
	 * 修改分销商的等级
	 *
	 * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
	 */
	public function modifyPromoterLevel()
	{
		$promoter_id = $_POST["promoter_id"];
		$level_id = $_POST["level_id"];
		$promoter = new NfxPromoter();
		$retval = $promoter->modifyPromoterLevel($this->instance_id, $promoter_id, $level_id);
		return ajaxReturn($retval);
	}
	
	/**
	 * 修改店铺名称
	 */
	public function modifyPromoterShopName()
	{
		$promoter_id = request()->post("promoter_id", 0);
		$promoter_shop_name = request()->post("promoter_shop_name", 0);
		$promoter = new NfxPromoter();
		$retval = $promoter->modifyShopName($this->instance_id, $promoter_id, $promoter_shop_name);
		return ajaxReturn($retval);
	}
	
	/**
	 * 我的团队
	 */
	public function teamList()
	{
		$nfx_promoter = new NfxPromoter();
		
		if (request()->isAjax()) {
			$promoter_id = request()->post("promoter_id", 0);
			$team_list = $nfx_promoter->getAdminPromoterTeamList($promoter_id);
			return $team_list;
		}
	}
	
	
	/**
	 * 验证是否存在该会员编号
	 */
	public function modifyPromoter()
	{
		$promoter_no = request()->post("promoter_no", '');
		$nfx_promoter = new NfxPromoter();
		$res = $nfx_promoter->modifyPromoterNo($promoter_no);
		return AjaxReturn($res);
	}
	
	/**
	 * 修改会员
	 */
	public function updateMember()
	{
		if (request()->isAjax()) {
			$nfx_promoter = new NfxPromoter();
			$uid = request()->post('uid', '');
			$promoter_no = request()->post('promoter_no', '');
			$res = $nfx_promoter->updateMemberByAdmin($uid, $promoter_no);
			return AjaxReturn($res);
		}
	}
	
	/**
	 * 订单数据excel导出
	 */
	public function memberDataExcel()
	{
		$promoter_id = request()->get("promoter_id", 0);
		$xlsName = "团队数据列表";
		$xlsCell = array(
			array( 'promoter_no', '编号' ),
			array( 'nick_name', '姓名' ),
			array( 'level_name', '等级' ),
			array( 'promoter_shop_name', '店铺名称' ),
			array( 'role_name', '角色' ),
			array( 'reg_time', '申请时间' ),
		);
		
		$nfx_promoter = new NfxPromoter();
		$team_list = $nfx_promoter->getAdminPromoterTeamList($promoter_id);
		$list = array();
		foreach ($team_list as $k => $v) {
			$list[ $k ]["promoter_no"] = $v['promoter_info']['promoter_no'];
			$list[ $k ]["nick_name"] = $v['user_info']['nick_name'];
			$list[ $k ]["level_name"] = $v['promoter_info']['level_name'];
			$list[ $k ]["promoter_shop_name"] = $v['promoter_info']['promoter_shop_name'];
			$list[ $k ]["role_name"] = $v['role_name'];
			$list[ $k ]["reg_time"] = getTimeStampTurnTime($v['user_info']["reg_time"]);
		}
		dataExcel($xlsName, $xlsCell, $list);
	}
	
	/**
	 * 分销商数据excel导出
	 */
	public function promoterDataExcel()
	{
		$xlsName = "分销商列表";
		$xlsCell = array(
			array(
				'promoter_no',
				'分销商编号'
			),
			array(
				'real_name',
				'姓名'
			),
			array(
				'level_name',
				'等级'
			),
			array(
				'promoter_shop_name',
				'店铺名称'
			),
			array(
				'team',
				'团队'
			),
			array(
				'order_total',
				'销售总额'
			),
			array(
				'parent_realname',
				'上级分销商'
			),
			array(
				'audit_status',
				'状态'
			),
			array(
				'apply_date',
				'申请时间'
			)
		);
		
		$promoter = new NfxPromoterService();
		$is_audit = request()->get('is_audit', '');
		$start_date = request()->get('start_date') == "" ? 0 : getTimeTurnTimeStamp(request()->get('start_date'));
		$end_date = request()->get('end_date') == "" ? 0 : getTimeTurnTimeStamp(request()->get('end_date'));
		if ($start_date != 0 && $end_date != 0) {
			$condition["regidter_time"] = [
				[
					">",
					$start_date
				],
				[
					"<",
					$end_date
				]
			];
		} elseif ($start_date != 0 && $end_date == 0) {
			$condition["regidter_time"] = [
				[
					">",
					$start_date
				]
			];
		} elseif ($start_date == 0 && $end_date != 0) {
			$condition["regidter_time"] = [
				[
					"<",
					$end_date
				]
			];
		}
		if ($is_audit === "") {
			$condition["is_audit"] = [
				"<>",
				1
			];
		} else {
			$condition["is_audit"] = $is_audit;
		}
		
		$where = array();
		if ($_GET['user_name'] != "") {
			$where["user_name"] = array(
				"like",
				"%" . trim($_GET['user_name']) . "%"
			);
		}
		if ($_GET['user_phone'] != "") {
			$where["user_tel"] = trim($_GET['user_phone']);
		}
		if (!empty($where)) {
			
			$uid_string = $this->getUserUids($where);
			
			if ($uid_string != "") {
				$condition["uid"] = array(
					"in",
					$uid_string
				);
			} else {
				$condition["uid"] = 0;
			}
		}
		$condition["shop_id"] = $this->instance_id;
		$list = $promoter->getPromoterList(1, 0, $condition, 'regidter_time desc');
		$list = $list["data"];
		foreach ($list as $k => $v) {
			$list[ $k ]["apply_date"] = getTimeStampTurnTime($v["regidter_time"]); // 创建时间
			$list[ $k ]["team"] = "分销商数:" . $v["promoter_num"] . "<br/>粉丝数:" . $v["fans_num"];  //团队
			$list[ $k ]["audit_status"] = $v["is_audit"] == 1 ? "已审核" : "已拒绝";
			$list[ $k ]["parent_realname"] = $v["parent_realname"] != null ? $v["parent_realname"] : "";
		}
		dataExcel($xlsName, $xlsCell, $list);
	}
	
	/**
	 * 区域分销取消资格
	 *
	 * @return multitype:number unknown |Ambigous <\think\response\View, \think\response\$this, \think\response\View>
	 */
	public function removePromoterRegionAgent()
	{
		$region_agent_id = request()->post("region_agent_id", 0);
		$region_agent = new NfxRegionAgent();
		$retval = $region_agent->removePromoterRegionAgent($this->instance_id, $region_agent_id);
		return AjaxReturn($retval);
	}
	
	/**
	 * 分销商账户详情
	 */
	public function promoterAccount()
	{
		$nfx_user = new NfxUser();
		if (request()->isAjax()) {
			$page_index = request()->post('page_index', '');
			$page_size = request()->post("page_size", PAGESIZE);
			
			$startDate = request()->post('startDate', 0);
			$endDate = request()->post('endDate', 0);
			$account_type = request()->post('account_type', '');
			
			$condition['shop_id'] = $this->instance_id;
			$uid = request()->post('uid', '');
			if (!empty($uid)) {
				$condition['uid'] = $uid;
			}
			
			$endDate = empty($endDate) ? time() : getTimeTurnTimeStamp($endDate);
			$startDate = empty($startDate) ? 0 : getTimeTurnTimeStamp($startDate);
			if (!empty($startDate) && !empty($endDate)) {
				
				$condition['create_time'] = array(
					'between time',
					array( $startDate, $endDate )
				);
			}
			
			if (!empty($account_type)) {
				$condition['account_type'] = $account_type;
			}
			
			$account_records_detail = $nfx_user->getPcNfxUserAccountRecordsList($page_index, $page_size, $condition, 'create_time desc');
			return $account_records_detail;
		}
		
		$uid = request()->get('uid', '');
		$this->assign('promoter_uid', $uid);
		
		//分销商基本信息
		$promoter = new NfxPromoterService();
		$condition = array(
			'uid' => $uid
		);
		$promoter_info = $promoter->getPromoterList(1, 1, $condition, '')['data'][0];
		$this->assign('promoter_info', $promoter_info);
		
		//账号信息
		$user_account_info = $nfx_user->getShopUserAccountList(1, 1, $condition, '')['data'][0];
		$this->assign('user_account_info', $user_account_info);
		
		//分销账号类型列表
		$account_type = $nfx_user->getUserAccountTypeList();
		$this->assign('account_type', $account_type);
		return view($this->addon_view_path . $this->style . "Distribution/promoterAccount.html");
	}
	
	/**
	 * 修改分销配置
	 */
	public function updateNfxShopConfigField()
	{
		$partner = new NfxPartner();
		$fieldid = $this->instance_id;
		$fieldname = request()->post('fieldname', '');
		$fieldvalue = request()->post('fieldvalue', '');
		$res = $partner->updateNfxShopConfigField($fieldid, $fieldname, $fieldvalue);
		return ajaxReturn($res);
	}
	
	/**
	 * 商品分销设置
	 */
	public function goodsDistributionSetting()
	{
		if (request()->isAjax()) {
			$commission_config = new NfxCommissionConfig();
			$value = request()->post('value', '');
			if (empty($value)) return AjaxReturn(-1);
			$data = json_decode($value, true);
			$res = $commission_config->goodsDistributionSetting($data);
			return $res;
		}
	}
	
	/*************************************************************本地配送****************************************************/
}