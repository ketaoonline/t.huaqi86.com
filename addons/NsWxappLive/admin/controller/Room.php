<?php
namespace addons\NsWxappLive\admin\controller;

use addons\NsWxappLive\Config;
use addons\NsWxappLive\data\service\RoomPlayBack as RoomPlayBackService;
use app\admin\controller\BaseController;
use addons\NsWxappLive\data\service\Room as RoomService;

class Room extends  BaseController {
    public $addon_view_path;
    public $page_index = 1;
    public $service;

    public function __construct() {
        parent::__construct();
        $this->service = new RoomService();
        $this->addon_view_path = ADDON_DIR . '/NsWxappLive/template/';
        $config = new Config();
        $menu = $config->menu();
        if (!empty($menu)) {
            $child_menu_list = [];
            foreach($menu as $child) {
                $child_menu_list[] = [
                    'menu_name' => $child['module_name'],
                    'url' => __URL('__URL__/NsWxappLive/' . ADMIN_MODULE . '/' . $child['url']),
                    'active' => strtolower($this->request->controller()) === $child['controller'] ? 1 : 0
                ];
            }
        }
        $this->assign('child_menu_list', $child_menu_list);
        $this->assign('live_status_maps', $this->service->live_status_maps);
    }

    public function index() {
        if ($this->request->isAjax()) {
            $page_index = $this->request->post('page_index', 1);
            $page_size = $this->request->post('page_size', PAGESIZE);
            $condition = [];

            $live_status = $this->request->post('live_status', 'all');
            if ($live_status != 'all') {
                $condition['live_status'] = $live_status;
            }
            $keyword = $this->request->post('keyword', '');
            if (!empty($keyword)) {
                $condition['name'] = ['like', "%{$keyword}%"];
            }
            $list = $this->service->roomList($page_index, $page_size, $condition, 'start_time DESC');
            return $list;
        }
        return view($this->addon_view_path . $this->style . 'Room/index.html');
    }

    public function show() {
        $id = $this->request->get('id');
        $room_info = $this->service->roomInfo(['id' => $id]);
        $this->assign('data', $room_info);
        return view($this->addon_view_path . $this->style . 'Room/show.html');
    }

    public function syncLiveRoom() {
        if ($this->request->isAjax()) {
           $page_index = $this->request->post('page_index', $this->page_index);
           $page_size = $this->request->post('page_size', PAGESIZE);
           $rooms = $this->service->syncLiveRoom($page_index, $page_size);
           if ($rooms['errcode'] < 0) {
               return AjaxReturn($rooms['errcode'], '', $rooms['errmsg']);
           }
           $page_index = $page_index * $page_size + 1;
           $total = $rooms['total'];
           $re = $this->service->addRooms($rooms['room_info']);
           if (empty($re)) {
               return AjaxReturn(0, [], '请稍后再试');
           }
           $data = [
               'page_index' => $page_index,
               'total' => $total
           ];
           return AjaxReturn($re, $data);
        }
    }

    public function modifyRoomStatus() {
        $field = $this->request->post('type/s');
        $id = $this->request->post('id/d');
        $value = $this->request->post('value/d');
        $condition = ['id' => $id];
        if (in_array($field, ['is_top', 'is_recommend', 'is_show'])) {
            $edit_data = [
                $field => $value ? 0 : 1
            ];
            $re = $this->service->modifyRoom($edit_data, $condition);
            return AjaxReturn($re);
        }
    }

    public function playBack() {
        $id = $this->request->get('id/d');
        $room_info = $this->service->roomInfo(['live_status' => 103, 'id' => $id]);
        if (!empty($room_info)) {
            $paly_back_service = new RoomPlayBackService();
            $room_info['play_backs'] = $paly_back_service->roomPlayBackList(1, 0, ['room_id' => $room_info['id']], 'id');
        }
        $this->assign('data', $room_info);
        return view($this->addon_view_path . $this->style . 'Room/playBack.html');
    }

    public function syncLivePlayBack() {
        $page_index = $this->request->post('page_index', $this->page_index);
        $page_size = $this->request->post('page_size', PAGESIZE);
        $id = $this->request->post('id/d');
        if (!empty($room_id)) {
            return AjaxReturn(0, '', '参数错误');
        }
        $room_info = $this->service->roomInfo(['live_status' => 103, 'id' => $id]);
        if (empty($room_info)) {
            return AjaxReturn(0, '', '参数错误');
        }
        $paly_back_service = new RoomPlayBackService();
        $paly_backs = $paly_back_service->syncRoomPlayBack($room_info['room_id'], $page_index);
        if ($paly_backs['errcode'] < 0) {
            return AjaxReturn($paly_backs['errcode'], '', $paly_backs['errmsg']);
        }
        $page_index = $page_index * $page_size + 1;
        $total = $paly_backs['total'];
        $re = $paly_back_service->addPlayBacks($id, $paly_backs['live_replay']);
        if (empty($re)) {
            return AjaxReturn(0, [], '请稍后再试');
        }
        $data = [
            'page_index' => $page_index,
            'total' => $total
        ];
        return AjaxReturn($re, $data);
    }
}
