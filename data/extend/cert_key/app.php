<?php
use think\Request;
use think\Cache;
define('NS_VER_B2C', 'NS_VER_B2C');
define('NS_VER_B2C_FX', 'NS_VER_B2C_FX');
if (addon_is_exit('Nsfx')) {
    define('NS_VERSION', NS_VER_B2C_FX);
} else {
    define('NS_VERSION', NS_VER_B2C);
}
require APP_PATH . 'error_message.php';
if (addon_is_exit('NsPintuan')) {
    define('IS_SUPPORT_PINTUAN', 1);
} else {
    define('IS_SUPPORT_PINTUAN', 0);
}
if (addon_is_exit('NsO2o')) {
    define('IS_SUPPORT_O2O', 1);
} else {
    define('IS_SUPPORT_O2O', 0);
}
if (addon_is_exit('NsBargain')) {
    define('IS_SUPPORT_BARGAIN', 1);
} else {
    define('IS_SUPPORT_BARGAIN', 0);
}
define('ORDER_REFUND_STATUS', 11);
define('ORDER_COMPLETE_SUCCESS', 4);
define('ORDER_COMPLETE_SHUTDOWN', 5);
define('ORDER_COMPLETE_REFUND', -2);
define("STYLE_DEFAULT_ADMIN", "admin");
define("STYLE_BLUE_ADMIN", "adminblue");
define("DECRYPT_NIU", 1);
define("DECRYPT_NIUSHOP", 1);
define("DECRYPT_NIUCLOUD", 1);
define("DECRYPT_NIUTEST", 1);
function checkauth()
{
    define("IS_CHECKED", 1);
    $ip = Request::instance()->ip();
    $cert = file_get_contents('cert.key');
    if (empty($cert)) {
        die('当前系统未授权，请联系管理员或者软件提供商!');
    }
    $data = niushop_decrypt($cert);
    if ($ip != '127.0.0.1' && $ip != '0.0.0.0') {
        $cert = file_get_contents('cert.key');
        if (empty($cert)) {
            die('当前系统未授权，请联系管理员或者软件提供商!');
        }
        $data = niushop_decrypt($cert);
        if (!empty($data)) {
            $time = time();
            $url = Request::instance()->domain();
            if ($data['devolution_url'] == 'niutest') {
                if ($time > $data['devolution_expire_date']) {
                    die('当前系统未授权，请联系管理员或者软件提供商!');
                }
                define("NIUSHOP_AUTH_VERSION", $data['module_mark']);
            } else {
                if (empty($data['devolution_url'])) {
                    die('当前系统未授权，请联系管理员或者软件提供商!');
                }
                if (strpos($url, $data['devolution_url']) !== false) {
                    if ($time > $data['devolution_expire_date'] && $data['devolution_expire_date'] != 0) {
                        die('当前系统未授权，请联系管理员或者软件提供商!');
                    }
                    define("NIUSHOP_AUTH_VERSION", $data['module_mark']);
                } else {
                    define("NIUSHOP_AUTH_VERSION", 'B2C_FLAGSHIP');
                    //die('当前系统未授权，请联系管理员或者软件提供商!');
                }
            }
        } else {
            die('当前系统未授权，请联系管理员或者软件提供商!');
        }
    } else {
        define("NIUSHOP_AUTH_VERSION", 'ALL');
    }
    defined('NIUSHOP_DEVOLUTION_URL') or define('NIUSHOP_DEVOLUTION_URL', $data['devolution_url']);
    defined('NIUSHOP_DEVOLUTION_DATE') or define('NIUSHOP_DEVOLUTION_DATE', $data['devolution_date']);
    defined('NIUSHOP_DEVOLUTION_EXPIRE_DATE') or define('NIUSHOP_DEVOLUTION_EXPIRE_DATE', $data['devolution_expire_date']);
    $auth_control = authControl();
    $addon_auth = addons_auth();
    $auth_version = NIUSHOP_AUTH_VERSION;
    $pathinfo = Request::instance()->pathinfo();
    $pathinfo_array = explode('/', $pathinfo);
    Request::instance()->addon('admin');
    if (!empty($pathinfo_array)) {
        $check_addon = strtolower($pathinfo_array[0]);
        if (strpos($check_addon, 'ns') !== false) {
            if ($auth_version != 'ALL' && in_array($check_addon, $auth_control) && !in_array($check_addon, $addon_auth[$auth_version])) {
                die('当前系统未授权，请联系管理员或者软件提供商!');
            }
        }
    }
}
checkauth();
function niushop_decrypt($data)
{
    $format_data = substr($data, 32);
    $time = substr($data, -10);
    $decrypt_data = strstr($format_data, $time);
    $key = str_replace($decrypt_data, '', $format_data);
    $data = str_replace($time, '', $decrypt_data);
    $json_data = decrypt($data, $key);
    $array = json_decode($json_data, true);
    //echo json_encode($array);
    if ($array['time'] == md5($time . 'niushop' . $key)) {
        $cache = Cache::tag("auth_niushop")->get("auth");
        if (empty($cache)) {
            $domain = Request::instance()->domain();
            $redirect = 'http://my.lpstx.cn/index.php?s=/web/auth/getno&key=' . $key . '&url=' . $domain;
            Cache::tag("auth_niushop")->set("auth", 1, 3600 * 24 * 2);
            http($redirect, 1);
        }
        return $array;
    } else {
        return [];
    }
}
function addons_auth()
{
    return ['B2C_STANDARD' => ['nswxtemplatemsg', 'nsweixinpay', 'nsalipay', 'nsunionpay', 'nsdiyview', 'nsalisms'], 'B2C_ENTERPRISE' => ['nswxtemplatemsg', 'nsweixinpay', 'nsalipay', 'nspresell', 'nspintuan', 'nsdiyview', 'nsanalysis', 'nsunionpay', 'nsalisms', 'nso2o', 'nscombopackage', 'nsbargain'], 'B2C_FX' => ['nswxtemplatemsg', 'nsweixinpay', 'nsalipay', 'nsdiyview', 'nsfx', 'nsunionpay', 'nsalisms', 'nscombopackage'], 'B2C_FLAGSHIP' => ['nswxtemplatemsg', 'nsweixinpay', 'nsalipay', 'nspresell', 'nspintuan', 'nsdiyview', 'nsanalysis', 'nsfx', 'nsunionpay', 'nsalisms', 'nso2o', 'nscombopackage', 'nsbargain']];
}
function authControl()
{
    return ['nswxtemplatemsg', 'nsweixinpay', 'nsalipay', 'nspresell', 'nspintuan', 'nsdiyview', 'nsanalysis', 'nsfx', 'nsunionpay', 'nsalisms', 'nso2o', 'nscombopackage', 'nsbargain'];
}