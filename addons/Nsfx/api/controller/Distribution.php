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

namespace addons\Nsfx\api\controller;

use addons\Nsfx\data\service\NfxPartner;
use addons\Nsfx\data\service\NfxPromoter;
use addons\Nsfx\data\service\NfxRegionAgent;
use addons\Nsfx\data\service\NfxShopConfig;
use addons\Nsfx\data\service\NfxUser;
use app\api\controller\BaseApi;
use data\service\Address;
use data\service\Config;
use data\service\Member as MemberService;
use data\service\Shop as ShopService;
use data\service\WebSite;

/**
 * 分销
 */
class Distribution extends BaseApi
{
	public $nfx_shop_config;
	
	public function __construct($params = [])
	{
		parent::__construct($params);
		
		// 店铺配置
		$nfx_shop_config = new NfxShopConfig();
		$this->nfx_shop_config = $nfx_shop_config->getShopConfigDetail();
	}
	
	/**
	 * 店铺配置
	 */
	public function shopConfig()
	{
		$title = '店铺配置';
		$data['nfx_shop_config'] = $this->nfx_shop_config;
		return $this->outMessage($title, $data);
	}
	
	/**
	 * 我的团队
	 */
	public function teamList()
	{
		$title = '我的团队';
		if (empty($this->uid)) {
			return $this->outMessage($title, "", '-9999', "无法获取会员登录信息");
		}
		$nfx_promoter = new NfxPromoter();
		$promoter_id = isset($this->params['promoter_id']) ? $this->params['promoter_id'] : '';
		if (empty($promoter_id)) {
			return $this->outMessage($title, null, -50, '非法操作');
		} else {
			$team_list = $nfx_promoter->getPromoterTeamList($promoter_id);
			return $this->outMessage($title, $team_list);
		}
	}
	
	/**
	 * 手机端我的团队
	 */
	public function teamListWap()
	{
		$title = '我的团队';
		if (empty($this->uid)) {
			return $this->outMessage($title, "", '-9999', "无法获取会员登录信息");
		}
		$nfx_promoter = new NfxPromoter();
		$promoter_id = isset($this->params['promoter_id']) ? $this->params['promoter_id'] : '';
		$type = isset($this->params['type']) ? $this->params['type'] : 'promoter';
		$page = isset($this->params['page']) ? $this->params['page'] : 1;
		$page_size = isset($this->params['page_size']) ? $this->params['page_size'] : PAGESIZE;
		if (empty($promoter_id)) {
			return $this->outMessage($title, null, -50, '非法操作');
		} else {
			$team_list = $nfx_promoter->getPromoterTeamListNew($promoter_id, $type, $page, $page_size);
			return $this->outMessage($title, $team_list);
		}
	}
	
	/**
	 * 区域分销信息
	 */
	public function applyRegionalAgentInfo()
	{
		$title = '区域分销信息';
		if (empty($this->uid)) {
			return $this->outMessage($title, "", '-9999', "无法获取会员登录信息");
		}
		
		if ($this->nfx_shop_config['is_regional_agent'] == 0) {
			$this->outMessage($title, null, -10, '区域分销功能暂未开启，请联系管理人员');
		}
		
		$nfx_region_agent = new NfxRegionAgent();
		$region_config = $nfx_region_agent->getShopRegionAgentConfig($this->instance_id);
		
		if (empty($region_config)) {
			$this->outMessage($title, null, -10, '当前店铺未设置区域分销');
		}
		
		$region_agent_info = $nfx_region_agent->getPromoterRegionAgentValidDetail($this->instance_id, $this->uid);
		$agent_type = empty($region_agent_info) ? '-1' : $region_agent_info['is_audit'];
		$member_service = new MemberService();
		$shop_user_account = $member_service->getShopUserConsume($this->uid);
		$data = array(
			'agent_type' => $agent_type,
			'shop_sale_money' => $shop_user_account,
			'region_config' => $region_config,
			'shop_config' => $this->nfx_shop_config
		);
		return $this->outMessage($title, $data);
	}
	
