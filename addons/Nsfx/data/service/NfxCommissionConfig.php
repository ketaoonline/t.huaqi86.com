<?php
/**
 * NfxCommissionConfig.php
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

use addons\Nsfx\data\model\NfxCommissionDistributionModel;
use addons\Nsfx\data\model\NfxCommissionPartnerModel;
use addons\Nsfx\data\model\NfxCommissionRegionAgentModel;
use addons\Nsfx\data\model\NfxGoodsCommissionRateModel;
use addons\Nsfx\data\model\NfxPartnerModel;
use addons\Nsfx\data\model\NfxPromoterModel;
use addons\Nsfx\data\model\NfxPromoterRegionAgentModel;
use addons\Nsfx\data\model\NfxShopMemberAssociationModel;
use addons\Nsfx\data\model\NsGoodsViewModel as NfxGoodsViewModel;
use data\model\NsGoodsModel as NsGoodsModel;
use data\model\NsGoodsViewModel as NsGoodsViewModel;
use data\model\UserModel;
use data\service\BaseService;
use data\service\Goods as GoodsService;
use data\service\GoodsAttribute;

/**
 * 商品佣金设置服务层
 */
class NfxCommissionConfig extends BaseService
{
	
	/**
	 * 查询商品分销分红佣金设置
	 */
	public function getGoodsCommissionRate($goods_id)
	{
		$goods_commission_rate = new NfxGoodsCommissionRateModel();
		$count = $goods_commission_rate->where([ 'goods_id' => $goods_id ])->count();
		if ($count == 0) {
			//默认添加
			$goods_commission_rate = new NfxGoodsCommissionRateModel();
			$data = array(
				"goods_id" => $goods_id,
				"create_time" => time()
			);
			$goods_commission_rate->save($data);
		}
		
		$data = $goods_commission_rate->get([ "goods_id" => $goods_id ]);
		return $data;
	}
	
	/**
	 * 商品佣金比率设置（按照商品利润分成）
	 * @param unknown $condition 条件
	 * @param unknown $isopen 是否启用
	 * @param unknown $distribution_commission_rate 分销佣金比率
	 * @param unknown $partner_commission_rate 股东分红比率
	 * @param unknown $global_commission_rate 股东全球分红比率
	 * @param unknown $distribution_team_commission_rate 分销商团队分红比率
	 * @param unknown $partner_team_commission_rate 股东团队分红比率
	 * @param unknown $regionagent_commission_rate 区域分销佣金比率
	 * @param unknown $channelagent_commission_rate 渠道代理佣金比率
	 */
	public function updateGoodsCommissionRate($condition, $type, $distribution_commission_rate, $partner_commission_rate, $global_commission_rate, $distribution_team_commission_rate, $partner_team_commission_rate, $regionagent_commission_rate, $channelagent_commission_rate, $shop_id, $is_open)
	{
		$distribution_team_commission_rate = !empty($distribution_team_commission_rate) ? $distribution_team_commission_rate : 0;
		$partner_team_commission_rate = !empty($partner_team_commission_rate) ? $partner_team_commission_rate : 0;
		$distribution_commission_rate = !empty($distribution_commission_rate) ? $distribution_commission_rate : 0;
		$partner_commission_rate = !empty($partner_commission_rate) ? $partner_commission_rate : 0;
		$global_commission_rate = !empty($global_commission_rate) ? $global_commission_rate : 0;
		$regionagent_commission_rate = !empty($regionagent_commission_rate) ? $regionagent_commission_rate : 0;
		$channelagent_commission_rate = !empty($channelagent_commission_rate) ? $channelagent_commission_rate : 0;
		
		$goods_list = array();
		if ($type == 1) {
			//平台店铺独立分销单独设定
			if (NS_VERSION == NS_VER_B2C_FX) {
				$condition = " goods_id =" . $condition . " and shop_id = " . $shop_id;
			} else {
				$condition = " goods_id =" . $condition;
			}
			
			$goods = new NsGoodsModel();
			$goods_list = $goods->getQuery($condition);
		} elseif ($type == 2) {
			//平台店铺独立分销单独设定
			if (NS_VERSION == NS_VER_B2C_FX) {
				$where["shop_id"] = $shop_id;
			} else {
				$where = '';
			}
			
			$goods_list = $this->getGroupGoodsList($condition, $where);
		} elseif ($type == 3) {
			//平台店铺独立分销单独设定
			$goods = new NsGoodsModel();
			if (NS_VERSION == NS_VER_B2C_FX) {
				$goods_list = $goods->getQuery(" shop_id =" . $shop_id);
			} else {
				$goods_list = $goods->getQuery();
			}
			
		}
		$goods_id_string = "";
		foreach ($goods_list as $k => $v) {
			$this->getGoodsCommissionRate($v["goods_id"]);
			//$retval = $goods_commission_rate->save($data,["goods_id"=>$goods_id]);
			$goods_id_string = $goods_id_string . "," . $v["goods_id"];
		}
		
		$goods_id_string = substr($goods_id_string, 1);
		$data = array(
			"distribution_commission_rate" => $distribution_commission_rate,
			"partner_commission_rate" => $partner_commission_rate,
			"global_commission_rate" => $global_commission_rate,
			"distribution_team_commission_rate" => $distribution_team_commission_rate,
			"partner_team_commission_rate" => $partner_team_commission_rate,
			"regionagent_commission_rate" => $regionagent_commission_rate,
			"channelagent_commission_rate" => $channelagent_commission_rate,
			"modify_time" => time(),
			"is_open" => $is_open
		);
		$goods_commission_rate = new NfxGoodsCommissionRateModel();
		if ($goods_id_string != "") {
			$rate_total = $distribution_commission_rate + $partner_commission_rate + $global_commission_rate + $distribution_team_commission_rate + $partner_team_commission_rate + $regionagent_commission_rate + $channelagent_commission_rate;
			if ($rate_total > 100) {
				$retval = 1;
			} else {
				$retval = $goods_commission_rate->where(" goods_id in (" . $goods_id_string . ") ")->update($data);
			}
			
		} else {
			$retval = 1;
		}
		return $retval;
	}
	
