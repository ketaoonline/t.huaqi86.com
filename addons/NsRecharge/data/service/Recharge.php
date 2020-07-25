<?php
/**
 * AlipayConfig.php
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
namespace addons\NsRecharge\data\service;

use data\service\BaseService;
use addons\NsRecharge\data\model\NsRechargeModel;
use data\model\NsMemberRechargeModel;
use data\service\Member\MemberAccount;
use think\Log;
use data\model\BaseModel;
use data\service\Member;
use data\service\Member\MemberCoupon;

class Recharge extends BaseService
{
    /**
     * 添加或编辑充值有礼活动
     * @param unknown $params
     */
    public function addOrEditRecharge($params = []){
        $ns_recharge = new NsRechargeModel();
        $data = [
            'activity_name' => $params['activity_name'],
            'start_time' => strtotime($params['start_time']),
            'end_time' => strtotime($params['end_time']),
            'activity_type' => $params['activity_type'],
            'scene' => implode(',', $params['scene']),
            'data' => json_encode($params['data'])
        ];
        if (strtotime($params['start_time']) < time()) {
            $data['status'] = 1;
        }
        if (strtotime($params['end_time']) < time()) {
            $data['status'] = -1;
        }
        if (isset($params['id'])) {
            $res = $ns_recharge->save($data, ['id' => $params['id']]);
        } else {
            $ns_recharge->save($data);
            $res = $ns_recharge->id;
        }
        return $res;
    }
    
    /**
     * 获取充值有礼活动详情
     * @param unknown $params
     */
    public function getRechargeDetail($condition = [], $field = "*") {
        $ns_recharge = new NsRechargeModel();
        $info = $ns_recharge->getInfo($condition, $field);
        if (!empty($info)) {
            $info['scene'] = explode(',', $info['scene']);
            $info['data'] = json_decode($info['data'], true);
        }
        return $info;
    }
    
    /**
     * 充值活动开启和关闭
     */
    public function rechargeActivityOperation(){
        $ns_recharge = new NsRechargeModel();
        // 活动开启
        $ns_recharge->save(['status' => 1], ['status' => 0, 'start_time' => ['<', time()]]);
        // 活动关闭
        $ns_recharge->save(['status' => -1], ['status' => 1, 'end_time' => ['<', time()]]);
    }
    
    /**
     * 获取充值有礼活动分页列表
     * @param unknown $page_index
     * @param unknown $page_size
     * @param unknown $condition
     * @param unknown $order
     * @param unknown $field
     * @return multitype:number unknown
     */
    public function getRechargePageList($page_index = 1, $page_size = PAGESIZE, $condition = [], $order = 'id desc', $field = '*'){
        $ns_recharge = new NsRechargeModel();
        $list = $ns_recharge->pageQuery($page_index, $page_size, $condition, $order, $field);
        return $list;
    }
    
    /**
     * 获取充值有礼活动列表
     * @param unknown $condition
     * @param string $field
     * @param string $order
     */
    public function getRechargeList($condition = [], $field = '*', $order = 'id desc'){
        $ns_recharge = new NsRechargeModel();
        $list = $ns_recharge->getQuery($condition, $field, $order);
        if (!empty($list)) {
            foreach ($list as $k => $item) {
                $list[$k]['data'] = json_decode($item['data'], true);
            }
        }
        return $list;
    }
    
    /**
     * 删除充值有礼活动
     * @param unknown $ids
     * @return number
     */
    public function deleteRecharge($ids){
        $ns_recharge = new NsRechargeModel();
        $res = $ns_recharge->destroy([
            'id' => ['in', $ids],
            'status' => ['<>', 1]
        ]);
        return $res;
    }
    
    /**
     * 关闭充值有礼活动
     * @param unknown $ids
     * @return number
     */
    public function closeRecharge($id){
        $ns_recharge = new NsRechargeModel();
        $res = $ns_recharge->save(['status' => -1],['id' => $id]);
        return $res;
    }
    
    /**
     * 会员充值成功
     * @param unknown $out_trade_no
     */
    public function memberRechargeSuccess($out_trade_no){
        $ns_member_recharge = new NsMemberRechargeModel();
        $recharge_info = $ns_member_recharge->getInfo(['out_trade_no' => $out_trade_no, 'is_pay' => 1, 'is_grant' => 0], 'uid,recharge_money');
        if (!empty($recharge_info)) {
            $this->rechargeActivityGrant('member', $recharge_info['recharge_money'], $recharge_info['uid'], $out_trade_no);
        }
    }
    
    /**
     * 商家调整余额
     * @param unknown $recharge_money
     * @param unknown $uid
     */
    public function businessRechargeAfter($recharge_money, $uid){
        $this->rechargeActivityGrant('business', $recharge_money, $uid);
    }
    
    /**
     * 充值成功之后充值有礼活动礼品发放
     */
    public function rechargeActivityGrant($type, $recharge_money, $uid, $out_trade_no = ''){
        if ($type == 'member') {
            $list = $this->getRechargeList(['status' => 1,'scene' => ['like', '%member%']], 'id,activity_name,activity_type,data');
        } elseif($type == 'business') {
            $list = $this->getRechargeList(['status' => 1,'scene' => ['like', '%business%']], 'id,activity_name,activity_type,data');
        }
        if (!empty($list)) {
            foreach ($list as $activity_item) {
                $level_list = $activity_item['data'];
                array_multisort(array_column($level_list, 'condition'), SORT_DESC, $level_list);
                
                foreach ($level_list as $level_item) {
                    
                    if ($recharge_money >= $level_item['condition']) {
                        $give = ['balance' => 0, 'point' => 0, 'coupon' => []];    
                        $number = $activity_item['activity_type'] == 1 ? 1 : intval($recharge_money / $level_item['condition']);
                        foreach ($level_item['giveCont'] as $gift_item){
                            switch ($gift_item['type']) {
                                case 'balance':
                                    $give['balance'] += $gift_item['value'] * $number;
                                    break;
                                case 'balanceratio':
                                    $give['balance'] += $level_item['condition'] * ($gift_item['value'] / 100) * $number;
                                    break;
                                case 'point':
                                    $give['point'] += $gift_item['value'] * $number;
                                    break;
                                case 'pointratio':
                                    $give['point'] += intval($level_item['condition'] * ($gift_item['value'] / 100)) * $number;
                                    break;
                                case 'coupon':
                                    if (isset($give['coupon']['coupon_'.$gift_item['value']])){
                                        $give['coupon']['coupon_'.$gift_item['value']]['num'] += $number;
                                    } else{
                                        $give['coupon']['coupon_'.$gift_item['value']] = [
                                            'coupon_type_id' => $gift_item['value'],
                                            'num' => $number
                                        ];
                                    }
                                    break;
                            }
                        }
                        $this->giftGrant($activity_item, $give, $uid, $out_trade_no);
                        break;
                    }
                }
            }
        }
    }
    
    /**
     * 充值礼品发放
     * @param unknown $activity 活动详情
     * @param unknown $gift 要发放的内容
     * @param unknown $uid 
     * @param string $out_trade_no
     */
    private function giftGrant($activity, $gift, $uid, $out_trade_no = ''){
        try {
            $member_account = new MemberAccount();
            if ($gift['point'] > 0) {
                $text = '充值有礼'.$activity['activity_name'];
                $member_account->addMemberAccountData($this->instance_id, 1, $uid, 1, $gift['point'], 12, $activity['id'], $text);
            }
            if ($gift['balance'] > 0) {
                $text = '充值有礼'.$activity['activity_name'];
                $member_account->addMemberAccountData($this->instance_id, 2, $uid, 1, $gift['balance'], 12, $activity['id'], $text);
            }
            if (!empty($gift['coupon'])) {
                $member_coupon = new MemberCoupon();
                foreach ($gift['coupon'] as $coupon_item) {
                    for ($i = 0; $i < $coupon_item['num']; $i++) {
                        $member_coupon->userAchieveCoupon($uid, $coupon_item['coupon_type_id'], 4);                        
                    }
                }
            }
            if (!empty($out_trade_no)) {
                $ns_member_recharge = new NsMemberRechargeModel();
                $ns_member_recharge->save(['is_grant' => 1], ['out_trade_no' => $out_trade_no]);
            }
        } catch (\Exception $e) {
            Log::write('充值有礼，礼品发放报错，失败原因：'.$e->getMessage());
        }
    }
    
}