	/**
	 * 申请区域分销
	 */
	public function applyRegionalAgent()
	{
		$title = '申请区域分销';
		if (empty($this->uid)) {
			return $this->outMessage($title, "", '-9999', "无法获取会员登录信息");
		}
		$nfx_region_agent = new NfxRegionAgent();
		$shop_id = isset($this->params['shop_id']) ? $this->params['shop_id'] : $this->instance_id;
		$agent_type = isset($this->params['agent_type']) ? $this->params['agent_type'] : 0;
		$real_name = isset($this->params['real_name']) ? $this->params['real_name'] : "";
		$mobile = isset($this->params['mobile']) ? $this->params['mobile'] : "";
		$address = isset($this->params['address']) ? $this->params['address'] : "";
		$retval = $nfx_region_agent->PromoterRegionAgentApplay($shop_id, $this->uid, $agent_type, $real_name, $mobile, $address);
		return $this->outMessage($title, AjaxReturn($retval));
	}
	
	/**
	 * 区域分销
	 */
	public function homeRegionAgent()
	{
		$title = '区域分销';
		if (empty($this->uid)) {
			return $this->outMessage($title, "", '-9999', "无法获取会员登录信息");
		}
		$shop_config = new NfxRegionAgent();
		$shop_info = $shop_config->getShopRegionAgentConfig($this->instance_id);
		$nfx_region_agent = new NfxRegionAgent();
		
		$region_agent_info = $nfx_region_agent->getPromoterRegionAgentValidDetail($this->instance_id, $this->uid);
		$address = new Address();
		$address_info = $address->getProvinceName($region_agent_info['agent_provinceid']);
		$agent_name = '省代';
		if ($region_agent_info['agent_type'] > 1) {
			$address_info .= $address->getCityName($region_agent_info['agent_cityid']);
			$agent_name = '市代';
		}
		if ($region_agent_info['agent_type'] > 2) {
			$address_info .= $address->getDistrictName($region_agent_info['agent_districtid']);
			$agent_name = '区代';
		}
		$member = new MemberService(); // 会员信息
		$member_info = $member->getMemberInfo();
		$nfx_user = new NfxUser();
		$user_account = $nfx_user->getNfxUserAccount($this->uid, $this->instance_id); // 佣金
		if ($region_agent_info["agent_type"] == 1) {
			$rate = $shop_info["province_rate"];
		} elseif ($region_agent_info["agent_type"] == 2) {
			$rate = $shop_info["city_rate"];
		} else {
			$rate = $shop_info["district_rate"];
		}
		$data = array(
			'nick_name' => $member_info['member_name'],
			'agent_name' => $agent_name,
			'address_info' => $address_info,
			'commission_region_agent' => $user_account['commission_region_agent'],
			'rate' => $rate
		);
		return $this->outMessage($title, $data);
	}
	
	/**
	 * 分销商申请信息
	 */
	public function applyPromoterInfo()
	{
		$title = '分销商申请信息';
		if (empty($this->uid)) {
			return $this->outMessage($title, "", '-9999', "无法获取会员登录信息");
		}
		$reapply = isset($this->params['reapply']) ? $this->params['reapply'] : 0;
		// 分销商信息表
		$nfx_promoter = new NfxPromoter();
		$promoter_info = $nfx_promoter->getUserPromoter($this->uid);
		
		if ($this->nfx_shop_config['is_distribution_enable'] == 0) {
			$this->outMessage($title, null, -10, '当前店铺未开启分销');
		}
		
		$promoter_info = empty($promoter_info) ? null : $promoter_info;
		
		// 获取店铺分销商等级
		$promoter_level = $nfx_promoter->getPromoterLevelAll($this->instance_id);
		if (empty($promoter_level)) {
			return $this->outMessage($title, null, -10, '当前店铺未设置分销商');
		}
		
		// 获取用户在本店的消费
		$member_service = new MemberService();
		$uid = $this->uid;
		$user_consume = $member_service->getShopUserConsume($uid);
		$data = array(
			'reapply' => $reapply,
			'user_consume' => $user_consume,
			'promoter_level' => $promoter_level,
			'promoter_info' => $promoter_info
		);
		return $this->outMessage($title, $data);
	}
	
