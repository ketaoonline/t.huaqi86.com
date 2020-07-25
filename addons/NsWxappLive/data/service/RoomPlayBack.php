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

class RoomPlayBack extends BaseService {
    public $model;
    public function __construct() {
	    parent::__construct();
	    $this->model = new NsWxappLiveRoomPlayBackModel();
    }

    public function roomPlayBackList($page_index, $page_size, $condition = array(), $order) {
        $list = $this->model->pageQuery($page_index, $page_size, $condition, $order, '*');
        return $list;
    }

    public function addPlayBacks($id, $play_backs) {
        if (!empty($play_backs)) {
            $this->model->where(['room_id' => $id])->delete();
            $room_update_data = ['has_play_backs' => 1];
            $room_update_data['play_back_expire'] = strtotime($play_backs[0]['expire_time']);
            foreach ($play_backs as $play_back) {
                $add_data[] = [
                    'room_id' => $id,
                    'expire_time' => strtotime($play_back['expire_time']),
                    'create_time' => strtotime($play_back['create_time']),
                    'media_url' => $play_back['media_url'],
                ];
            }
            $this->model->saveAll($add_data);
            $room_model = new NsWxappLiveRoomModel();
            $room_model->save($room_update_data, ['id' => $id]);
        }
        return 1;
    }

    public function syncRoomPlayBack($room_id, $start = 0, $limit = 10) {
        $wechat =  new WchatOauth();
        $replays = $wechat->getAppletLiveRoomPlayBack($room_id, $start, $limit);
        return $replays;
    }
}