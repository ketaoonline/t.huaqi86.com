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

use addons\NsWxappLive\data\service\Apply as ApplyService;
use addons\NsWxappLive\data\service\User as UserService;
use app\api\controller\BaseApi;

class Apply extends BaseApi
{
    public $service;
    public function __construct($params = []) {
        parent::__construct($params);
        $this->service = new ApplyService();
        $this->uid = 3;
    }

    public function applyInfo() {
        $title = "申请详情";
        $uid = $this->uid;
        if (empty($uid)) {
            return $this->outMessage($title, '', '-9999', '无法获取会员登录信息');
        }
        $id = $this->params['id'];
        if (empty($id)) {
            return $this->outMessage($title, '', '-9999', '参数错误');
        }
        $apply_info = $this->service->getApplyInfo(['id' => $id, 'uid' => $uid]);
        return $this->outMessage($title, $apply_info);
    }

    public function applyList() {
        $title = "申请列表";
        $uid = $this->uid;
        if (empty($uid)) {
            return $this->outMessage($title, '', '-9999', '无法获取会员登录信息');
        }
        $page_index = isset($this->params['page_index']) ? $this->params['page_index'] : 1;
        $page_size = isset($this->params['page_size']) ? $this->params['page_size'] : PAGESIZE;
        $condition = ['uid' => $uid];
        if (isset($this->params['status'])) {
            $condition['status'] = $this->params['status'];
        }
        $apply_list = $this->service->applyList($page_index, $page_size, $condition, 'id DESC');
        return $this->outMessage($title, $apply_list);
    }

    public function addOrEditApply() {
        $title = "申请直播间";
        $uid = $this->uid;
        if (empty($uid)) {
            return $this->outMessage($title, '', '-9999', '无法获取会员登录信息');
        }
        $user_service = new UserService();
        $user_info = $user_service->getUserInfo(['uid' => $uid]);
        if (is_null($user_info) || $user_info['status'] !== 2) {
            return $this->outMessage($title, '', '0', '您还不可以申请直播间哦！');
        }

        $live_uid = $user_info['id'];
        $room_name = $this->params['room_name'];
        $room_desc = $this->params['room_desc'];
        $start_time = $this->params['start_time'];
        $cover_img = $this->params['cover_img'];
        $share_img = $this->params['share_img'];

        if (empty($room_name)) {
            return $this->outMessage($title, '', '0', '直播间名称不可以为空！');
        }

        $data = [
            'uid' => $uid,
            'live_uid' => $live_uid,
            'room_name' => $room_name,
            'room_desc' => $room_desc,
            'start_time' => $start_time,
            'cover_img' => $cover_img,
            'share_img' => $share_img,
            'status' => 1
        ];
        $current_time = time();
        if (isset($this->params['id'])) {
            $data['modify_time'] = $current_time;
            $re = $this->service->editApply($this->params['id'], $data);
        } else {
            $data['create_time'] = $current_time;
            $data['modify_time'] = $current_time;
            $re = $this->service->addApply($data);
        }
        return $this->outMessage($title, $re);
    }
}