	/**
	 * 申请分销商
	 */
	public function applyPromoter()
	{
		$title = '申请分销商';
		if (empty($this->uid)) {
			return $this->outMessage($title, "", '-9999', "无法获取会员登录信息");
		}
		$promoter = new NfxPromoter();
		$uid = $this->uid;
		$shop_id = isset($this->params['shop_id']) ? $this->params['shop_id'] : $this->instance_id;
		$promoter_shop_name = isset($this->params['promoter_shop_name']) ? $this->params['promoter_shop_name'] : "";
		$retval = $promoter->promoterApplay($uid, $shop_id, $promoter_shop_name);
		return $this->outMessage($title, AjaxReturn($retval));
	}
	
	/**
	 * 会员对于当前店铺的佣金情况
	 */
	public function userShopCommission()
	{
		$title = '会员对于当前店铺的佣金情况';
		if (empty($this->uid)) {
			return $this->outMessage($title, "", '-9999', "无法获取会员登录信息");
		}
		$nfx_user = new NfxUser();
		$user_account = $nfx_user->getNfxUserAccount($this->uid, $this->instance_id);
		if (empty($user_account["commission"])) {
			$user_account["commission"] = 0.00;
		}
		if (empty($user_account["commission_locked"])) {
			$user_account["commission_locked"] = 0.00;
		}
		if (empty($user_account["commission_withdraw"])) {
			$user_account["commission_withdraw"] = 0.00;
		}
		$user_account['shop_config'] = $this->nfx_shop_config;
		return $this->outMessage($title, $user_account);
	}
	
	/**
	 * 会员对于各个店铺佣金列表
	 */
	public function userCommissionList()
	{
		$title = '会员对于各个店铺佣金列表';
		if (empty($this->uid)) {
			return $this->outMessage($title, "", '-9999', "无法获取会员登录信息");
		}
		$nfx_user = new NfxUser();
		$user_account_list = $nfx_user->getUserAccountList($this->uid);
		return $this->outMessage($title, $user_account_list);
	}
	
	/**
	 * 会员佣金记录（明细）
	 */
	public function userAccountRecordsList()
	{
		$title = '会员佣金记录（明细）';
		if (empty($this->uid)) {
			return $this->outMessage($title, "", '-9999', "无法获取会员登录信息");
		}
		$shop_id = isset($this->params['shop_id']) ? $this->params['shop_id'] : $this->instance_id;
		$condition['nuar.shop_id'] = $shop_id;
		$condition['nuar.uid'] = $this->uid;
		$nfx_user = new NfxUser();
		$account_records_list = $nfx_user->getNfxUserAccountRecordsList(1, 0, $condition, 'create_time desc');
		return $this->outMessage($title, $account_records_list);
	}
	
	/**
	 * 具体项的佣金明细
	 */
	public function userAccountRecordsDetail()
	{
		$title = '具体项的佣金明细';
		if (empty($this->uid)) {
			return $this->outMessage($title, "", '-9999', "无法获取会员登录信息");
		}
		$condition['uid'] = $this->uid;
		$condition['shop_id'] = isset($this->params['shop_id']) ? $this->params['shop_id'] : $this->instance_id;
		$type_id = isset($this->params['type_id']) ? $this->params['type_id'] : "";
		
		$nfx_user = new NfxUser();
		$condition['account_type'] = $type_id;
		$account_records_detail = $nfx_user->getNfxUserAccountRecordsList(1, 0, $condition, 'create_time desc');
		
		if (!empty($account_records_detail)) {
			foreach ($account_records_detail as $k => $v) {
				$type_name = $v['type_name'];
			}
		} else {
			$account_type_id = $type_id;
			$account_records_type = $nfx_user->getUserAccountType($account_type_id);
			$type_name = $account_records_type['type_name'];
		}
		$data = array(
			'type_name' => $type_name,
			'account_records_detail' => $account_records_detail
		);
		return $this->outMessage($title, $data);
	}
	
