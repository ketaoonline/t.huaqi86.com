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
namespace addons\NsLksms\admin\controller;

use addons\NsLksms\data\service\LkSmsConfig;
use app\admin\controller\BaseController;

/**
 * 凌凯短信模块控制器
 */
class Config extends BaseController
{
	public $addon_view_path;
	
	public function __construct()
	{
		parent::__construct();
		$this->addon_view_path = ADDON_DIR . '/NsLksms/template/';
	}
    
    /**
     * 短信接口设置
     */
    public function lingkaiConfig()
    {
        if(request()->isAjax())
        {
            $app_key = request()->post('app_key', '');
            $secret_key = request()->post('secret_key', '');
            $free_sign_name = request()->post('free_sign_name', '');
            $is_use = request()->post('is_use', '');
            $mobile = request()->post("mobile", '');
            $config = new LkSmsConfig();  
            $res = $config->setLkSmsConfig($this->instance_id, $app_key, $secret_key, $free_sign_name, $is_use);
            return AjaxReturn($res);
        }
        $config = new LkSmsConfig();
        $mobile_message = $config->getLkSmsConfig($this->instance_id);
        $this->assign('mobile_message', $mobile_message);
        return view($this->addon_view_path.$this->style . "Config/messageConfig.html");
    }

}