<?php
namespace addons\NsWxappLive\admin\controller;

use addons\NsWxappLive\Config;
use app\admin\controller\BaseController;
use addons\NsWxappLive\data\service\User as UserService;
use data\service\Config as WebConfig;

class User extends  BaseController {
    public $addon_view_path;
    public $service;

    public function __construct() {
        parent::__construct();
        $this->addon_view_path = ADDON_DIR . '/NsWxappLive/template/';
        $this->service = new UserService();
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
    }

    public function index() {
        if ($this->request->isAjax()) {
            $page_index = $this->request->post('page_index', 1);
            $page_size = $this->request->post('page_size', PAGESIZE);
            $condition = [];
            $status = $this->request->post('status', 'all');
            if ($status != 'all') {
                $condition['status'] = $status;
            }
            $keyword = $this->request->post('keyword', '');
            if (!empty($keyword)) {
                $condition['true_name|identity_card|mobile|wechat_id'] = ['like', "%{$keyword}%"];
            }
            $list = $this->service->userList($page_index, $page_size, $condition, "create_time desc");
            return $list;
        }
        return view($this->addon_view_path . $this->style . 'User/index.html');
    }

    public function show() {
        $id = $this->request->get('id/d');
        $user_info = $this->service->getUserInfo(['id' => $id]);
        $this->assign('data', $user_info);
        // 会员默认头像
        $config = new WebConfig();
        $defaultImages = $config->getDefaultImages($this->instance_id);
        $this->assign("default_headimg", $defaultImages["value"]["default_headimg"]);//默认用户头像
        return view($this->addon_view_path . $this->style . 'User/show.html');
    }

    public function modifyUserStatus() {
        $id = $this->request->post('id/d');
        $status = $this->request->post('status/d');
        $refuse_reason = $this->request->post('refuse_reason/s');
        $condition = ['id' => $id];
        $edit_data = ['status' => $status];
        if (!empty($refuse_reason)) {
            $edit_data['refuse_reason'] = $refuse_reason;
        }
        $re = $this->service->modifyUser($edit_data, $condition);
        return AjaxReturn($re);
    }
}
