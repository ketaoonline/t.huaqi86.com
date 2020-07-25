<?php
/**
 * NfxPromoter.php
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
use addons\Nsfx\data\model\NfxPromoterGoodsModel;
use addons\Nsfx\data\model\NfxPromoterLevelModel;
use addons\Nsfx\data\model\NfxPromoterModel;
use addons\Nsfx\data\model\NfxShopConfigModel;
use addons\Nsfx\data\model\NfxShopMemberAssociationModel;
use addons\Nsfx\data\model\NfxUserAccountModel;
use data\model\NsMemberViewModel;
use data\model\NsShopAccountModel;
use data\model\NsShopModel;
use data\model\UserModel as UserModel;
use data\service\BaseService;
use data\service\Member\MemberAccount;
use data\service\OrderQuery;
use data\model\BaseModel;
use think\Db;

/**
 * 分销商
 */
class NfxPromoter extends BaseService
{
	
	/**
	 * 获取分销商列表
	 */
	public function getPromoterList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$promoter = new NfxPromoterModel();
		$promoter_list = $promoter->pageQuery($page_index, $page_size, $condition, $order, '*');
		if (!empty($promoter_list['data'])) {
			foreach ($promoter_list['data'] as $k => $v) {
				$user = new UserModel();
				$userinfo = $user->getInfo([ 'uid' => $v['uid'] ], "nick_name, user_tel, user_headimg, user_name, user_email");
				$user_name = "";
				$user_tel = "";
				$user_headimg = '';
				if (!empty($userinfo)) {
					$nick_name = $userinfo["nick_name"];
					$user_tel = $userinfo["user_tel"];
					$user_headimg = $userinfo["user_headimg"];
					$user_name = $userinfo["user_name"];
					$user_email = $userinfo["user_email"];
				}
				$promoter_list['data'][ $k ]['real_name'] = $nick_name;
				$promoter_list['data'][ $k ]['nick_name'] = $nick_name;
				$promoter_list['data'][ $k ]['user_tel'] = $user_tel;
				$promoter_list['data'][ $k ]['user_headimg'] = $user_headimg;
				$promoter_list['data'][ $k ]['user_name'] = $user_name;
				$promoter_list['data'][ $k ]['user_email'] = $user_email;
				$promoter_list['data'][ $k ]['order_total'] = $this->getPromoterOrderTotal($v['promoter_id']);
				$parent_realname = "";
				$parent_promoter_no = "";
				$promoter_level = new NfxPromoterLevelModel();
				$level_name = "";
				$level_info = $promoter_level->getInfo([ 'level_id' => $v['promoter_level'] ], "level_name");
				if (count($level_info) > 0) {
					$level_name = $level_info["level_name"];
				}
				$promoter_list['data'][ $k ]['level_name'] = $level_name;
				$level_info = $promoter_level->get($v['promoter_level']);
				$promoter_list['data'][ $k ]['level_name'] = $level_info["level_name"];
				if ($v['parent_promoter'] != 0) {
					$parent_info = $promoter->getInfo([ 'promoter_id' => $v['parent_promoter'] ], "uid, promoter_no");
					$parent_uid = $parent_info["uid"];
					$parent_userinfo = $user->getInfo([ 'uid' => $parent_uid ], "nick_name");
					$parent_realname = $parent_userinfo["nick_name"];
					$parent_promoter_no = $parent_info['promoter_no'];
				}
				$promoter_list['data'][ $k ]['parent_realname'] = $parent_realname;
				$promoter_list['data'][ $k ]['parent_promoter_no'] = $parent_promoter_no;
				
				// 查询会员团队人数
				$team_promoter_ids = $this->getTeamAllPromoter($v["promoter_id"]);
				$promoter_ids = implode(',', $team_promoter_ids);
				$team_promoter_ids = explode(',', $promoter_ids);
				
				// 团队中分销商人数
				$team_promoter_num = is_array($team_promoter_ids) ? count($team_promoter_ids) : 0;
				// 团队中会员人数
				$team_member_num = 0;
				if (!empty($team_promoter_ids)) {
					$shop_member_association = new NfxShopMemberAssociationModel();
					$source_uids = $shop_member_association->query('SELECT GROUP_CONCAT(nsma.uid) as source_uids FROM nfx_shop_member_association nsma WHERE nsma.promoter_id in (' . $promoter_ids . ')');
					if (!empty($source_uids[0]['source_uids'])) {
						$team_member_num = $shop_member_association->getCount("is_promoter = 0 AND ( (source_uid IN ({$source_uids[0]['source_uids']}) AND promoter_id = 0) OR promoter_id IN({$promoter_ids}) )");
					}
				}
				$promoter_list['data'][ $k ]['promoter_num'] = $team_promoter_num;
				$promoter_list['data'][ $k ]['fans_num'] = $team_member_num;
			}
		}
		return $promoter_list;
	}
	
	/**
	 * 获取分销商业绩总额
	 * @param unknown $promoter_id
	 */
	public function getPromoterOrderTotal($promoter_id)
	{
		$commissin_distribution_model = new NfxCommissionDistributionModel();
		$money = $commissin_distribution_model->getSum([ 'promoter_id' => $promoter_id, 'promoter_level' => 0 ], 'goods_money');
		if (empty($money)) {
			$money = 0;
		}
		return $money;
	}
	
	
	/**
	 * 分销商申请
	 */
	public function promoterApplay($uid, $shop_id, $promoter_shop_name)
	{
		$promoter = new NfxPromoterModel();

		$shop_member_association = new NfxShopMemberAssociationModel();
		$condition = array(
			"shop_id" => $shop_id,
			"uid" => $uid
		);
		$user_shop_info = $shop_member_association->getInfo($condition, "promoter_id");
		$parent_promoter = 0;//上级分销商
		if (!empty($user_shop_info)) {
			$parent_promoter = $user_shop_info["promoter_id"];
		}
		$promoter_level = new NfxPromoterLevelModel();
		$level_info = $promoter_level->getFirstData(array( "shop_id" => $shop_id ), "level_money asc");
		if (!empty($level_info)) {
			$level = $level_info["level_id"];
			
		} else {
			return -1;
		}
		$promoter = new NfxPromoterModel();
		$data = array(
			"parent_promoter" => $parent_promoter,
			"uid" => $uid,
			"shop_id" => $shop_id,
			"promoter_level" => $level,
			"promoter_shop_name" => $promoter_shop_name,
			"regidter_time" => time()
		);
		$info = $promoter->getInfo(['uid'=>$uid]);
		if(!empty($info)){
			$data['is_audit'] = 0;
			$promoter_return = $promoter->save($data, ['promoter_id'=> $info['promoter_id']]);
			$promoter_id = $info['promoter_id'];
		}else{
			$promoter_return = $promoter->save($data);
			$promoter_id = $promoter->promoter_id;
		}
//		hook('promoterApplyCreateSuccess', $data);
		message("promoter_apply", $data);
		$shop_config = new NfxShopConfigModel();
		$shop_config_info = $shop_config->getInfo(array(
			"shop_id" => $shop_id
		), "is_distribution_audit");
		$is_distribution_audit = $shop_config_info["is_distribution_audit"];
		if ($is_distribution_audit == 0) {
			$this->promoterAudit($promoter_id, 1, $shop_id);
		}
		return $promoter_id;
	}
	
	/**
	 * 分销商审核
	 */
	public function promoterAudit($promoter_id, $is_audit, $shop_id)
	{
		$promoter = new NfxPromoterModel();
		$promoter_no = $this->createPromoterNo();
		$data = array(
			'is_audit' => $is_audit,
			"audit_time" => time(),
			"promoter_no" => $promoter_no
		);
		$retval = $promoter->save($data, [
			'promoter_id' => $promoter_id
		]);
		if ($retval > 0) {
			if ($is_audit == 1) {
				$promoter = new NfxPromoterModel();
				
				$promoter_info = $promoter->getInfo(array(
					"promoter_id" => $promoter_id,
					"shop_id" => $shop_id
				), "uid");
				$uid = $promoter_info["uid"];
				$shop_member_association = new NfxShopMemberAssociationModel();
				$result = $shop_member_association->save(
					array(
						"promoter_id" => $promoter_id,
						'is_promoter' => 1
					),
					array(
						"shop_id" => $shop_id,
						"uid" => $uid
					));
				
				$user_account = new NfxUserAccountModel();
				$user_account_data = array(
					"shop_id" => $shop_id,
					"uid" => $uid
				);
				$res = $user_account->save($user_account_data);
				// 分销商审核通过调用
				$this->promoterAuditAgreeSuccessHook($promoter_id, 1);
			}
		}
		return $retval;
	}
	
	/**
	 * 分销商审核通过
	 */
	public function promoterAuditAgreeSuccessHook($promoter_id, $level)
	{
		if ($level > 3) return;
		
		$title = '申请通过通知';
		$tag = "promoter_audit";
		switch ($level) {
			case 2:
				$title = '下级申请通过通知';
				$tag = "promoter_child_audit";
				break;
			case 3:
				$title = '下下级申请通过通知';
				$tag = "promoter_subchild_audit";
				break;
		}
		
		$promoter = new NfxPromoterModel();
		$promoter_info = $promoter->getInfo(array(
			"promoter_id" => $promoter_id
		), "uid,parent_promoter,promoter_shop_name");

//		hook('promoterAuditAgreeSuccess', [
//			'uid' => $promoter_info['uid'],
//			'promoter_shop_name' => $promoter_info['promoter_shop_name'],
//			'regidter_time' => time(),
//			'title' => $title
//		]);
		message($tag, [
			'uid' => $promoter_info['uid'],
			'promoter_shop_name' => $promoter_info['promoter_shop_name'],
			'audit_time' => time(),
			'title' => $title
		]);
		if ($promoter_info['parent_promoter'] > 0) {
			$level = $level + 1;
			$this->promoterAuditAgreeSuccessHook($promoter_info['parent_promoter'], $level);
		}
	}
	
	/**
	 * 获取分销商等级列表
	 */
	public function getPromoterLevelList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$promoter_level = new NfxPromoterLevelModel();
		$list = $promoter_level->pageQuery($page_index, $page_size, $condition, $order, '*');
		return $list;
	}
	
	/**
	 * 添加分销商等级
	 */
	public function addPromoterLevel($shop_id, $level_name, $level_money, $level_0, $level_1, $level_2)
	{
		$promoter_level = new NfxPromoterLevelModel();
		$data = array(
			"shop_id" => $shop_id,
			"level_name" => $level_name,
			"level_money" => $level_money,
			"level_0" => $level_0,
			"level_1" => $level_1,
			"level_2" => $level_2,
			"create_time" => time()
		);
		$promoter_level->save($data);
		return $promoter_level->level_id;
	}
	
	/**
	 * 修改分销商等级
	 */
	public function updatePromoterLevel($level_id, $level_name, $level_money, $level_0, $level_1, $level_2)
	{
		$promoter_level = new NfxPromoterLevelModel();
		$data = array(
			"level_name" => $level_name,
			"level_money" => $level_money,
			"level_0" => $level_0,
			"level_1" => $level_1,
			"level_2" => $level_2,
			"modify_time" => time()
		);
		$retval = $promoter_level->save($data, [
			"level_id" => $level_id
		]);
		return $retval;
	}
	
	/**
	 * 获取分销商信息
	 */
	public function getPromoterDetail($promoter_id)
	{
		$promoter = new NfxPromoterModel();
		$data = $promoter->get($promoter_id);
		if (!empty($data)) {
			// 查询分销商等级
			$data['promoter_level_info'] = $this->getPromoterLevalDetail($data['promoter_level']);
			// 查询分销商佣金
			$user_commission = new NfxUserAccountModel();
			$data['commission'] = $user_commission->getInfo([
				'uid' => $data['uid'],
				'shop_id' => $data['shop_id']
			], '*');
			
			if (!empty($data['commission'])) {
				// 保留两位小数并且四舍五入
				foreach ($data['commission'] as $key => $item) {
					if (strpos($key, 'commission') === 0) {
						$data['commission'][ $key ] = sprintf("%.2f", $item);
					}
				}
			}
			
			// 查询分销商用户信息
			$shop_member_association = new NfxShopMemberAssociationModel();
			$data['shop_user_info'] = $shop_member_association->getInfo([
				'uid' => $data['uid'],
				'shop_id' => $data['shop_id']
			], '*');
			
			// 查询会员团队人数
			$team_promoter_ids = $this->getTeamAllPromoter($promoter_id);
			
			$promoter_ids = implode(',', $team_promoter_ids);
			$team_promoter_ids = explode(',', $promoter_ids);
			
			// 团队中分销商人数
			$team_promoter_num = is_array($team_promoter_ids) ? count($team_promoter_ids) : 0;
			// 团队中会员人数
			$team_member_num = 0;
			if (!empty($team_promoter_ids)) {
				$promoter_ids = implode(',', $team_promoter_ids);
				$source_uids = $shop_member_association->query('SELECT GROUP_CONCAT(nsma.uid) as source_uids FROM nfx_shop_member_association nsma WHERE nsma.promoter_id in (' . $promoter_ids . ')');
				if (!empty($source_uids[0]['source_uids'])) {
					$team_member_num = $shop_member_association->getCount("is_promoter = 0 AND ( (source_uid IN ({$source_uids[0]['source_uids']}) AND promoter_id = 0) OR promoter_id IN({$promoter_ids}) )");
				}
			}
			$data['team_count'] = $team_promoter_num + $team_member_num;
		}
		return $data;
	}
	
	/**
	 * 获取分销商上级
	 */
	public function getPromoterParent($promoter_id)
	{
		$promoter = new NfxPromoterModel();
		$data = $promoter->getInfo([
			'promoter_id' => $promoter_id
		], 'parent_promoter');
		return $data;
	}
	
	/**
	 * 修改分销商上级
	 */
	public function modifyPromoterParent($promoter_id, $parent_no, $shop_id, $up_id)
	{
		$promoter = new NfxPromoterModel();
		$promoter_info = $promoter->getInfo(array(
			"promoter_no" => $parent_no,
			"shop_id" => $shop_id,
			"is_audit" => 1
		));
		
		if ($up_id) {
			$upid_arr = explode(",", $up_id);
			$data = array(
				"parent_promoter" => $promoter_info["promoter_id"]
			);
			$retval = $promoter->save($data, [
				"promoter_id" => [ 'in', $upid_arr ]
			]);
		} else {
			
			if (empty($promoter_info)) {
				return 0;
			}
			if ($promoter_info["promoter_id"] == $promoter_id) {
				return 0;
			}
			// 判断所改父级是否是自己的自级
			$parent_array = $this->getPromoterParentQuery($promoter_info["promoter_id"], $shop_id);
			if (in_array($promoter_id, $parent_array)) {
				return 0;
			}
			$promoter = new NfxPromoterModel();
			$data = array(
				"parent_promoter" => $promoter_info["promoter_id"]
			);
			$retval = $promoter->save($data, [
				"promoter_id" => $promoter_id
			]);
		}
		return $retval;
	}
	
	/**
	 * 获取分销商股东信息
	 */
	public function getPromoterPartner($promoter_id)
	{
		$promoter = new NfxPromoterModel();
		$data = $promoter->getInfo([
			'promoter_id' => $promoter_id,
			"is_audit" => 1
		], '');
		return $data;
	}
	
	/**
	 * 获取分销商等级信息
	 */
	public function getPromoterLevalDetail($level_id)
	{
		$promoter_level = new NfxPromoterLevelModel();
		$data = $promoter_level->get($level_id);
		return $data;
	}
	
	/**
	 * 开启关闭分销商
	 */
	public function modifyPromoterLock($promoter_id, $is_lock)
	{
		$promoter = new NfxPromoterModel();
		$data = array(
			"is_lock" => $is_lock
		);
		$retval = $promoter->save($data, [
			"promoter_id" => $promoter_id
		]);
		return $retval;
	}
	
	/**
	 * 获取分销佣金列表
	 */
	public function getCommissionDistributionList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$order_query = new OrderQuery();
		$order_list = $order_query->getOrderList($page_index, $page_size, $condition, $order);
		foreach ($order_list["data"] as $k => $v) {
			$commission_money = 0;
			
			foreach ($v["order_item_list"] as $l => $b) {
				$order_item = $v["order_item_list"][ $l ];
				$commossion_distribution = new NfxCommissionDistributionModel();
				$commossion_distribution_condition = array(
					"order_id" => $b["order_id"],
					"order_goods_id" => $b["order_goods_id"]
				);
				$commission_distribution_list = $commossion_distribution->all($commossion_distribution_condition);
				if (count($commission_distribution_list) > 0) {
					foreach ($commission_distribution_list as $commission_k => $commission_v) {
						$promoter = new NfxPromoterModel();
						$promoter_info = $promoter->getInfo([
							'promoter_id' => $commission_v["promoter_id"]
						], 'uid');
						$uid = $promoter_info["uid"];
						$user = new UserModel();
						$user_info = $user->getInfo([
							'uid' => $uid
						], "nick_name");
						$realname = $user_info["nick_name"];
						$commission_distribution_list[ $commission_k ]["realname"] = $realname;
						$commission_money = $commission_money + $commission_v["commission_money"];
						$promoter = new NfxPromoterModel();
						$prometerinfo = $promoter->getInfo([ 'uid' => $uid ]);
						$commission_distribution_list[ $commission_k ]['promoter_no'] = $prometerinfo['promoter_no'];
						$commission_distribution_list[ $commission_k ]['promoter_shop_name'] = $prometerinfo['promoter_shop_name'];
					}
				}
				$order_item["commission_distribution_list"] = $commission_distribution_list;
			}
			$order_list["data"][ $k ]["commission_money"] = $commission_money;
		}
		return $order_list;
	}
	
	/**
	 * 获取会员分销商
	 */
	public function getUserPromoter($uid)
	{
		$promoter_model = new NfxPromoterModel();
		$condition = array(
			"shop_id" => 0,
			"uid" => $uid
		);
		$data = $promoter_model->getFirstData($condition, "promoter_id desc");
		
		return empty($data) ? [] : $data;
	}
	
	/**
	 * 获取会员分销商列表
	 */
	public function getUserPromoterList($uid)
	{
		$promoter = new NfxPromoterModel();
		$user_promoter_list = $promoter->getQuery([
			'uid' => $uid,
			'is_audit' => 1
		], '*', 'regidter_time desc');
		$shop = new NsShopModel();
		$shop_member_assiociation = new NfxShopMemberAssociationModel();
		$shop_account = new NsShopAccountModel();
		$user_account = new NfxUserAccountModel();
		foreach ($user_promoter_list as $item) {
			$shop_info = $shop->getInfo([
				'shop_id' => $item['shop_id']
			], 'shop_name,shop_logo');
			$item['shop_name'] = $shop_info['shop_name'];
			$item['shop_logo'] = $shop_info['shop_logo'];
			// 查询会员相关信息
			$user_info = $shop_member_assiociation->getInfo([
				'shop_id' => $item['shop_id'],
				'uid' => $uid
			], 'is_promoter, is_partner, region_center_id');
			$item['is_promoter'] = $user_info['is_promoter'];
			$item['is_partner'] = $user_info['is_partner'];
			$item['region_center_id'] = $user_info['region_center_id'];
			
			// 查询会员团队人数
			$team_promoter_ids = $this->getTeamAllPromoter($item['promoter_id']);
			// 团队中分销商人数
			$team_promoter_num = is_array($team_promoter_ids) ? count($team_promoter_ids) : 0;
			// 团队中会员人数
			$shop_member_association = new NfxShopMemberAssociationModel();
			$team_member_num = 0;
			if (!empty($team_promoter_ids)) {
				$promoter_ids = implode(',', $team_promoter_ids);
				$source_uids = $shop_member_association->query('SELECT GROUP_CONCAT(nsma.uid) as source_uids FROM nfx_shop_member_association nsma WHERE nsma.promoter_id in (' . $promoter_ids . ')');
				if (!empty($source_uids[0]['source_uids'])) {
					$team_member_num = $shop_member_association->getCount("is_promoter = 0 AND ( (source_uid IN ({$source_uids[0]['source_uids']}) AND promoter_id = 0) OR promoter_id IN({$promoter_ids}) )");
				}
			}
			$item['team_count'] = $team_promoter_num + $team_member_num;
			// 查询店铺信息
			$shop_account_info = $shop_account->getInfo([
				'shop_id' => $item['shop_id']
			], 'shop_profit');
			$item['shop_profit'] = $shop_account_info['shop_profit'];
			// 查询会员佣金信息
			$account_info = $user_account->getInfo([
				'shop_id' => $item['shop_id'],
				'uid' => $uid
			], 'commission');
			$item['commission'] = round($account_info['commission'], 2);
		}
		return $user_promoter_list;
	}
	
	/**
	 * 获取分销商等级
	 */
	public function getPromoterLevelAll($shop_id, $order = "")
	{
		$promoter_level = new NfxPromoterLevelModel();
		$data = $promoter_level->getQuery([ 'shop_id' => $shop_id ], "*", $order);
		return $data;
	}
	
	/**
	 * 查询分销商的上级
	 * 返回上级推广云uid 以，隔开
	 */
	private function getPromoterParentQuery($promoter_id, $shop_id)
	{
		$is_go = 0;
		$parent_array = array();
		while ($is_go == 0) {
			$promoter = new NfxPromoterModel();
			$promoter_info = $promoter->getInfo(array(
				"shop_id" => $shop_id,
				"promoter_id" => $promoter_id,
				"is_audit" => 1
			));
			if (!empty($promoter_info)) {
				$promoter_id = $promoter_info["parent_promoter"];
				$parent_array[] = $promoter_info["parent_promoter"];
			} else {
				$is_go = 1;
			}
		}
		return $parent_array;
	}
	
	/**
	 * 获取一定条件下所有分销商
	 */
	public function getPromoterAll($condition)
	{
		$promoter = new NfxPromoterModel();
		$promoter_all = $promoter->all($condition);
		return $promoter_all;
	}
	
	/**
	 * 删除分销商等级
	 */
	public function deletePromoterLevel($shop_id, $level_id)
	{
		$promoter = new NfxPromoterModel();
		$count = $promoter->getCount(array(
			"shop_id" => $shop_id,
			"promoter_level" => $level_id
		));
		if ($count == 0) {
			$promoter_level = new NfxPromoterLevelModel();
			$retval = $promoter_level->where(array(
				"shop_id" => $shop_id,
				"level_id" => $level_id
			))->delete();
			return $retval;
		} else {
			return 0;
		}
	}
	
	/**
	 * 获取分销佣金总计
	 */
	public function getDistributionCommissionCount($condition)
	{
		$distribution_commission = new NfxCommissionDistributionModel();
		$result = $distribution_commission->getQuery($condition, "sum(commission_money) as sum");
		return $result[0]["sum"];
	}
	
	/**
	 * 获取分销商上级
	 */
	public function getPromoterParentByUidAndShopid($shop_id, $uid)
	{
		$promoter = new NfxPromoterModel();
		$array = array(
			'parent_promoter' => 0,
			'parent_uid' => 0
		);
		$data = $promoter->getInfo([ 'shop_id' => $shop_id, 'uid' => $uid ], 'parent_promoter');
		$array['parent_promoter'] = $data['parent_promoter'] > 0 ? $data['parent_promoter'] : 0;
		if ($data['parent_promoter'] > 0) {
			$parent_uid = $promoter->getInfo([ 'promoter_id' => $data['parent_promoter'] ], 'uid');
			$array['parent_uid'] = $parent_uid['uid'] > 0 ? $parent_uid['uid'] : 0;
		}
		return $array;
	}
	
	/**
	 * 获取分销商直属下级
	 */
	public function getPromoterChildren($promoter_id)
	{
		$promoter = new NfxPromoterModel();
		$list = $promoter->getQuery([ 'parent_promoter' => $promoter_id, 'is_audit' => 1 ], 'promoter_id');
		return $list;
	}
	
	/**
	 * 查询团队列表
	 */
	public function getPromoterTeamList($promoter_id)
	{
		$array_self = array(
			'0' => array( 'promoter_id' => $promoter_id )
		);
		$array_two = array();
		$array_three = array();
		$shop_member = new NfxShopMemberAssociationModel();
		//下一级分销商
		$array_one = $this->getPromoterChildren($promoter_id);
		if (!empty($array_one)) {
			foreach ($array_one as $k => $v) {
				$array_two_new = $this->getPromoterChildren($v['promoter_id']);
				//下两级分销商
				$array_two = array_merge($array_two, $array_two_new);
				if (!empty($array_two_new)) {
					$array_three_new = array();
					foreach ($array_two_new as $ko => $vo) {
						$array_three_new = $this->getPromoterChildren($vo['promoter_id']);
						//下三级分销商
						$array_three = array_merge($array_three, $array_three_new);
					}
				}
			}
		}
		//分销商数组 包括自己  下级   下下级   下下下级
		$array = array_merge($array_self, $array_one, $array_two, $array_three);
		$data = array();
		foreach ($array as $ka => $va) {
			$data_new = $shop_member->getQuery([ 'promoter_id' => $va['promoter_id'] ]);
			$data = array_merge($data_new, $data);
		}
		$user = new UserModel();
		//查询会员信息
		if (!empty($data)) {
			foreach ($data as $k => $v) {
				if ($v['source_uid'] > 0) {
					$recommender_name = $user->getInfo([ "uid" => $v['source_uid'] ], "nick_name");
					$data[ $k ]["recommender_name"] = $recommender_name['nick_name'];
				} else {
					$data[ $k ]["recommender_name"] = '';
				}
				if ($v['is_partner'] == 1) {
					$data[ $k ]["role_name"] = '股东';
				} else if ($v['is_promoter'] == 1) {
					$data[ $k ]["role_name"] = '分销商';
				} else {
					$data[ $k ]['role_name'] = '会员';
				}
				$data[ $k ]["user_info"] = $user->getInfo([ "uid" => $v["uid"] ], "nick_name,user_headimg,reg_time");
			}
		}
		return $data;
	}
	
	/**
	 * 获取我的团队信息
	 */
	public function getPromoterTeamListNew($promoter_id, $type = '', $page = 1, $page_size = PAGESIZE)
	{
		$promoter_ids = implode(',', $this->getTeamAllPromoter($promoter_id));
		$shop_member_association = new NfxShopMemberAssociationModel();
		if ($type == 'promoter') {
			$condition = [
				'nsma.is_promoter' => 1,
				'nsma.promoter_id' => [ 'in', $promoter_ids ]
			];
		} else if ($type == 'member') {
			$uid_data = $shop_member_association->query('SELECT GROUP_CONCAT(nsma.uid) as source_uids FROM nfx_shop_member_association nsma WHERE nsma.promoter_id in (' . $promoter_ids . ')');
			if (!empty($uid_data[0]['source_uids'])) {
				$condition = "nsma.is_promoter = 0 AND ( (nsma.source_uid IN ({$uid_data[0]['source_uids']}) AND nsma.promoter_id = 0) OR nsma.promoter_id IN({$promoter_ids}) )";
			}
		}
		$alias = 'nsma';
		$join = [
			[ 'sys_user nu', 'nsma.uid = nu.uid', 'LEFT' ],
			[ 'sys_user nu1', 'nsma.source_uid = nu1.uid', 'LEFT' ]
		];
		$field = 'nsma.*,nu.nick_name,nu.user_headimg,nu.reg_time,nu1.nick_name as recommender_name';
		$result = $shop_member_association->getViewList($page, $page_size, $condition, '', $field, $join, $alias);
		return $result;
	}
	
	/**
	 * 获取团队中的全部分销商
	 * @param unknown $promoter_id
	 */
	public function getTeamAllPromoter($promoter_id)
	{
		$promoter_id_array = [ $promoter_id ];
		$nfx_promoter = new NfxPromoterModel();
		// 查询下级分销商
		$lower_one_level = $nfx_promoter->query('SELECT GROUP_CONCAT(np.promoter_id) as promoter_ids FROM nfx_promoter np WHERE np.parent_promoter=' . $promoter_id . ' AND np.is_audit = 1');
		if ($lower_one_level[0]['promoter_ids']) {
			$promoter_id_array[1] = $lower_one_level[0]['promoter_ids'];
			// 查询下下级分销商
			$lower_two_level = $nfx_promoter->query('SELECT GROUP_CONCAT(np.promoter_id) as promoter_ids FROM nfx_promoter np WHERE np.parent_promoter in (' . $lower_one_level[0]['promoter_ids'] . ') AND np.is_audit = 1');
			if ($lower_two_level[0]['promoter_ids']) {
				$promoter_id_array[2] = $lower_two_level[0]['promoter_ids'];
				// 查询下下下级分销商
				$lower_three_level = $nfx_promoter->query('SELECT GROUP_CONCAT(np.promoter_id) as promoter_ids FROM nfx_promoter np WHERE np.parent_promoter in (' . $lower_two_level[0]['promoter_ids'] . ') AND np.is_audit = 1');
				if ($lower_three_level[0]['promoter_ids']) {
					$promoter_id_array[3] = $lower_three_level[0]['promoter_ids'];
				}
			}
		}
		return $promoter_id_array;
	}
	
	/*
	 *创建分销商编码
	 */
	private function createPromoterNo()
	{
		$promoter = new NfxPromoterModel();
		$promoter_info = $promoter->getFirstData("promoter_no != ''", "promoter_no desc");
		if (empty($promoter_info)) {
			$promoter_no = "FX" . sprintf("%06d", 1);
		} else {
			$max_id = substr($promoter_info["promoter_no"], 2) + 1;
			$promoter_no = "FX" . sprintf("%06d", $max_id);
		}
		return $promoter_no;
	}
	
	/**
	 * 删除分销商
	 */
	public function deletePromoter($shop_id, $promoter_id)
	{
		$promoter = new NfxPromoterModel();
		$retval = $promoter->destroy([ "shop_id" => $shop_id, "promoter_id" => $promoter_id, "is_audit" => -1 ]);
		return $retval;
	}
	
	/**
	 *  修改分销商等级
	 */
	public function modifyPromoterLevel($shop_id, $promoter_id, $level_id)
	{
		$promoter = new NfxPromoterModel();
		$promoter_info = $promoter->getInfo(array( "shop_id" => $shop_id, "promoter_id" => $promoter_id, "is_audit" => 1 ), "*");
		if (empty($promoter_info)) {
			return 0;
		}
		if ($promoter_info["promoter_level"] == $level_id) {
			return 0;
		}
		$retval = $promoter->save(array( "promoter_level" => $level_id ), array( "shop_id" => $shop_id, "promoter_id" => $promoter_id ));
		return $retval;
	}
	
	/**
	 * 修改分销商店铺名称
	 */
	public function modifyShopName($shop_id, $promoter_id, $promoter_shop_name)
	{
		$promoter = new NfxPromoterModel();
		$data = array(
			'shop_id' => $shop_id,
			"promoter_shop_name" => $promoter_shop_name
		);
		$retval = $promoter->save($data, [ "promoter_id" => $promoter_id ]);
		return $retval;
		
	}
	
	/**
	 * 查询团队列表  后台
	 */
	public function getAdminPromoterTeamList($promoter_id)
	{
		$array_self = array(
			'0' => array( 'promoter_id' => $promoter_id )
		);
		$array_two = array();
		$array_three = array();
		$shop_member = new NfxShopMemberAssociationModel();
		//下一级分销商
		$array_one = $this->getPromoterChildren($promoter_id);
		if (!empty($array_one)) {
			foreach ($array_one as $k => $v) {
				$array_two_new = $this->getPromoterChildren($v['promoter_id']);
				//下两级分销商
				$array_two = array_merge($array_two, $array_two_new);
				if (!empty($array_two_new)) {
					foreach ($array_two_new as $ko => $vo) {
						$array_three_new = $this->getPromoterChildren($vo['promoter_id']);
						//下三级分销商
						$array_three = array_merge($array_three, $array_three_new);
					}
				}
			}
		}
		//分销商数组 包括自己  下级   下下级   下下下级
		$array = array_merge($array_self, $array_one, $array_two, $array_three);
		$data = array();
		$promoter = new NfxPromoterModel();
		
		foreach ($array as $ka => $va) {
			$data_new = $shop_member->getQuery([ 'promoter_id' => $va['promoter_id'] ]);
			$data = array_merge($data_new, $data);
		}
		$user = new UserModel();
		//查询会员信息
		if (!empty($data)) {
			foreach ($data as $k => $v) {
				if ($v['source_uid'] > 0) {
					$recommender_name = $user->getInfo([ "uid" => $v['source_uid'] ], "nick_name");
					$data[ $k ]["recommender_name"] = $recommender_name['nick_name'];
				} else {
					$data[ $k ]["recommender_name"] = '';
				}
				if ($v['is_partner'] == 1) {
					$data[ $k ]["role_name"] = '股东';
				} else if ($v['is_promoter'] == 1) {
					$data[ $k ]["role_name"] = '分销商';
				} else {
					$data[ $k ]['role_name'] = '会员';
				}
				$data[ $k ]["user_info"] = $user->getInfo([
					"uid" => $v["uid"]
				], "nick_name,user_headimg,reg_time");
				
				$promoter_info = $promoter->getInfo([ 'uid' => $v['uid'] ], '*');
				$promoter_level = new NfxPromoterLevelModel();
				$level_name = $promoter_level->getInfo([ 'level_id' => $promoter_info['promoter_level'] ], 'level_name');
				$promoter_info['level_name'] = $level_name['level_name'];
				$data[ $k ]["promoter_info"] = $promoter_info;
				
			}
		}
		
		return $data;
	}
	
	/**
	 * 查询会员是否是分销商 和编号
	 */
	public function getShopMemberAssociation($uid)
	{
		$member_association = new NfxShopMemberAssociationModel();
		$member_association_info = $member_association->getInfo([ 'uid' => $uid ], '*');
		
		$promoter_id = $member_association_info['promoter_id'];
		
		$member_promoter = array();
		$member_promoter['is_promoter'] = $member_association_info['is_promoter'];
		$member_promoter['promoter_id'] = $member_association_info['promoter_id'];
		
		if ($promoter_id != 0) {
			$promoter = new NfxPromoterModel();
			$promoter_no = $promoter->getInfo([ 'promoter_id' => $promoter_id ], 'promoter_no')['promoter_no'];
			$member_promoter['promoter_no'] = $promoter_no;
		} else {
			$member_promoter['promoter_no'] = '';
		}
		
		return $member_promoter;
	}
	
	/**
	 * 验证是否存在该会员编号
	 */
	public function modifyPromoterNo($promoter_no)
	{
		$promoter = new NfxPromoterModel();
		$promoter_info = $promoter->getInfo([ 'promoter_no' => $promoter_no ], '*');
		if (empty($promoter_info)) {
			return 0;
		} else {
			return 1;
		}
	}
	
	/**
	 * 修改分销商编码
	 */
	public function updateMemberByAdmin($uid, $promoter_no)
	{
		if (!empty($promoter_no)) {
			//根据会员编号查询promoter_id
			$promoter = new NfxPromoterModel();
			$promoter_id = $promoter->getInfo([ 'promoter_no' => $promoter_no ], 'promoter_id')['promoter_id'];
			//修改会员分销商上级
			$member_association = new NfxShopMemberAssociationModel();
			$res = $member_association->save([ 'promoter_id' => $promoter_id ], [ 'uid' => $uid ]);
			return $res;
		}
	}
	
	/**
	 * 修改分销商上级会员
	 */
	public function updateMemberPromoter($uid, $promoter_uid)
	{
		$shop_member_association = new NfxShopMemberAssociationModel();
		$promoter_info = $shop_member_association->getInfo([ 'uid' => $uid ], 'promoter_id,is_promoter');
		if (!empty($promoter_info)) {
			if ($promoter_info['is_promoter'] == 1) {
				return 1;
			} else {
				if ($promoter_info['promoter_id'] != 0) {
					return 1;
				} else {
					if ($promoter_uid) {
						$parent_promoter = $shop_member_association->getInfo([ 'uid' => $promoter_uid ], 'promoter_id');
						$res = $shop_member_association->save([ 'promoter_id' => $parent_promoter['promoter_id'] ], [ 'uid' => $uid ]);
						return $res;
						
					} else {
						return 1;
					}
				}
			}
		} else {
			return 1;
		}
	}
	
	/**
	 * 会员列表
	 */
	public function getMemberList($page_index = 1, $page_size = 0, $condition = '', $order = '', $field = '*')
	{
		$member_view = new NsMemberViewModel();
		$result = $member_view->getViewList($page_index, $page_size, $condition, $order);
		foreach ($result['data'] as $k => $v) {
			$member_account = new MemberAccount();
			$result['data'][ $k ]['point'] = $member_account->getMemberPoint($v['uid'], '');
			$result['data'][ $k ]['balance'] = $member_account->getMemberBalance($v['uid']);
			$result['data'][ $k ]['coin'] = $member_account->getMemberCoin($v['uid']);
			
			$result['data'][ $k ]['member_promoter'] = $this->getShopMemberAssociation($v['uid']);
		}
		return $result;
	}
	
	/**
	 * 判断分销商下级
	 */
	public function panduanTuiguan($up_id, $parent_promoter)
	{
		$promoter = new NfxPromoterModel();
		
		$up_id_arr = explode(",", $up_id);
		
		$promoter_info = $promoter->getInfo(array(
			"promoter_no" => $parent_promoter,
			"shop_id" => $this->instance_id,
			"is_audit" => 1
		));
		$res = 0;
		if (!empty($promoter_info)) {
			// 判断所改父级是否是自己的自级
			$parent_array = $this->getPromoterParentQuery($promoter_info["promoter_id"], $this->instance_id);
			foreach ($up_id_arr as $val) {
				if (in_array($val, $parent_array)) {
					$res = 1;
					break;
				}
			}
		}
		
		return $res;
	}
	
	/**
	 * 根据分销商编号查找分销商信息
	 */
	public function getTuiGuangDetail($promoter_no)
	{
		$promoter = new NfxPromoterModel();
		
		$info = $promoter->getInfo([ 'promoter_no' => $promoter_no ]);
		
		return $info;
	}
	
	/**
	 * 获取分销商详情
	 */
	public function getPromoterDetailByUid($uid, $field = '*')
	{
		$promoter = new NfxPromoterModel();
		$info = $promoter->getInfo([ 'uid' => $uid ], $field);
		return $info;
	}
	
	/**
	 * 添加推广员商品
	 */
	public function addPromoterGoods($promoter_id, $goods_ids)
	{
		if (empty($promoter_id) || empty($goods_ids)) return;
		$goods_arr = $goods_ids = explode(',', $goods_ids);
		$data = [];
		foreach ($goods_arr as $goods_id) {
			array_push($data, [ 'promoter_id' => (int) $promoter_id, 'goods_id' => (int) $goods_id ]);
		}
		$model = new NfxPromoterGoodsModel();
		$old_list = $model->getQuery([ 'promoter_id' => $promoter_id ], 'promoter_id, goods_id');
		foreach ($old_list as $k => $v) {
			foreach ($data as $key => $val) {
				if ($v['goods_id'] == $val['goods_id']) unset($data[ $key ]);
				unset($val);
			}
			unset($v);
		}
		$res = $model->saveAll($data);
		return $res;
	}
	
	/**
	 * 获取推广员已选商品
	 */
	public function getPromoterGoodsIds($promoter_id)
	{
		$model = new NfxPromoterGoodsModel();
		$list = $model->getQuery([ 'promoter_id' => $promoter_id ], 'goods_id');
		if (!empty($list)) {
			$data = [];
			foreach ($list as $item) {
				array_push($data, $item['goods_id']);
			}
			return implode(',', $data);
		} else {
			return '';
		}
	}
	
	/**
	 * 删除已选商品
	 */
	public function delectPromoterGoodsId($ids, $promoter_id)
	{
		if (empty($promoter_id)) return -1;
		$model = new NfxPromoterGoodsModel();
		$res = $model->destroy([ 'goods_id' => [ 'in', $ids ], 'promoter_id' => $promoter_id ]);
		return $res;
	}
	
	/**
	 * 获取推广员佣金列表
	 */
	public function getCommissionPageList($page_index = 1, $page_size = PAGESIZE, $condition = [], $order = '')
	{
		$model = new NfxCommissionDistributionModel();
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
	
	/**
	 * 修改分销商店铺
	 */
	public function modifyShop($data, $condition)
	{
		$promoter = new NfxPromoterModel();
		if (empty($condition)) return;
		$retval = $promoter->save($data, $condition);
		return $retval;
	}
	
	/**
	 * 获取会员上级推广员
	 */
	public function getMemberParentPromoter($uid)
	{
		$parent_partner_info = [];
		// 查询该会员是否是推广员
		$partner = new NfxPromoterModel();
		$promoter_info = $partner->getInfo([ 'uid' => $uid, 'is_audit' => 1, 'is_lock' => 0 ]);
		if (empty($promoter_info)) {
			$member_association_model = new NfxShopMemberAssociationModel();
			$member_association_info = $member_association_model->getInfo([ 'uid' => $uid ], 'source_uid');
			if (!empty($member_association_info['source_uid'])) {
				$partner = new NfxPromoterModel();
				$parent_partner_info = $partner->getInfo([ 'uid' => $member_association_info['source_uid'], 'is_audit' => 1, 'is_lock' => 0 ]);
				return $parent_partner_info;
			} else {
				return $parent_partner_info;
			}
		} else {
			return $parent_partner_info;
		}
	}
	
	/**
	 * 获取分销商数据
	 * @param array $where
	 * @param string $field
	 * @param string $ailas
	 * @param unknown $join
	 * @param unknown $data
	 * @return unknown
	 */
	public function getInfo($where = [], $field = '*', $ailas = 'np', $join = NULL, $data = NULL){
		if (!empty($join)) {
			$info = Db::table('nfx_promoter')->alias($ailas)->join($join)->where($where)->field($field)->find($data);
		} else {
			$info = Db::table('nfx_promoter')->where($where)->field($field)->find($data);
		}
		return $info;
	}
}