	/**
	 * 分类佣金明细
	 */
	public function typeUserAccountRecords()
	{
		$title = '分类佣金明细';
		if (empty($this->uid)) {
			return $this->outMessage($title, "", '-9999', "无法获取会员登录信息");
		}
		$type_alis_id = request()->post('type_alis_id', '1');
		$condition['nuar.shop_id'] = $this->instance_id;
		$condition['nuar.uid'] = $this->uid;
		$nfx_user = new NfxUser();
		$account_records_list = $nfx_user->getNfxUserAccountRecordsList(1, 0, $condition, 'create_time desc');
		return $this->outMessage($title, $account_records_list);
	}
	
	/**
	 * 提现记录
	 */
	public function userCommissionWithdraw()
	{
		$title = '提现记录';
		if (empty($this->uid)) {
			return $this->outMessage($title, "", '-9999', "无法获取会员登录信息");
		}
		$nfx_user = new NfxUser();
		$shop_id = isset($this->params['shop_id']) ? $this->params['shop_id'] : $this->instance_id;
		$condition['shop_id'] = $shop_id;
		$condition['uid'] = $this->uid;
		$commission_withdraw_list = $nfx_user->getUserCommissionWithdraw(1, 0, $condition, 'ask_for_date desc');
		return $this->outMessage($title, $commission_withdraw_list);
	}
	
	/**
	 * 股东申请信息
	 */
	public function applyPartnerInfo()
	{
		$title = '股东申请信息';
		if (empty($this->uid)) {
			return $this->outMessage($title, "", '-9999', "无法获取会员登录信息");
		}
		$nfx_partner = new NfxPartner();
		$shop = new ShopService();
		$member_service = new MemberService();
		$shop_user_account = $member_service->getShopUserConsume($this->uid);
		$partner_level_list = $nfx_partner->getPartnerLevelAll($this->instance_id);
		$shop_sale_money = 0;
		$is_meet = 0; // 是否满足申请股东最低消费金额
		$level_money_arr = array();
		
		if ($this->nfx_shop_config['is_partner_enable'] == 0) {
			return $this->outMessage($title, null, -10, '股东功能暂未开启，请联系管理人员!');
		}
		foreach ($partner_level_list as $k => $v) {
			$level_money_arr[] = $v['level_money'];
		}
		if (!empty($level_money_arr)) {
			$shop_sale_money = min($level_money_arr);
			$level_isexist = true;
		} else {
			$level_isexist = false;
		}
		
		if (!$level_isexist) {
			if ($this->nfx_shop_config['is_partner_enable'] == 0) {
				return $this->outMessage($title, null, -10, '暂未设置股东等级，请联系管理人员!');
			}
		}
		
		if ($shop_user_account >= $shop_sale_money) {
			$is_meet = 1;
		}
		
		$partner_info = $nfx_partner->getPartnerValidDetail($this->instance_id, $this->uid);
		$agent_type = empty($partner_info) ? '2' : $partner_info['is_audit'];
		
		$data = array(
			'level_isexist' => $level_isexist,
			'is_meet' => $is_meet,
			'shop_user_account' => $shop_user_account, // 用户消费金额
			'shop_sale_money' => $shop_sale_money, // 申请股东最低消费金额
			'agent_type' => $agent_type,
			"shop_config" => $this->nfx_shop_config
		);
		return $this->outMessage($title, $data);
	}
	
	/**
	 * 申请股东
	 */
	public function applyPartner()
	{
		$title = '申请股东';
		if (empty($this->uid)) {
			return $this->outMessage($title, "", '-9999', "无法获取会员登录信息");
		}
		$nfx_partner = new NfxPartner();
		$shop_id = isset($this->params['shop_id']) ? $this->params['shop_id'] : $this->instance_id;
		$retval = $nfx_partner->partnerApplay($shop_id, $this->uid);
		return $this->outMessage($title, AjaxReturn($retval));
	}
	
