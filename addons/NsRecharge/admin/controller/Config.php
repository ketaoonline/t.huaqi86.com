<?php
/**
 * Config.php
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
namespace addons\NsRecharge\admin\controller;

use app\admin\controller\BaseController;
use addons\NsRecharge\data\service\Recharge as RechargeService;
use data\service\Config as SysteamConfig;

/**
 * 充值有礼模块控制器
 */
class Config extends BaseController
{
	public $addon_view_path;
	public $replace;	
	
	public function __construct()
	{
		parent::__construct();
		$this->addon_view_path = ADDON_DIR . '/NsRecharge/template/';
		$this->replace = [
            'ADMIN_ADDON_CSS' => __ROOT__ .'/'. $this->addon_view_path . $this->style . 'public/css',
		    'ADMIN_ADDON_JS' => __ROOT__ .'/'. $this->addon_view_path . $this->style . 'public/js'
		];
	}
	
	/**
	 * 充值设置
	 */
	public function index(){
	    if (request()->isAjax()) {
	        $config = new RechargeService();
	        $page_index = request()->post("page_index", 1);
			$page_size = request()->post('page_size', PAGESIZE);
			$search_text = request()->post('search_text', '');
			$status = request()->post('status', '');
			$condition = [];
			if (!empty($search_text)) {
			    $condition['activity_name'] = ['like', '%'.$search_text.'%'];
			}
			$list = $config->getRechargePageList($page_index, $page_size, $condition);
			return $list;
	    }
	    $child_menu_list = array(
	        array(
	            'module' => 'NsRecharge',
	            'url' => "config/index",
	            'menu_name' => "充值有礼",
	            "active" => 1
	        ),
	        array(
	            'module' => 'NsRecharge',
	            'url' => "config/recharge",
	            'menu_name' => "充值设置",
	            "active" => 0
	        )
	    );
	    $this->assign('child_menu_list', $child_menu_list);
        return view($this->addon_view_path.$this->style . "Config/index.html");
	}
	
	/**
	 * 添加充值有礼
	 */
	public function addRecharge(){
        if (request()->isAjax()) {
            $value = request()->post('value', '');
            $data = json_decode($value, true);
            $config = new RechargeService();
            $res = $config->addOrEditRecharge($data);
            return AjaxReturn($res);
        }
	    return view($this->addon_view_path.$this->style . "Config/addOrEditRecharge.html", [], $this->replace);
	}
	
	/**
	 * 编辑充值有礼
	 */
	public function editRecharge(){
	    $config = new RechargeService();
	    if (request()->isAjax()) {
	        $value = request()->post('value', '');
	        $data = json_decode($value, true);
	        $res = $config->addOrEditRecharge($data);
	        return AjaxReturn($res);
	    }
	    $id = request()->get('id', 0);
	    $info = $config->getRechargeDetail(['id' => $id]);
	    if (empty($info)) $this->error('未获取到活动信息');
	    $this->assign('info', $info);	    
	    return view($this->addon_view_path.$this->style . "Config/addOrEditRecharge.html", [], $this->replace);
	}
    
	/**
	 * 删除充值有礼
	 */
	public function deleteRecharge(){
	    if (request()->isAjax()) {
	        $config = new RechargeService();
	        $id = request()->post('id', '');
	        $res = $config->deleteRecharge($id);
	        return AjaxReturn($res);
	    }
	}
	
	/**
	 * 关闭充值有礼
	 */
	public function closeRecharge(){
	    if (request()->isAjax()) {
	        $config = new RechargeService();
	        $id = request()->post('id', '');
	        $res = $config->closeRecharge($id);
	        return AjaxReturn($res);
	    }
	}
	
	/**
	 * 充值设置
	 */
	public function recharge(){
        $config = new SysteamConfig();
	    if (request()->isAjax()) {
	        $value = request()->post('value', '');
	        $res = $config->setConfig([
	            [
                    'instance_id' => $this->instance_id,
	                'key' => 'RECHARGECONFIG',
	                'value' => $value,
	                'desc' => '充值设置',
	                'is_use' => 1
	            ]
	        ]);
	        return AjaxReturn($res);
	    }
	    $info = $config->getConfig($this->instance_id, 'RECHARGECONFIG');
	    $data = [
	        'rechargeMode' => ["fixed_amount","custom_amount"],
	        'fixedAmount' => [20, 30, 50, 150, 300, 500],
	        'customAmount' => 10
	    ];
	    if (!empty($info) && !empty($info['value'])) {
	        $data = json_decode($info['value'], true);
	    }
	    $this->assign('info', $data);
	    return view($this->addon_view_path.$this->style . "Config/recharge.html", [], $this->replace);
	}
}