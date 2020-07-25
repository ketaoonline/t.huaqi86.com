<?php
namespace app\common\behavior;

use think\Request;
use data\model\SysAddonsModel;
use data\model\SysHooksModel;
use data\model\BaseModel;
use think\App;
use think\Route;
use think\Hook;
use data\service\Extend;
class InitRoute
{
    public function run()
    {
        if (defined('BIND_MODULE') && BIND_MODULE === 'Install') {
            return;
        }
        \think\Loader::addNamespace('addons', 'addons');
        $data = cache('hooks');
        if (!$data) {
            $addons_model = new SysAddonsModel();
            $hooks_model = new SysHooksModel();
            $hooks = $hooks_model->column('addons', 'name');
            foreach ($hooks as $key => $value) {
                if ($value) {
                    $map['status'] = 1;
                    $names = explode(',', $value);
                    $map['name'] = ['IN', $names];
                    $data = $addons_model->where($map)->column('name', 'id');
                    if ($data) {
                        $addons = array_intersect($names, $data);
                        Hook::add($key, array_map('get_addon_class', $addons));
                    }
                }
            }
            cache('hooks', Hook::get());
        } else {
            Hook::import($data, false);
        }
        if (defined('BIND_MODULE') && BIND_MODULE === 'install') {
            return;
        }
        urlRoute();
        $pathinfo = Request::instance()->pathinfo();
        $pathinfo_array = explode('/', $pathinfo);
        define('IS_ROUTE', 1);
        request()->addon('admin');
        if (!empty($pathinfo_array)) {
            $check_addon = strtolower($pathinfo_array[0]);
            if (empty($check_addon)) {
                return;
            }
            $extend = new Extend();
            $addons_array = $extend->getAddons();
            $addons = implode(',', $addons_array);
            $addons = strtolower($addons);
            $addons_array = explode(',', $addons);
            if (in_array($check_addon, $addons_array)) {
                $addon_model = new SysAddonsModel();
                $name = $addon_model->getInfo(['name' => $pathinfo_array[0]], 'name');
                $namespace = 'addons\\' . $name['name'];
                $addon_path = ADDON_PATH . $name['name'] . DS;
                App::$namespace = $namespace;
                request()->addon($namespace);
                $model_path = $pathinfo_array[1];
                $controller_path = isset($pathinfo_array[2]) ? $pathinfo_array[2] : 'index';
                $action_path = isset($pathinfo_array[3]) ? $pathinfo_array[3] : 'index';
                App::$modulePath = $addon_path . ($model_path ? $model_path . DS : '');
                if ($model_path == ADMIN_MODULE) {
                    Route::rule($pathinfo_array[0] . '/' . $model_path . '/:controller/:action', 'admin/:controller/:action', '*', []);
                    Route::rule($pathinfo_array[0] . '/' . $model_path . '/:model/:controller', 'admin/:controller/' . $action_path, '*', []);
                    Route::rule($pathinfo_array[0] . '/' . $model_path, 'admin/' . $controller_path . '/' . $action_path, '*', []);
                }
                Route::rule($pathinfo_array[0] . '/:model/:controller/:action', ':model/:controller/:action', '*', []);
                Route::rule($pathinfo_array[0] . '/:model/:controller', ':model/:controller/' . $action_path, '*', []);
                Route::rule($pathinfo_array[0] . '/:model', ':model/' . $controller_path . '/' . $action_path, '*', []);
                Route::rule($pathinfo_array[0], 'admin/' . $controller_path . '/' . $action_path, '*', []);
            }
        }
    }
}