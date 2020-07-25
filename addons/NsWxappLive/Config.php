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
namespace addons\NsWxappLive;

use addons\BaseConfig;

class Config extends BaseConfig
{
    /**
     * 菜单设置
     */
    public function menu()
    {
        $menu = [
            /*[
                'module_name' => '小程序直播',
                'controller' => 'user',
                'method' => 'index',
                'parent' => ['module' => 'admin', 'controller' => 'wchat', 'method' => 'appletProcess', 'level' => 2],
                'url' => 'user/index',
                'is_menu' => 1,
                'is_dev' => 0,
                'sort' => 9,
                'desc' => '小程序直播',
                'module_picture' => '',
                'icon_class' => '',
                'is_control_auth' => 1,
                'child' => [
                    [
                        'module_name' => '主播详情',
                        'controller' => 'user',
                        'method' => 'show',
                        'url' => 'user/show',
                        'is_menu' => 0,
                        'is_dev' => 0,
                        'sort' => 1,
                        'desc' => '主播详情',
                        'module_picture' => '',
                        'icon_class' => '',
                        'is_control_auth' => 1,
                    ]
                ]
            ],
            [
                'module_name' => '小程序直播申请列表',
                'controller' => 'apply',
                'method' => 'index',
                'parent' => ['module' => 'admin', 'controller' => 'wchat', 'method' => 'appletProcess', 'level' => 2],
                'url' => 'apply/index',
                'is_menu' => 1,
                'is_dev' => 0,
                'sort' => 9,
                'desc' => '小程序直播申请列表',
                'module_picture' => '',
                'icon_class' => '',
                'is_control_auth' => 1,
                'child' => [
                    [
                        'module_name' => '直播申请详情',
                        'controller' => 'apply',
                        'method' => 'show',
                        'url' => 'apply/show',
                        'is_menu' => 0,
                        'is_dev' => 0,
                        'sort' => 1,
                        'desc' => '直播申请详情',
                        'module_picture' => '',
                        'icon_class' => '',
                        'is_control_auth' => 1,
                    ]
                ]
            ],*/
            [
                'module_name' => '小程序直播',
                'controller' => 'room',
                'method' => 'index',
                'parent' => ['module' => 'admin', 'controller' => 'wchat', 'method' => 'appletProcess', 'level' => 2],
                'url' => 'room/index',
                'is_menu' => 1,
                'is_dev' => 0,
                'sort' => 9,
                'desc' => '小程序直播',
                'module_picture' => '',
                'icon_class' => '',
                'is_control_auth' => 1,
                'child' => [
                    [
                        'module_name' => '直播间详情',
                        'controller' => 'room',
                        'method' => 'show',
                        'url' => 'room/show',
                        'is_menu' => 0,
                        'is_dev' => 0,
                        'sort' => 1,
                        'desc' => '直播间详情',
                        'module_picture' => '',
                        'icon_class' => '',
                        'is_control_auth' => 1,
                    ],
                    [
                        'module_name' => '直播间回放',
                        'controller' => 'room',
                        'method' => 'playBack',
                        'url' => 'room/playBack',
                        'is_menu' => 0,
                        'is_dev' => 0,
                        'sort' => 1,
                        'desc' => '直播间回放',
                        'module_picture' => '',
                        'icon_class' => '',
                        'is_control_auth' => 1,
                    ]
                ]
            ]
        ];
        return $menu;
    }
}