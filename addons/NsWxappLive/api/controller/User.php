<?php
/**
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

namespace addons\NsWxappLive\api\controller;

use addons\NsWxappLive\data\service\User as UserService;
use app\api\controller\BaseApi;

class User extends BaseApi
{
    public $service;

    public function __construct($params = []) {
        parent::__construct($params);
        $this->service = new UserService();
    }

    public function userInfo() {
        $title = "主播详情";
        $uid = $this->uid;
        if (empty($uid)) {
            return $this->outMessage($title, '', '-9999', '无法获取会员登录信息');
        }
        $user_info = $this->service->getUserInfo(['uid' => $uid]);
        return $this->outMessage($title, $user_info);
    }

    public function addOrEditUser() {
        $title = "主播申请";
        $uid = $this->uid;
        if (empty($uid)) {
            return $this->outMessage($title, '', '-9999', '无法获取会员登录信息');
        }

        $user_is_exists = $this->service->getUserInfo(['uid' => $uid, 'status' => ['NEQ', 3]]);

        if (!is_null($user_is_exists)) {
            return $this->outMessage($title, '', 0, '不可重复申请！');
        }

        $true_name = $this->params['true_name'];
        $wechat_id  = $this->params['wechat_id'];
        $identity_card = $this->params['identity_card'];
        $identity_card_back = $this->params['identity_card_back'];
        $identity_card_front = $this->params['identity_card_front'];
        $mobile = $this->params['mobile'];

        if (empty($true_name) || empty($wechat_id) || empty($identity_card) || empty($identity_card_back) || empty($identity_card_front) || empty($mobile)) {
            return $this->outMessage($title, '', 0, '真实姓名、微信号、身份证号、身份证正反面照、手机号不能为空！');
        }

        if (!preg_match('/^(1(([3456789][0-9])|(47)))\d{8}$/', $mobile)) {
            return $this->outMessage($title, '', 0, '请填写正确的手机号！');
        }

        if (!preg_match('/(^\d{15}$)|(^\d{17}([0-9]|X)$)/', $identity_card)) {
            return $this->outMessage($title, '', 0, '请填写正确的身份证号！');
        }

        $mobile_is_exists = $this->service->getUserInfo(['mobile' => $mobile]);
        if (!is_null($mobile_is_exists)) {
            return $this->outMessage($title, '', 0, '手机号已存在！');
        }
        $data = [
            'uid' => $uid,
            'true_name' => $true_name,
            'wechat_id' => $wechat_id,
            'identity_card' => $identity_card,
            'identity_card_back' => $identity_card_back,
            'identity_card_front' => $identity_card_front,
            'mobile' => $mobile,
            'status' => 1
        ];
        $time = time();
        if (isset($this->params['id'])) {
            $data['modify_time'] = $time;
            $re = $this->service->editUser($this->params['id'], $data);
        } else {
            $data['create_time'] = $data['modify_time'] = $time;
            $re = $this->service->addUser($data);
        }
        return $this->outMessage($title, AjaxReturn($re));
    }
}