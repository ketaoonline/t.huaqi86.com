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

use addons\NsWxappLive\data\service\Room as RoomService;
use app\api\controller\BaseApi;

/**
 * 拼团订单控制器
 */
class Room extends BaseApi
{
    public $service;
    public function __construct($params = []) {
        parent::__construct($params);
        $this->service = new RoomService();
    }

    public function roomlist() {
        $title = '直播间列表';
        $page_index = isset($this->params['page_index']) ? $this->params['page_index'] : 1;
        $page_size = isset($this->params['page_size']) ? $this->params['page_size'] : PAGESIZE;
        $condition = ['is_show' => 1];
        if (isset($this->params['keyword'])) {
            $condition['name'] = ['like', "%{$this->params['keyword']}%"];
        }
        if (isset($this->params['live_status'])) {
            $condition['live_status'] = $this->params['live_status'];
        }
        if (isset($this->params['is_top'])) {
            $condition['is_top'] = $this->params['is_top'];
        }
        if (isset($this->params['is_recommend'])) {
            $condition['is_recommend'] = $this->params['is_recommend'];
        }
        $room_list = $this->service->roomList($page_index, $page_size, $condition, 'live_status ASC, is_top DESC, is_recommend  DESC, room_id DESC');
        return $this->outMessage($title, $room_list);
    }

    public function roomInfo() {
        $title = '获取直播间详情';
        $room_id = $this->params['room_id'];
        if (empty($room_id)) {
            return $this->outMessage($title, '', -1, '直播间不存在！');
        }
        $room_info = $this->service->roomInfo(['room_id' => $room_id]);
        return $this->outMessage($title, $room_info);
    }

    public function modifyRoomStatus() {
        $title = '直播间状态修改';
        $id = $this->params['id'];
        $room_id = $this->params['room_id'];
        $live_status = $this->params['live_status'];
        if (!in_array($live_status, array_keys($this->service->live_status_maps))) {
            return $this->outMessage($title, '', -1, '非法操作！');
        }
        $condition = [
            'id' => $id,
            'room_id' => $room_id,
        ];
        $edit_data = [
            'live_status' => $live_status
        ];
        $re = $this->service->modifyRoom($edit_data, $condition);
        return $this->outMessage($title, $re);
    }
}