	/**
	 * 股东信息
	 */
	public function homePartner()
	{
		$title = '股东信息';
		if (empty($this->uid)) {
			return $this->outMessage($title, "", '-9999', "无法获取会员登录信息");
		}
		$nfx_partner = new NfxPartner();
		$partner_info = $nfx_partner->getPartnerValidDetail($this->instance_id, $this->uid); // 股东信息
		$partner_level_info = $nfx_partner->getPartnerLevelDetail($partner_info['partner_level']); // 等级信息
		
		$nfx_user = new NfxUser();
		$user_account = $nfx_user->getNfxUserAccount($this->uid, $this->instance_id); // 佣金
		
		$member = new MemberService(); // 会员信息
		$member_info = $member->getMemberInfo();
		$data = array(
			'nick_name' => $member_info['member_name'],
			'level_name' => $partner_level_info['level_name'],
			'commission_rate' => $partner_level_info['commission_rate'] . '%',
			'commission_partner' => $user_account['commission_partner'],
			'commission_partner_global' => $user_account['commission_partner_global']
		);
		return $this->outMessage($title, $data);
	}
	
	/**
	 * 申请提现信息
	 */
	public function toWithdrawInfo()
	{
		$title = '申请提现信息';
		if (empty($this->uid)) {
			return $this->outMessage($title, "", '-9999', "无法获取会员登录信息");
		}
		$nfx_user = new NfxUser();
		// 选择的账户
		$member = new MemberService();
		$account_list = $member->getMemberBankAccount(1);
		// 佣金统计情况
		$user_account = $nfx_user->getNfxUserAccount($this->uid, $this->instance_id);
		$config_service = new Config();
		$withdraw_info = $config_service->getBalanceWithdrawConfig($this->instance_id);
		if ($withdraw_info["is_use"] == 0 || $withdraw_info["value"]["withdraw_multiple"] <= 0) {
			return $this->outMessage($title, null, -10, '当前店铺未开启提现，请联系管理人员!');
		}
		$data = array(
			'account_list' => $account_list,
			'user_account' => $user_account,
			'withdraw_info' => $withdraw_info['value']
		);
		return $this->outMessage($title, $data);
	}
	
	/**
	 * 申请提现
	 */
	public function toWithdraw()
	{
		$title = '申请提现';
		if (empty($this->uid)) {
			return $this->outMessage($title, "", '-9999', "无法获取会员登录信息");
		}
		$nfx_user = new NfxUser();
		// 提现
		$uid = $this->uid;
		$withdraw_no = isset($this->params['withdraw_no']) ? $this->params['withdraw_no'] : "";
		$bank_account_id = isset($this->params['bank_account_id']) ? $this->params['bank_account_id'] : "";
		$cash = isset($this->params['cash']) ? $this->params['cash'] : 0;
		$shop_id = isset($this->params['shop_id']) ? $this->params['shop_id'] : $this->instance_id;
		
		$retval = $nfx_user->addNfxCommissionWithdraw($shop_id, $withdraw_no, $uid, $bank_account_id, $cash);
		return $this->outMessage($title, AjaxReturn($retval));
	}
	
	public function getUserPromoterList()
	{
		$title = "";
		$nfx_promoter = new NfxPromoter();
		$list = $nfx_promoter->getUserPromoterList($this->uid);
		return $this->outMessage($title, $list);
	}
	
	/**
	 * 获取分销商信息
	 */
	public function promoterDetail()
	{
		$title = '获取分销商信息';
		if (empty($this->uid)) {
			return $this->outMessage($title, "", '-9999', "无法获取会员登录信息");
		}
		$nfx_promoter = new NfxPromoter();
		$promoter_info = $nfx_promoter->getUserPromoter($this->uid);
		
		$promoter_detail = [];
		if (!empty($promoter_info) && $promoter_info['is_audit'] == 1) {
			$promoter_detail = $nfx_promoter->getPromoterDetail($promoter_info['promoter_id']);
			return $this->outMessage($title, $promoter_detail);
		}
		return $this->outMessage($title, $promoter_detail, -1,"未获取到分销商信息");
	}
}