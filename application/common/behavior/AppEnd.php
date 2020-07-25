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

use think\Request;
use think\Cache;
/**
 * 应用开始
 */
class AppEnd
{
    // 行为扩展的执行入口必须是run
    public function run()
    {
        //检测入口文件
        $base_file = Request::instance()->baseFile();
        $is_index = strpos($base_file, 'index.php');
        if ($is_index) {
            $this->event();
        }
    }
    /**
     * 执行事件
     */
    private function event()
    {
        $cache = Cache::tag('config')->get('load_task');
        $last_time = cache("last_load_time");
        if(empty($last_time))
        {
            $last_time = 0;
        }
        if (empty($cache)||time()-$last_time > 300) {
            Cache::tag('config')->set('load_task', 1);
            $redirect = __URL(__URL__ . "/wap/task/event");
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_URL, $redirect);
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_exec($ch);
        }
    
    }
}
