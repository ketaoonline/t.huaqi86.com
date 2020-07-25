<?php
// +----------------------------------------------------------------------
// | test [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.zzstudio.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Byron Sampson <xiaobo.sun@gzzstudio.net>
// +----------------------------------------------------------------------
namespace addons\NsCustomForm;

use addons\BaseConfig;
class Config extends BaseConfig
{
    /**
     * 菜单设置
     */
    public function menu(){
        $menu = [
            [
                'module_name' => '自定义表单',
                'controller' => 'Config',
                'method' => 'orderCustom',
                'parent' => [ 'module' => 'admin', 'controller' => 'config', 'method' => 'diyview', 'level' => 1 ],
                'url' => 'Config/orderCustom',
                'is_menu' => 0,
                'is_dev' => 0,
                'sort' => 2,
                'desc' => '订单自定义表单',
                'module_picture' => '',
                'icon_class' => '',
                'is_control_auth' => 1,
            ],
        	[
        		'module_name' => '添加表单字段',
        		'controller' => 'Config',
        		'method' => 'customDataList',
        		'parent' => [ 'module' => 'admin', 'controller' => 'config', 'method' => 'diyview', 'level' => 1 ],
        		'url' => 'Config/orderCustom',
        		'is_menu' => 0,
        		'is_dev' => 0,
        		'sort' => 2,
        		'desc' => '添加表单字段',
        		'module _picture' => '',
        		'icon_class' => '',
        		'is_control_auth' => 1,
        	]
        ];
        return $menu;
    }
}