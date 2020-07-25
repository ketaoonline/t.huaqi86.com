<?php
/**
 * Index.php
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

namespace app\wap\controller;

use data\service\Config;
use think\Cookie;

class Index extends BaseWap
{
	
	/**
	 * 商品标签板块每层显示商品个数
	 */
	public $recommend_goods_num = 4;
	
	/**
	 * 手机端首页
	 */
	public function index()
	{
	    // 获取自定义模板信息
	    $custom_template = arrayFilter(hook('diyview', ['template_type' => 'index']));
	    if (!empty($custom_template[0])) {
	        return $custom_template[0];
	    }
		
		$source_uid = request()->get('source_uid', '');
        if (!empty($source_uid)) {
			$_SESSION['source_uid'] = $source_uid;
		}
		
		return $this->view($this->style . 'index/index');
	}
	
	/**
	 * 调用自定义模板
	 */
	public function diyview()
	{
		// 获取自定义模板信息
		$diy_id = request()->get('id', '');
		
		$custom_template = arrayFilter(hook('diyview', ['id'=>$diy_id]));
		if (!empty($custom_template[0])) {
			return $custom_template[0];
		}
	}
	
	/**
	 * 删除设置页面打开cookie
	 */
	public function deleteClientCookie()
	{
		Cookie::delete("default_client");
		return AjaxReturn(1);
	}
	
	/**
	 * 设置页面打开cookie
	 */
	public function setClientCookie()
	{
		$client = request()->post('client', '');
		Cookie::set("default_client", $client);
		return AjaxReturn(1);
	}
	
	/**
	 * 错误页
	 */
	public function errorTemplate()
	{
		return $this->view($this->style . 'index/error');
	}
	
	/**
	 * 店铺首页
	 */
	public function shopIndex()
	{	
		if(!addon_is_exit('Nsfx')) $this->error('请先安装分销插件');
		$source_uid = input('source_uid', 0);
		$promoter_detail = api('System.Distribution.promoterDetailByUid', [ 'uid' => $source_uid ]);
		$promoter_detail = $promoter_detail['data'];
		if (empty($promoter_detail)) {
		    $redirect = __URL(__URL__ . '/wap/index/index');
		    $this->redirect($redirect);
		}
		$this->assign('source_uid', $source_uid);
		$this->assign('title', $promoter_detail['promoter_shop_name'] . '的店铺');
		$this->assign('promoter_detail', $promoter_detail);
		return $this->view($this->style . 'index/shop_index');
	}
	
	public function test(){
	    $res = arrayFilter(hook('diyview', ['template_type' => 'index']));
	    if (!empty($res[0])) {
	        echo $res[0];
	    }
	}
}