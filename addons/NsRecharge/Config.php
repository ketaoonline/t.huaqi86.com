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
namespace addons\NsRecharge;

use addons\BaseConfig;

class Config extends BaseConfig
{
    /**
     * 菜单设置
     */
    public function menu(){
        $menu = [
            [
                'module_name' => '充值有礼',
                'controller' => 'config',
                'method' => 'index',
                'parent' => [ 'module' => 'admin', 'controller' => 'promotion', 'method' => 'memberPromotion', 'level' => 2 ],
                'url' => 'config/index',
                'is_menu' => 1,
                'is_dev' => 0,
                'sort' => 1,
                'desc' => '充值有礼',
                'module_picture' => '',
                'icon_class' => '',
                'is_control_auth' => 1,
                'child' => [
                    [
                        'module_name' => '添加充值有礼',
                        'controller' => 'config',
                        'method' => 'addRecharge',
                        'url' => 'config/addRecharge',
                        'is_menu' => 0,
                        'is_dev' => 0,
                        'sort' => 1,
                        'desc' => '添加充值有礼',
                        'module_picture' => '',
                        'icon_class' => '',
                        'is_control_auth' => 1,
                    ],
                    [
                        'module_name' => '编辑充值有礼',
                        'controller' => 'config',
                        'method' => 'editRecharge',
                        'url' => 'config/editRecharge',
                        'is_menu' => 0,
                        'is_dev' => 0,
                        'sort' => 2,
                        'desc' => '编辑充值有礼',
                        'module_picture' => '',
                        'icon_class' => '',
                        'is_control_auth' => 1
                    ]
                ]
            ],
            [
                'module_name' => '充值设置',
                'controller' => 'config',
                'method' => 'recharge',
                'parent' => [ 'module' => 'admin', 'controller' => 'promotion', 'method' => 'memberPromotion', 'level' => 2 ],
                'url' => 'config/recharge',
                'is_menu' => 1,
                'is_dev' => 0,
                'sort' => 2,
                'desc' => '充值设置',
                'module_picture' => '',
                'icon_class' => '',
                'is_control_auth' => 1,
            ]
        ];
        return $menu;
    }
}