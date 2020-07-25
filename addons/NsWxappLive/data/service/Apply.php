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

use addons\NsWxappLive\data\model\NsWxappLiveApplyModel;
use data\model\NsGoodsModel;
use data\service\BaseService;

class Apply extends BaseService {
    protected $model;
    protected $goods_categories;
    public $status_maps = [
        1 => '申请中',
        2 => '申请通过',
        3 => '申请拒绝',
    ];

	function __construct() {
		parent::__construct();
		$this->model = new NsWxappLiveApplyModel();
	}

    public function addApply($add_data) {
        $this->model->save($add_data);
        return $this->model->id;
    }

    public function editApply($id, $edit_data) {
        $re = $this->model->where(['id' => $id])->save($edit_data);
        return $re;
    }

	public function applyList($page_index, $page_size, $condition = array(), $order) {
        $apply_list = $this->model->pageQuery($page_index, $page_size, $condition, $order, '*');
        return $apply_list;
    }

    public function getApplyInfo($data) {
	    $apply_info = $this->model->getInfo($data);
	    $goods_modei = new NsGoodsModel();
	    $goods_ids = explode(',', $apply_info['goods_ids']);
	    $apply_info['goog_list'] = $goods_modei->where(['goods_id' => ['IN', $goods_ids]])->select();
	    return $apply_info;
    }

    public function modifyApply($modify_data, $condition) {
        $re = $this->model->save($modify_data, $condition);
        return $re;
    }
}