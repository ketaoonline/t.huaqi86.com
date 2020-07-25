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
namespace addons\NsDiyView\wap\controller;

use app\wap\controller\BaseWap;
use addons\NsDiyView\data\service\Config;

/**
 * 网站设置模块控制器
 */
class Diy extends BaseWap
{
    
	public $addon_view_path;
	
	public function __construct()
	{
		parent::__construct();
		$this->addon_view_path = ADDON_DIR . '/NsDiyView/template/';
	}
    
	/**
	 * 自定义模板
	 * @param unknown $params
	 */
	public function diyView($params = []){
	    $config = new Config();
	    $is_enable = $config->getIsEnableWapCustomTemplate($this->instance_id); // 0 不启用 1 启用
	    if (!$is_enable) return;
	    $id = isset($params['id']) ? $params['id'] : 0;
	   
	    if($id > 0){
	    	$template_info = $config->getWapCustomTemplateInfo(['id' => $id, 'type' => 1]);
	    }else{
	    	$template_info = $config->getWapCustomTemplateInfo(['template_type' => $params['template_type'], 'is_default' => 1, 'type' => 1]);	    	
	    }
	    if (empty($template_info)) return;
	    $view_replace_str = [
	        'WAP_CSS' => __ROOT__ . '/template/wap/' . $this->use_wap_template['value'] . '/public/css',
	        'WAP_FONT' => __ROOT__ . '/template/wap/' . $this->use_wap_template['value'] . '/public/font',
	        'WAP_JS' => __ROOT__ . '/template/wap/' . $this->use_wap_template['value'] . '/public/js',
	        'WAP_IMG' => __ROOT__ . '/template/wap/' . $this->use_wap_template['value'] . '/public/img',
	        'WAP_PLUGIN' => __ROOT__ . '/template/wap/' . $this->use_wap_template['value'] . '/public/plugin',
	        'WAP_ADDON_CSS' => __ROOT__ . '/' . $this->addon_view_path . 'wap/public/css',
	        'WAP_ADDON_JS' => __ROOT__ . '/' . $this->addon_view_path . 'wap/public/js',
	        'WAP_ADDON_IMG' => __ROOT__ . '/' . $this->addon_view_path . 'wap/public/images',
	    ];
	    $this->assign('custom_template', $template_info);	    
        return $this->fetch($this->addon_view_path . 'wap/Diy/index.html', [], $view_replace_str); 
	}
}