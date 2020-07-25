<?php
namespace addons\NsWxappLive\admin\controller;

use  app\admin\controller\BaseController;
use addons\NsWxappLive\Config;
use addons\NsWxappLive\data\service\Apply as ApplyService;

class Apply extends  BaseController {
    public $addon_view_path;
    public $service;

    public function __construct() {
        parent::__construct();
        $this->addon_view_path = ADDON_DIR . '/NsWxappLive/template/';
        $this->service = new ApplyService();
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
        $this->assign('status_maps', $this->service->status_maps);
    }

    public function index() {
        if ($this->request->isAjax()) {
            $page_index = $this->request->post('page_index', 1);
            $page_size = $this->request->post('page_size', PAGESIZE);
            $status = $this->request->post('status', 'all');
            $keyword = $this->request->post('keyword', '');
            $condition = [];
            if ($status != 'all') {
                $condition['status'] = $status;
            }
            if (!empty($keyword)) {
                $condition['room_name|room_desc'] = ['like', "%{$keyword}%"];
            }
            $list = $this->service->applyList($page_index, $page_size, $condition, 'create_time desc');
            foreach ($list['data'] as &$item) {
                $item['wechat_id'] = $item->user->wechat_id;
            }
            return $list;
        }

        return view($this->addon_view_path . $this->style . 'Apply/index.html');
    }

    public function show() {
        $id = $this->request->get('id');
        $apply_info = $this->service->getApplyInfo(['id' => $id]);
        $this->assign('data', $apply_info);
        return view($this->addon_view_path . $this->style . 'Apply/show.html');
    }

    public function modifyApplyStatus() {
        $id = $this->request->post('id/d');
        $status = $this->request->post('status/d');
        $refuse_reason = $this->request->post('refuse_reason/s');
        $condition = ['id' => $id];
        $edit_data = ['status' => $status];
        if (!empty($refuse_reason)) {
            $edit_data['refuse_reason'] = $refuse_reason;
        }
        $re = $this->service->modifyApply($edit_data, $condition);
        return AjaxReturn($re);
    }
}
