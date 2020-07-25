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

namespace addons\NswxappLive\data\service;

use data\model\UserModel;
use data\service\BaseService;
use addons\NsWxappLive\data\model\NsWxappLiveUserModel;

class User extends BaseService {
    protected $model;

    public function __construct() {
        parent::__construct();
        $this->model = new NsWxappLiveUserModel();
    }

    public function addUser($add_data) {
        $this->model->save($add_data);
        return $this->model->id;
    }

    public function editUser($id, $edit_data) {
        $re = $this->model->where(['id' => $id])->save($edit_data);
        return $re;
    }

    public function userList($page_index, $page_size, $condition = array(), $order) {
        $list = $this->model->pageQuery($page_index, $page_size, $condition, $order, '*');
        return $list;
    }

    public function getUserInfo($data) {
        $user_info = $this->model->getInfo($data);
        if (!is_null($user_info)) {
            $sys_user = new UserModel();
            $user_info['user'] = $sys_user->getInfo(['uid' => $user_info['uid']]);
        }
        return $user_info;
    }

    public function modifyUser($modify_data, $condition) {
        $re = $this->model->save($modify_data, $condition);
        return $re;
    }
}