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
namespace addons\NsRecharge\wap\controller;

use app\wap\controller\BaseWap;

/**
 * 充值有礼模块控制器
 */
class Member extends BaseWap
{
	public $addon_view_path;
	public $replace;	
	
	public function __construct()
	{
		parent::__construct();
	    $this->checkLogin();
		$this->addon_view_path = ADDON_DIR . '/NsRecharge/template/';
		$this->replace = [
		    'WAP_CSS' => __ROOT__ . '/template/wap/' . $this->use_wap_template['value'] . '/public/css',
		    'WAP_FONT' => __ROOT__ . '/template/wap/' . $this->use_wap_template['value'] . '/public/font',
		    'WAP_JS' => __ROOT__ . '/template/wap/' . $this->use_wap_template['value'] . '/public/js',
		    'WAP_IMG' => __ROOT__ . '/template/wap/' . $this->use_wap_template['value'] . '/public/img',
		    'WAP_PLUGIN' => __ROOT__ . '/template/wap/' . $this->use_wap_template['value'] . '/public/plugin',
            'WAP_ADDON_CSS' => __ROOT__ .'/'. $this->addon_view_path . $this->style . 'public/css',
		    'WAP_ADDON_JS' => __ROOT__ .'/'. $this->addon_view_path . $this->style . 'public/js'
		];
	}
	
	/**
	 * 充值界面
	 */
	public function recharge(){
	    $this->assign('title', "充值余额");
	    $this->assign('title_before', "充值余额");
	    return $this->fetch($this->addon_view_path.$this->style . 'member/recharge.html', [], $this->replace);
	}
}