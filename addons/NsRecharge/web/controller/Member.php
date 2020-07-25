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
namespace addons\NsRecharge\web\controller;

use app\web\controller\BaseWeb;

/**
 * 充值有礼模块控制器
 */
class Member extends BaseWeb
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
	
}