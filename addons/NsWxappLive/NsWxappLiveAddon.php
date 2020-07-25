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

use data\service\Config as WebConfig;
use think\Db;

class NsWxappLiveAddon extends \addons\Addons
{

    public $info = array(
        'name' => 'NsWxappLive', // 插件名称标识
        'title' => '小程序直播', // 插件中文名
        'description' => '小程序直播', // 插件概述
        'status' => 1, // 状态 1启用 0禁用
        'author' => 'niushop', // 作者
        'version' => '1.0', // 版本号
        'has_addonslist' => 0, // 是否有下级插件 例如：第三方登录插件下有 qq登录，微信登录
        'content' => '', // 插件的详细介绍或使用方法
        'ico' => 'addons/NsWeixinpay/ico.png'
    );

    /**
     * 插件安装
     * @see \addons\Addons::install()
     */
    public function install()
    {
        $this->executeSql(ADDON_DIR . '/NsWxappLive/data/db/install.sql');
        return true;
    }

    /**
     * 插件卸载
     * @see \addons\Addons::uninstall()
     */
    public function uninstall()
    {
        return true;
    }
}