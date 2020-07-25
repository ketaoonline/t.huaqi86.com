<?php
/**
 * NfxPartner.php
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

use addons\Nsfx\data\model\NfxCommissionPartnerGlobalModel;
use addons\Nsfx\data\model\NfxCommissionPartnerGlobalRecordsModel;
use addons\Nsfx\data\model\NfxCommissionPartnerModel;
use addons\Nsfx\data\model\NfxPartnerLevelModel;
use addons\Nsfx\data\model\NfxPartnerModel;
use addons\Nsfx\data\model\NfxPromoterModel;
use addons\Nsfx\data\model\NfxShopConfigModel;
use addons\Nsfx\data\model\NfxShopMemberAssociationModel;
use data\model\UserModel as UserModel;
use data\service\BaseService;
use data\service\OrderQuery;

/**
 * 股东服务层
 */
class NfxPartner extends BaseService
{
	
	/**
	 * 获取股东列表
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 */
	public function getPartnerList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$partner = new NfxPartnerModel();
		$list = $partner->pageQuery($page_index, $page_size, $condition, $order, '*');
		if (!empty($list['data'])) {
			foreach ($list['data'] as $k => $v) {
				$user = new UserModel();
				$userinfo = $user->getInfo([
					'uid' => $v['uid']
				]);
				$list['data'][ $k ]['real_name'] = $userinfo["nick_name"];
				$list['data'][ $k ]['user_tel'] = $userinfo["user_tel"];
				$promoter = new NfxPromoterModel();
				$prometerinfo = $promoter->getInfo([ 'uid' => $v['uid'] ]);
				$list['data'][ $k ]['promoter_no'] = $prometerinfo['promoter_no'];
				$partner_level = new NfxPartnerLevelModel();
				$level_info = $partner_level->getInfo([
					'level_id' => $v['partner_level']
				]);
				$list['data'][ $k ]['level_name'] = $level_info["level_name"];
				$parent_realname = "";
				$parent_promoter_no = "";
				if ($v['parent_partner'] != 0) {
					$partner = new NfxPartnerModel();
					$parent_info = $partner->getInfo([
						'partner_id' => $v['parent_partner']
					]);
					$parent_uid = $parent_info["uid"];
					$parent_userinfo = $user->getInfo([
						'uid' => $parent_uid
					]);
					$parent_realname = $parent_userinfo["user_name"];
					$parent_promoter_info = $promoter->getInfo([ "promoter_id" => $parent_info["promoter_id"] ], "*");
					$parent_promoter_no = $parent_promoter_info['promoter_no'];
				}
				$list['data'][ $k ]['parent_realname'] = $parent_realname;
				$list['data'][ $k ]['parent_promoter_no'] = $parent_promoter_no;
			}
		}
		return $list;
	}
	
	/**
	 * 股东申请
	 */
	public function partnerApplay($shop_id, $uid)
	{
		$shop_member_association = new NfxShopMemberAssociationModel();
		$condition = array(
			"shop_id" => $shop_id,
			"uid" => $uid
		);
		$user_shop_info = $shop_member_association->getInfo($condition, "partner_id, promoter_id");
		$parent_partner = 0;
		$promoter_id = 0;
		if (!empty($user_shop_info)) {
			$parent_partner = $user_shop_info["partner_id"];
			$promoter_id = $user_shop_info["promoter_id"];
		}
		$partner = new NfxPartnerModel();
		$partner_apply_count = $partner->getCount([ "shop_id" => $shop_id, "uid" => $uid, "is_audit" => [ "neq", -1 ] ]);
		if ($partner_apply_count > 0) {
			return 0;
		}
		$partner_level = new NfxPartnerLevelModel();
		$level_info = $partner_level->where(array(
			"shop_id" => $shop_id
		))
			->order("level_money asc")
			->limit(0, 1)
			->select();
		$level = $level_info[0]["level_id"];
		$partner = new NfxPartnerModel();
		$data = array(
			"promoter_id" => $promoter_id,
			"parent_partner" => $parent_partner,
			"uid" => $uid,
			"shop_id" => $shop_id,
			"partner_level" => $level,
			"register_time" => time()
		);
		$partner->save($data);
		return $partner->partner_id;
	}
	
	/**
	 * 股东审核
	 */
	public function partnerAudit($partner_id, $is_audit, $shop_id)
	{
		$partner = new NfxPartnerModel();
		$data = array(
			"is_audit" => $is_audit,
			"audit_time" => time()
		);
		$retval = $partner->save($data, [
			"partner_id" => $partner_id
		]);
		if ($retval > 0) {
			if ($is_audit == 1) {
				$partner = new NfxPartnerModel();
				$partner_info = $partner->getInfo(array(
					"partner_id" => $partner_id,
					"shop_id" => $shop_id
				), "uid");
				$uid = $partner_info["uid"];
				$shop_member_association = new NfxShopMemberAssociationModel();
				$result = $shop_member_association->where(array(
					"shop_id" => $shop_id,
					"uid" => $uid
				))->update(array(
					"partner_id" => $partner_id,
					'is_partner' => 1
				));
			}
		}
		return $retval;
	}
	
	/**
	 * 股东修改
	 */
	public function updatePartner($partner_level, $partner_id)
	{
		$partner = new NfxPartnerModel();
		$data = array(
			"modify_time" => time(),
			"partner_level" => $partner_level
		);
		$retval = $partner->save($data, [
			"partner_id" => $partner_id
		]);
		return $retval;
	}
	
	/**
	 * 订单股东分红计算
	 */
	public function partnerCommissionCalculate($order_id)
	{
	}
	
	/**
	 * 获取股东等级列表
	 */
	public function getPartnerLevelList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$partner_level = new NfxPartnerLevelModel();
		$list = $partner_level->pageQuery($page_index, $page_size, $condition, $order, '*');
		return $list;
	}
	
	/**
	 * 添加股东等级
	 */
	public function addPartnerLevel($level_money, $level_name, $commission_rate, $shop_id)
	{
		$partner_level = new NfxPartnerLevelModel();
		$data = array(
			"level_money" => $level_money,
			"level_name" => $level_name,
			"commission_rate" => $commission_rate,
			"create_time" => time(),
			"shop_id" => $shop_id
		);
		$partner_level->save($data);
		return $partner_level->level_id;
	}
	
	/**
	 * 修改股东等级
	 */
	public function updatePartnerLevel($level_id, $level_name, $level_money, $commission_rate, $shop_id)
	{
		$partner_level = new NfxPartnerLevelModel();
		$data = array(
			"level_money" => $level_money,
			"level_name" => $level_name,
			"commission_rate" => $commission_rate,
			"modify_time" => time()
		);
		$retval = $partner_level->save($data, [
			"level_id" => $level_id,
			"shop_id" => $shop_id
		]);
		return $retval;
	}
	
	/**
	 * 获取股东详情
	 */
	public function getPartnerDetail($partner_id)
	{
		$partner = new NfxPartnerModel();
		$data = $partner->get($partner_id);
		return $data;
	}
	
	/**
	 * 获取股东等级详情
	 */
	public function getPartnerLevelDetail($level_id)
	{
		$partner_level = new NfxPartnerLevelModel();
		$data = $partner_level->get($level_id);
		return $data;
	}
	
	/**
	 * 股东冻结\解冻
	 */
	public function modifyPartnerLock($partner_id, $is_lock)
	{
		$partner = new NfxPartnerModel();
		$data = array(
			"is_lock" => $is_lock
		);
		$retval = $partner->save($data, [
			"partner_id" => $partner_id
		]);
		return $retval;
	}
	
	/**
	 * 获取股东的上级股东组返回数组（等级和ID）
	 */
	public function getPartnerParents($partner_id)
	{
		$partner = new NfxPartnerModel();
		$partner_info = $partner->getInfo([
			'partner_id' => $partner_id
		], 'partner_id,promoter_id,uid,parent_partner,shop_id,partner_level,is_audit,is_lock');
		$parents_array = array();
		$parents_array[] = $partner_info;
		while ($partner_info['parent_partner'] != 0) {
			$partner_info = $partner->getInfo([
				'partner_id' => $partner_info['parent_partner']
			], 'partner_id,promoter_id,uid,parent_partner,shop_id,partner_level,is_audit,is_lock');
			$parents_array[] = $partner_info;
		}
		return $parents_array;
	}
	
	/**
	 * 获取股东分红列表
	 */
	public function getCommissionPartnerList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$order_query = new OrderQuery();
		$order_list = $order_query->getOrderList($page_index, $page_size, $condition, $order);
		foreach ($order_list["data"] as $k => $v) {
			$commission_money = 0;
			
			foreach ($v["order_item_list"] as $l => $b) {
				$order_item = $v["order_item_list"][ $l ];
				$commission_partner = new NfxCommissionPartnerModel();
				$commission_partner_condition = array(
					"order_id" => $b["order_id"],
					"order_goods_id" => $b["order_goods_id"]
				);
				$commission_partner_list = $commission_partner->all($commission_partner_condition);
				if (count($commission_partner_list) > 0) {
					foreach ($commission_partner_list as $commission_k => $commission_v) {
						$protner = new NfxPartnerModel();
						$protner_info = $protner->getInfo([
							'partner_id' => $commission_v["partner_id"]
						], 'uid');
						$uid = $protner_info["uid"];
						$user = new UserModel();
						$user_info = $user->getInfo([
							'uid' => $uid
						], "nick_name");
						$realname = $user_info["nick_name"];
						$commission_partner_list[ $commission_k ]["realname"] = $realname;
						$commission_money = $commission_money + $commission_v["commission_money"];
						$promoter = new NfxPromoterModel();
						$prometerinfo = $promoter->getInfo([ 'uid' => $uid ]);
						$commission_partner_list[ $commission_k ]['promoter_no'] = $prometerinfo['promoter_no'];
						$commission_partner_list[ $commission_k ]['promoter_shop_name'] = $prometerinfo['promoter_shop_name'];
					}
				}
				$order_item["commission_partner_list"] = $commission_partner_list;
			}
			$order_list["data"][ $k ]["commission_money"] = $commission_money;
		}
		return $order_list;
	}
	
	/**
	 * 获取全球分红列表
	 */
	public function getCommissionPartnerGlobalList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$commission_partner_global = new NfxCommissionPartnerGlobalModel();
		$list = $commission_partner_global->pageQuery($page_index, $page_size, $condition, $order, '*');
		if (!empty($list['data'])) {
			foreach ($list['data'] as $k => $v) {
				$user = new UserModel();
				$userinfo = $user->get([
					'uid' => $v['uid']
				]);
				$list['data'][ $k ]['real_name'] = $userinfo["user_name"];
			}
		}
		return $list;
	}
	
	/**
	 * 获取全部股东等级
	 */
	public function getPartnerLevelAll($shop_id)
	{
		$partner_level = new NfxPartnerLevelModel();
		$condition = array(
			"shop_id" => $shop_id
		);
		$all = $partner_level->all($condition);
		return $all;
	}
	
	/**
	 * 全球分红设置
	 */
	public function updatePartnerGlobal($level_array, $shop_id)
	{
		$partner_level = new NfxPartnerLevelModel();
		$partner_level->startTrans();
		try {
			foreach ($level_array as $k => $v) {
				$partner_level = new NfxPartnerLevelModel();
				$data = array(
					"global_value" => $v[1],
					"global_weight" => $v[2],
					"modify_time" => time()
				);
				$partner_level->save($data, [
					"level_id" => $v[0],
					"shop_id" => $shop_id
				]);
			}
			$partner_level->commit();
			return 1;
		} catch (\Exception $e) {
			$partner_level->rollback();
			return $e->getMessage();
		}
	}
	
	/**
	 * 获取等级人数，分值
	 */
	public function getPartnerLevelGlobalList($shop_id)
	{
		$partner_level_list = $this->getPartnerLevelAll($shop_id);
		$partner_global_calculate = new NfxPartnerGlobalCalculate();
		foreach ($partner_level_list as $k => $v) {
			$partner_level_list[ $k ]["global_value_num"] = $partner_global_calculate->getPartnerLevelValue($v["level_id"]);
			$partner = new NfxPartnerModel();
			$where["partner_level"] = $v["level_id"];
			$where["shop_id"] = $shop_id;
			$partner_level_list[ $k ]["level_num"] = $partner->where($where)->count("partner_id");
		}
		return $partner_level_list;
	}
	
	/**
	 * 获取全球分红流水
	 */
	public function getCommissionPartnerGlobalRecordsList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$commission_partner_global_records = new NfxCommissionPartnerGlobalRecordsModel();
		$list = $commission_partner_global_records->pageQuery($page_index, $page_size, $condition, $order, '*');
		return $list;
	}
	
	/**
	 * 获取有效的股东信息
	 */
	public function getPartnerValidDetail($shop_id, $uid)
	{
		$partner = new NfxPartnerModel();
		$data = $partner->where(array(
			"shop_id" => $shop_id,
			"uid" => $uid
		))
			->order("partner_id desc")
			->limit(0, 1)
			->select();
		return empty($data) ? '' : $data[0];
	}
	
	/**
	 * 修改所有股东等级
	 */
	public function updatePartnerLevelAll($level_array, $shop_id)
	{
		$partner_level = new NfxPartnerLevelModel();
		$partner_level->startTrans();
		try {
			// 循环修改股东等级配置
			foreach ($level_array as $k => $v) {
				$partner_level = new NfxPartnerLevelModel();
				$data = array(
					"level_money" => $v[1],
					"commission_rate" => $v[2],
					"modify_time" => time()
				);
				$partner_level->save($data, [
					"level_id" => $v[0],
					"shop_id" => $shop_id
				]);
			}
			$partner_level->commit();
			return 1;
		} catch (\Exception $e) {
			$partner_level->rollback();
			return $e->getMessage();
		}
	}
	
	/**
	 * 修改店铺分销配置
	 */
	public function updateNfxShopConfigField($shop_id, $field_name, $field_value)
	{
		$shop_config = new NfxShopConfigModel();
		$retval = $shop_config->ModifyTableField("shop_id", $shop_id, $field_name, $field_value);
		return $retval;
	}
	
	/**
	 * 删除股东等级
	 */
	public function deletePartnerLevel($shop_id, $level_id)
	{
		$partner = new NfxPartnerModel();
		$count = $partner->where(array(
			"shop_id" => $shop_id,
			"partner_level" => $level_id
		))->count();
		if ($count == 0) {
			$partner_level = new NfxPartnerLevelModel();
			$retval = $partner_level->where(array(
				"shop_id" => $shop_id,
				"level_id" => $level_id
			))->delete();
			return $retval;
		} else {
			return 0;
		}
	}
	
	/**
	 * 修改股东用户等级
	 */
	public function modifyPartnerLevelNum($shop_id, $uid, $level_id)
	{
		$partner = new NfxPartnerModel();
		$retval = $partner->where(array(
			"shop_id" => $shop_id,
			"uid" => $uid
		))->update(array(
			"partner_level" => $level_id
		));
		return $retval;
	}
	
	/**
	 * 获取股东
	 */
	public function getPartnerAll($condition)
	{
		$partner = new NfxPartnerModel();
		$partner_all = $partner->all($condition);
		return $partner_all;
	}
	
	/**
	 * 获取股东分销佣金
	 */
	public function getPartnerCommissionCount($condition)
	{
		$partner_commission = new NfxCommissionPartnerModel();
		$result = $partner_commission->getQuery($condition, "sum(commission_money) as sum");
		return $result[0]["sum"];
	}
	
	/**
	 * 获取 股东上级根据 uid 和 shop_id
	 */
	public function getPartnerParentByUidAndShopid($shop_id, $uid)
	{
		$partner = new NfxPartnerModel();
		$array = array(
			'parent_partner' => 0,
			'parent_uid' => 0
		);
		$data = $partner->getInfo([ 'shop_id' => $shop_id, 'uid' => $uid ], 'parent_partner');
		$array['parent_partner'] = $data['parent_partner'] > 0 ? $data['parent_partner'] : 0;
		if ($data['parent_partner'] > 0) {
			$parent_uid = $partner->getInfo([ 'partner_id' => $data['parent_partner'] ], 'uid');
			$array['parent_uid'] = $parent_uid['uid'] > 0 ? $parent_uid['uid'] : 0;
		}
		return $array;
	}
	
	public function modifyPartherParnet($partner_id, $parent_no, $shop_id)
	{
		$promoter = new NfxPromoterModel();
		$promoter_info = $promoter->getInfo(array(
			"promoter_no" => $parent_no,
			"shop_id" => $shop_id,
			"is_audit" => 1
		));
		if (count($promoter_info) == 0) {
			return 0;
		}
		$partner = new NfxPartnerModel();
		$partner_info = $partner->getInfo([ "promoter_id" => $promoter_info["promoter_id"], "is_audit" => 1, "shop_id" => $shop_id ], "*");
		if (empty($partner_info)) {
			return 0;
		}
		if ($partner_info["partner_id"] == $partner_id) {
			return 0;
		}
		// 判断所改父级是否是自己的自级
		$parent_array = $this->getPartnerParentQuery($partner_id, $shop_id);
		if (in_array($partner_info["partner_id"], $parent_array)) {
			return 0;
		}
		
		$partner = new NfxPartnerModel();
		$data = array(
			"parent_partner" => $partner_info["partner_id"]
		);
		$retval = $partner->save($data, [
			"partner_id" => $partner_id
		]);
		return $retval;
	}
	
	/**
	 * 查询股东的上级
	 * 返回上级推广云uid 以，隔开
	 */
	private function getPartnerParentQuery($partner_id, $shop_id)
	{
		$is_go = 0;
		$parent_array = array();
		while ($is_go == 0) {
			$partner = new NfxPartnerModel();
			$promoter_info = $partner->getInfo(array(
				"shop_id" => $shop_id,
				"partner_id" => $partner_id,
				"is_audit" => 1
			), "*");
			if (!empty($promoter_info)) {
				$partner_id = $promoter_info["parent_partner"];
				$parent_array[] = $promoter_info["parent_partner"];
			} else {
				$is_go = 1;
			}
		}
		return $parent_array;
	}
	
	/**
	 * 获取股东分红佣金列表
	 */
	public function getCommissionPageList($page_index = 1, $page_size = PAGESIZE, $condition = [], $order = '', $field = '*')
	{
		$model = new NfxCommissionPartnerModel();
		$order_query = new OrderQuery();
		
		$list = $model->getViewList($page_index, $page_size, $condition, $order);
		
		if (!empty($list['data'])) {
			foreach ($list['data'] as $item) {
				$order_status_info = $order_query->getOrderStatusInfo([ "order_type" => $item['order_type'], "order_status" => $item['order_status'], "shipping_type" => $item["shipping_type"] ]);
				$item['status_name'] = $order_status_info['status_name'];
			}
		}
		return $list;
	}
}