	/**
	 * 商品开启分销
	 */
	public function modifyGoodsIsOpenDistribution($condition, $is_open)
	{
		$goods_commission_rate = new NfxGoodsCommissionRateModel();
		$data = array(
			"is_open" => $is_open
		);
		$retval = $goods_commission_rate->save($data, "goods_id  in ($condition)");
		return $retval;
	}
	
	/**
	 * 商品分销列表
	 */
	public function getGoodsCommissionRateList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$goods_view = new NsGoodsViewModel();
		$list = $goods_view->getGoodsViewList($page_index, $page_size, $condition, $order);
		if (!empty($list['data'])) {
			//用户针对商品的收藏
			foreach ($list['data'] as $k => $v) {
				
				$goods_info = $this->getGoodsCommissionRate($v["goods_id"]);
				$list['data'][ $k ]['is_open'] = $goods_info["is_open"];
				$list['data'][ $k ]['distribution_commission_rate'] = $goods_info["distribution_commission_rate"];
				$list['data'][ $k ]['partner_commission_rate'] = $goods_info["partner_commission_rate"];
				$list['data'][ $k ]['global_commission_rate'] = $goods_info["global_commission_rate"];
				$list['data'][ $k ]['distribution_team_commission_rate'] = $goods_info["distribution_team_commission_rate"];
				$list['data'][ $k ]['partner_team_commission_rate'] = $goods_info["partner_team_commission_rate"];
				$list['data'][ $k ]['regionagent_commission_rate'] = $goods_info["regionagent_commission_rate"];
				$list['data'][ $k ]['channelagent_commission_rate'] = $goods_info["channelagent_commission_rate"];
				$list['data'][ $k ]['fenxiao_create_time'] = $goods_info["create_time"];
				$list['data'][ $k ]['fenxiao_modify_time'] = $goods_info["modify_time"];
			}
			
		}
		return $list;
	}
	
	private function getGroupGoodsList($goods_group_id, $condition = '', $num = 0, $order = '')
	{
//		$goods_list = array();
		$goods = new NsGoodsModel();
		//$condition['state'] = 1;
		
		$group_id_array = explode(',', $goods_group_id);
		$condition_str = "";
		foreach ($group_id_array as $k => $v) {
			if (empty($condition_str)) {
				$condition_str .= '(group_id_array LIKE "%' . $v . '" || group_id_array LIKE "' . $v . '%" || group_id_array LIKE "%' . $v . '%")';
			} else {
				$condition_str .= ' and (group_id_array LIKE "%' . $v . '" || group_id_array LIKE "' . $v . '%" || group_id_array LIKE "%' . $v . '%")';
			}
		}
		$condition[] = [ "exp", $condition_str ];
		
		$list = $goods->getQuery($condition, '*', $order);

//         $list = $goods->getQuery($condition, '*', $order);
//         foreach ($list as $k => $v) {
//             $group_id_array = explode(',', $v['group_id_array']);
//             if (in_array($goods_group_id, $group_id_array) || $goods_group_id == 0) {
//                 $goods_list[] = $v;
//             }
//         }
		return $list;
	}
	
	/**
	 * 获取所有分销商品
	 */
	public function getGoodsCommiddionAll($condition)
	{
		$goods_commission_rate = new NfxGoodsCommissionRateModel();
		$all = $goods_commission_rate->all($condition);
		return $all;
	}
	
	/**
	 * 获取商品佣金
	 */
	public function getGoodsCommissionCalculate($goods_id)
	{
		$goods_model = new NsGoodsModel();
		$goods_info = $goods_model->getInfo([ 'goods_id' => $goods_id ], 'promotion_price,cost_price');
		
		//判断分销佣金:是0.使用利润or 1.销售价格
		$shop_config = new NfxShopConfig();
		$shop_config_info = $shop_config->getShopConfigDetail();
		if ($shop_config_info['distribution_use'] == 1) {
			$goods_return = $goods_info['promotion_price'];
		} else {
			$goods_return = $goods_info['promotion_price'] - $goods_info['cost_price'];
		}
		
		if ($goods_return < 0) {
			$goods_return = 0;
		}
		$goods_commission_rate = $this->getGoodsCommissionRate($goods_id);
		$is_open = 1;
		if (!empty($goods_commission_rate)) {
			if ($goods_commission_rate['is_open'] == 0) {
				$is_open = 0;
			} else {
				if ($goods_return > 0) {
					$distribution_commission = $goods_return * $goods_commission_rate['distribution_commission_rate'] / 100;
					$partner_commission = $goods_return * $goods_commission_rate['partner_commission_rate'] / 100;
					$global_commission = $goods_return * $goods_commission_rate['global_commission_rate'] / 100;
					$regionagent_commission = $goods_return * $goods_commission_rate['regionagent_commission_rate'] / 100;
				} else {
					$is_open = 0;
				}
				
			}
			
		} else {
			$is_open = 0;
		}
		if ($is_open == 1) {
			return array(
				'distribution_commission' => $distribution_commission,
				'partner_commission' => $partner_commission,
				'global_commission' => $global_commission,
				'regionagent_commission' => $regionagent_commission
			);
		} else {
			return array(
				'distribution_commission' => 0,
				'partner_commission' => 0,
				'global_commission' => 0,
				'regionagent_commission' => 0
			);
		}
	}
	
	/**
	 * 获取用户商品佣金
	 */
	public function getGoodsUserCommission($goods_id, $uid)
	{
		$shop_member_association = new NfxShopMemberAssociationModel();
		$promoter_info = $shop_member_association->getInfo([ 'uid' => $uid ], 'is_promoter,is_partner,region_center_id');
		
		$goods_commission = $this->getGoodsCommissionCalculate($goods_id);
		if (empty($promoter_info)) {
			return array(
				'distribution_commission' => 0,
				'partner_commission' => 0,
				'global_commission' => 0,
				'regionagent_commission' => 0
			);
		}
		if ($promoter_info['is_promoter'] == 0) {
			$goods_commission['distribution_commission'] = 0;
		}
		if ($promoter_info['is_partner'] == 0) {
			$goods_commission['partner_commission'] = 0;
			$goods_commission['global_commission'] = 0;
		}
		if ($promoter_info['region_center_id'] == 0) {
			$goods_commission['regionagent_commission'] = 0;
		}
		if ($goods_commission['distribution_commission'] > 0) {
			$promoter = new NfxPromoter();
			$promoter_info = $promoter->getInfo(['uid' => $uid], 'npl.level_0', 'np', [ ['nfx_promoter_level npl', 'npl.level_id = np.promoter_level', 'left'] ]);
			if (!empty($promoter_info) && !empty($promoter_info['level_0'])) {
				$goods_commission['distribution_commission'] = round($goods_commission['distribution_commission'] * ($promoter_info['level_0'] / 100), 2);
			}
		}
		return $goods_commission;
	}
	
	/**
	 * 商品分销列表
	 */
	public function getGoodsViewList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$goods_view = new NfxGoodsViewModel();
		$list = $goods_view->getGoodsViewList($page_index, $page_size, $condition, $order);
		return $list;
	}
	
	/**
	 * 获取分销商品分成金额
	 */
	public function getFxGoodsList($page_index = 1, $page_size = 0, $uid, $condition = '', $order = '')
	{
		$list = $this->getGoodsViewList($page_index, $page_size, $condition, $order);
		if (!empty($list['data'])) {
			foreach ($list['data'] as $k => $item) {
				$goods_commission = $this->getGoodsUserCommission($item['goods_id'], $uid);
				$list['data'][ $k ]['goods_commission'] = $goods_commission;
			}
		}
		return $list;
	}
	
	/**
	 * 分销商品数量
	 */
	public function getGoodsrViewCount($condition)
	{
		$goods_view = new NfxGoodsViewModel();
		$count = $goods_view->getGoodsrViewCount($condition);
		return $count;
	}
	
	/**
	 * 根据条件查询商品列表：商品分类查询，关键词查询，价格区间查询，品牌查询
	 */
	public function getGoodsListByConditionTwo($uid, $category_id, $brand_id, $min_price, $max_price, $page, $page_size, $order, $attr_array, $spec_array, $search_text = '', $user_goods = '')
	{
		$goods = new GoodsService();
		$condition = null;
		if ($category_id != "") {
			// 商品分类Id
			$condition["ng.category_id"] = $category_id;
		}
		// 品牌Id
		if ($brand_id != "") {
			$condition["ng.brand_id"] = array(
				"in",
				$brand_id
			);
		}
		
		// 价格区间
		if ($max_price != "") {
			$condition["ng.promotion_price"] = [
				[
					">=",
					$min_price
				],
				[
					"<=",
					$max_price
				]
			];
		}
		
		// 属性 (条件拼装)
		$array_count = count($attr_array);
		$goodsid_str = "";
		$attr_str_where = "";
		
		if (!empty($attr_array)) {
			// 循环拼装sql属性条件
			foreach ($attr_array as $k => $v) {
				if ($attr_str_where == "") {
					$attr_str_where = "(attr_value_id = '$v[2]' and attr_value_name='$v[1]')";
				} else {
					$attr_str_where = $attr_str_where . " or " . "(attr_value_id = '$v[2]' and attr_value_name='$v[1]')";
				}
			}
			if ($attr_str_where != "") {
				$goods_attribute = new GoodsAttribute();
				$attr_query = $goods_attribute->getGoodsAttributeQuery($attr_str_where);
				
				$attr_array = array();
				foreach ($attr_query as $t => $b) {
					$attr_array[ $b["goods_id"] ][] = $b;
				}
				$goodsid_str = "0";
				foreach ($attr_array as $z => $x) {
					if (count($x) == $array_count) {
						if ($goodsid_str == "") {
							$goodsid_str = $z;
						} else {
							$goodsid_str = $goodsid_str . "," . $z;
						}
					}
				}
			}
		}
		
		// 规格条件拼装
		$spec_count = count($spec_array);
		$spec_where = array();
		
		if ($spec_count > 0) {
			foreach ($spec_array as $k => $v) {
				$tmp_array = explode(':', $v);
				// 得到规格名称
				$spec_info = $goods->getGoodsAttributeList([
					"spec_id" => $tmp_array[0]
				], 'spec_name', '');
				$spec_name = $spec_info[0]["spec_name"];
				// 得到规格值名称
				$spec_value_info = $goods->getGoodsAttributeValueList([
					"spec_value_id" => $tmp_array[1]
				], 'spec_value_name');
				$spec_value_name = $spec_value_info[0]["spec_value_name"];
				if (!empty($spec_name)) {
					$spec_where[] = array(
						'like',
						'%' . $spec_name . '%'
					);
				}
				if (!empty($spec_value_name)) {
					$spec_where[] = array(
						'like',
						'%' . $spec_value_name . '%'
					);
				}
			}
			if (!empty($spec_where)) {
				$condition["ng.goods_spec_format"] = [
					$spec_where
				];
			}
		}
		if ($goodsid_str != "") {
			$condition["ng.goods_id"] = [
				"in",
				$goodsid_str
			];
		}
		
		$condition['ng.state'] = 1;
		$condition['ngcr.is_open'] = 1;
		$condition['ng.goods_id'] = [ 'neq', 'null' ];
		
		if (!empty($user_goods)) {
			$condition['ng.goods_id'] = [ 'in', $user_goods ];
		}
		
		if ($search_text != '') {
			$condition['ng.goods_name'] = [ 'like', '%' . $search_text . '%' ];
		}
		
		$list = $this->getGoodsViewList($page, $page_size, $condition, $order);
		if (!empty($list['data']) && !empty($uid)) {
			foreach ($list['data'] as $k => $item) {
				$goods_commission = $this->getGoodsUserCommission($item['goods_id'], $uid);
				$list['data'][ $k ]['goods_commission'] = $goods_commission;
			}
		}
		return $list;
	}
	
	/**
	 * 订单分销信息
	 */
	public function getOrderCommission($param)
	{
		//分销
		$commission_distribution_model = new NfxCommissionDistributionModel();
		$user_model = new UserModel();
		$promoter_model = new NfxPromoterModel();
		$commission_distribution_list = $commission_distribution_model->getQuery([ "order_id" => $param["order_id"] ]);
		$commission_distribution_money = 0;
		foreach ($commission_distribution_list as $k => $v) {
			$promoter_info = $promoter_model->getInfo([ "promoter_id" => $v["promoter_id"] ], "uid");
			$user_info = $user_model->getInfo([ "uid" => $promoter_info["uid"] ], "*");
			$commission_distribution_list[ $k ]["user_info"] = $user_info;
			$commission_distribution_money += $v["commission_money"];
			
			if ($v["promoter_level"] == 0) {
				$level_name = "第一级分销商";
			} else if ($v["promoter_level"] == 1) {
				$level_name = "第二级分销商";
			} else if ($v["promoter_level"] == 2) {
				$level_name = "第三级分销商";
			}
			$commission_distribution_list[ $k ]["level_name"] = $level_name;
		}

//         //已发放佣金
//         $commission_distribution_money_ed = $commission_distribution_model->getSum(["order_id" => $param["order_id"], "is_issue" => 1], "commission_money");
//         //待发放佣金
//         $commission_distribution_money = $commission_distribution_model->getSum(["order_id" => $param["order_id"], "is_issue" => 0], "commission_money");
		//股东分红
		$nfx_commission_partner_model = new NfxCommissionPartnerModel();
		$partner_model = new NfxPartnerModel();
		$commission_partner_list = $nfx_commission_partner_model->getQuery([ "order_id" => $param["order_id"] ]);
		$commission_partner_money = 0;
		foreach ($commission_partner_list as $k => $v) {
			$partner_info = $partner_model->getInfo([ "partner_id" => $v["partner_id"] ]);
			$user_info = $user_model->getInfo([ "uid" => $partner_info["uid"] ], "*");
			$commission_partner_list[ $k ]["user_info"] = $user_info;
			$commission_partner_money += $v["commission_money"];
		}
//         $commission_partner_money_ed = $nfx_commission_partner_model->getSum(["order_id" => $param["order_id"], "is_issue" => 1], "commission_money");
//         $commission_partner_money = $nfx_commission_partner_model->getSum(["order_id" => $param["order_id"], "is_issue" => 0], "commission_money");
		//代理分红
		$nfx_commission_region_agent_model = new NfxCommissionRegionAgentModel();
		$promoter_region_agent_model = new NfxPromoterRegionAgentModel();
		$commission_region_agent_list = $nfx_commission_region_agent_model->getQuery([ "order_id" => $param["order_id"] ]);
		$commission_region_agent_money = 0;
		foreach ($commission_region_agent_list as $k => $v) {
			$region_agent_info = $promoter_region_agent_model->getInfo([ "region_agent_id" => $v["region_agent_id"] ]);
			$user_info = $user_model->getInfo([ "uid" => $v["uid"] ], "*");
			$commission_region_agent_list[ $k ]["user_info"] = $user_info;
			$commission_region_agent_money += $v["commission"];
			
			if ($region_agent_info["agent_type"] == 1) {
				$level_name = "省代";
			} else if ($region_agent_info["agent_type"] == 2) {
				$level_name = "市代";
			} else if ($region_agent_info["agent_type"] == 3) {
				$level_name = "区代";
			}
			$commission_region_agent_list[ $k ]["level_name"] = $level_name;
		}
//         $commission_region_agent_money_ed = $nfx_commission_region_agent_model->getSum(["order_id" => $param["order_id"], "is_issue" => 1], "commission");
//         $commission_region_agent_money = $nfx_commission_region_agent_model->getSum(["order_id" => $param["order_id"], "is_issue" => 0], "commission");
		
		$data = array(
			"commission_distribution_money" => $commission_distribution_money,
			"commission_partner_money" => $commission_partner_money,
			"commission_region_agent_money" => $commission_region_agent_money,
			"commission_distribution_list" => $commission_distribution_list,
			"commission_partner_list" => $commission_partner_list,
			"commission_region_agent_list" => $commission_region_agent_list,
		);
		return $data;
	}
	
	/**
	 * 商品分销设定
	 */
	public function goodsDistributionSetting($params = [])
	{
	    $goods_commission_rate = new NfxGoodsCommissionRateModel();
	
	    $data = [
	        "distribution_commission_rate" => !empty($params['distribution_commission_rate']) ? $params['distribution_commission_rate'] : 0,
	        "partner_commission_rate" => !empty($params['partner_commission_rate']) ? $params['partner_commission_rate'] : 0,
	        "global_commission_rate" => !empty($params['global_commission_rate']) ? $params['global_commission_rate'] : 0,
	        "distribution_team_commission_rate" => !empty($params['distribution_team_commission_rate']) ? $params['distribution_team_commission_rate'] : 0,
	        "partner_team_commission_rate" => !empty($params['partner_team_commission_rate']) ? $params['partner_team_commission_rate'] : 0,
	        "regionagent_commission_rate" => !empty($params['regionagent_commission_rate']) ? $params['regionagent_commission_rate'] : 0,
	        "channelagent_commission_rate" => !empty($params['channelagent_commission_rate']) ? $params['channelagent_commission_rate'] : 0,
	        "modify_time" => time(),
	        "is_open" => $params['is_open']
	    ];
	    $page_size = 50;
	    // 全部商品
	    if ($params['type'] == 1) {
	        $goods_model = new NsGoodsModel();
	        $goods_list = $goods_model->pageQuery($params['page'], $page_size, '', '', 'goods_id');
	        if(!empty($goods_list['data'])){
	            foreach ($goods_list['data'] as $goods_item){
	                $goods_commission_rate = new NfxGoodsCommissionRateModel();
	                $count = $goods_commission_rate->getCount([ 'goods_id' => $goods_item['goods_id'] ]);
	                if($count){
	                    $goods_commission_rate->save($data, [ 'goods_id' => $goods_item['goods_id'] ]);
	                }else{
	                    $data['goods_id'] = $goods_item['goods_id'];
	                    $goods_commission_rate->save($data);
	                }
	            }
	            $goods_list['page'] = $params['page'];
	        }
	        return $goods_list;
	    } else { // 部分商品
	        $goods = new GoodsService();
	        $goods_ids = $goods->getGoodsIdsByCondition($params);
	        if (!empty($goods_ids)) {
	            $res = [
	                'total_count' => count($goods_ids),
	                'page_count' => ceil(count($goods_ids) / $page_size),
	                'page' => $params['page']
	            ];
	            $star = ($params['page'] - 1) * $page_size;
	            
	            for ($i = $star; $i < ($star + $page_size - 1); $i++) {
	                if(empty($goods_ids[$i])) break;
	                $goods_commission_rate = new NfxGoodsCommissionRateModel();
	                $count = $goods_commission_rate->getCount([ 'goods_id' => $goods_ids[$i] ]);
	                if($count){
	                    $goods_commission_rate->save($data, [ 'goods_id' => $goods_ids[$i] ]);
	                }else{
	                    $data['goods_id'] = $goods_ids[$i];
	                    $goods_commission_rate->save($data);
	                }
	            }
	            return $res;
	        }
	    }
	}
}