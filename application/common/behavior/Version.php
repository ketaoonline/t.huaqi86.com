<?php
// +----------------------------------------------------------------------
// | NiuCloud [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: niuteam <niuteam@163.com>
// +----------------------------------------------------------------------
namespace app\common\behavior;

/**
 * 版本管理
 */
class Version
{
	// 行为扩展的执行入口必须是run
	public function run()
	{
		if (!defined('NIU_VERSION')) {
			define('NIU_VERSION_NO', '3.3.0');
			define('NIU_VERSION', '3.3.0旗舰版');
			define('NIU_VER_DATE', '2020-06-18');
			define('NIU_RELEASE', '20200618001');
            define('NIU_MODULE_MARK', 'B2C_FLAGSHIP');
		}
	}
}