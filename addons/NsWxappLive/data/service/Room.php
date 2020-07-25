<?php
/**
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

namespace addons\NsWxappLive\data\service;

use addons\NsWxappLive\data\model\NsWxappLiveRoomModel;
use addons\NsWxappLive\data\model\NsWxappLiveRoomPlayBackModel;
use data\service\BaseService;
use data\extend\WchatOauth;
use data\service\Config as WebConfig;

class Room extends BaseService {
    public $model;
    public $live_status_maps = [
        101 => '直播中',
        102 => '未开始',
        103 => '已结束',
        104 => '禁播',
        105 => '暂停中',
        106 => '异常',
        107 => '已过期'
    ];

    public function __construct() {
	    parent::__construct();
	    $this->model = new NsWxappLiveRoomModel();
    }

    public function roomList($page_index, $page_size, $condition = array(), $order) {
        $list = $this->model->pageQuery($page_index, $page_size, $condition, $order, '*');
        if (!empty($list['data'])) {
            foreach ($list['data'] as $key => $v) {
                $goods_list = json_decode($v['goods'], true);
                foreach ($goods_list as &$goods) {
                    $goods['price'] = round($goods['price']/100, 2);
                }
                $list['data'][$key]['goods'] = $goods_list;
                $list['data'][$key]['goods_total'] = count($list['data'][$key]['goods']);
                $list['data'][$key]['status_zh'] = $this->live_status_maps[$v['live_status']];
                $play_back_expire = strtotime($v['play_back_expire']);
                $list['data'][$key]['play_back_expire_zh'] = $play_back_expire > 0 && $play_back_expire > time() ? '回放未过期' : '回放过期';
            }
        }
        return $list;
    }

    public function roomInfo($data) {
        $room_info = $this->model->getInfo($data);
        $goods_list = json_decode($room_info['goods'], true);
        foreach ($goods_list as &$goods) {
            $goods['price'] = round($goods['price']/100, 2);
        }
        $room_info['goods'] = $goods_list;
        if ($room_info['has_play_backs']) {
            $room_palay_back_model = new NsWxappLiveRoomPlayBackModel();
            $room_info['play_backs'] = $room_palay_back_model->where(['room_id' => $room_info['id']])->select();
        }
        return $room_info;
    }

    public function addRooms($rooms) {
	    if (empty($rooms) || !is_array($rooms)) {
	        return 0;
        }
        $config = new Webconfig();
        $defaultImages = $config->getDefaultImages($this->instance_id);
        $default_headimg = $defaultImages["value"]["default_headimg"];
	    foreach ($rooms as $room) {
            $room_model = new NsWxappLiveRoomModel();
	        $is_room_exist = $room_model->getInfo(['room_id' => $room['roomid']]);
            $data = [
                'name' => $room['name'],
                'anchor_name' => $room['anchor_name'],
                'anchor_img' => $room['anchor_img'] ?: __IMG($default_headimg),
                'start_time' => $room['start_time'],
                'end_time' => $room['end_time'],
                'cover_img' => $room['cover_img'],
                'share_img' => $room['share_img'],
                'goods' => json_encode($room['goods']),
                'live_status' => $room['live_status'],
            ];
	        if (is_null($is_room_exist)) {
	            $data['room_id'] = $room['roomid'];
                $room_model->save($data);
            } else {
                $room_model->save($data, ['room_id' => $room['roomid']]);
	        }
        }
	    return 1;
    }

    public function syncLiveRoom($page_index, $page_size) {
	    $wechat =  new WchatOauth();
	    $rooms = $wechat->getAppletLiveRoom($page_index - 1, $page_size);
	    return $rooms;
    }

    public function modifyRoom($modify_data, $condition) {
        $re = $this->model->save($modify_data, $condition);
        return $re;
    }
}