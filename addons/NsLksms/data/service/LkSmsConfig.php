<?php
/**
 * AlipayConfig.php
 *
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
namespace addons\NsLksms\data\service;

use data\service\BaseService;
use data\model\ConfigModel;
use think\Cache;
use addons\NsLksms\data\extend\linksms\LinkSms;

/**
 * 凌凯短信配置
 */
class LkSmsConfig extends BaseService
{
    /**
     * 获取凌凯短信接口
     * @param unknown $instanceid
     * @return mixed
     */
    public function getLkSmsConfig($instanceid)
    {
        $cache = Cache::get("getLkSmsConfig" . $instanceid);
        if (empty($cache)) {
            $config_module = new ConfigModel();
            $info = $config_module->getInfo([
                'key' => 'LKSMSCONFIG',
                'instance_id' => $instanceid
            ], 'value, is_use');
            
            if (empty($info) || empty($info['value'])) {
                $data = array(
                    'value' => array(
                        'appKey' => '',
                        'secretKey' => '',
                        'freeSignName' => ''
                    ),
                    'is_use' => 0
                );
            } else {
                $info['value'] = json_decode($info['value'], true);
                $data = $info;
            }
            Cache::set("getLkSmsConfig" . $instanceid, $data);
            return $data;
        } else {
            return $cache;
        }
    }
    
    /**
     * 设置凌凯短信接口
     * @param unknown $instanceid
     * @param unknown $app_key
     * @param unknown $secret_key
     * @param unknown $free_sign_name
     * @param unknown $is_use
     * @return boolean
     */
    public function setLkSmsConfig($instanceid, $app_key, $secret_key, $free_sign_name, $is_use)
    {
        Cache::set("getLkSmsConfig" . $instanceid, null);
        
        $config_module = new ConfigModel();
        $info = $config_module->getInfo([
            'key' => 'LKSMSCONFIG',
            'instance_id' => $instanceid
        ], 'value');
        
        $data = array(
            'instance_id' => $instanceid,
            'key' => 'LKSMSCONFIG',
            'value' => json_encode([
                'appKey' => trim($app_key),
                'secretKey' => trim($secret_key),
                'freeSignName' => trim($free_sign_name)
            ]),
            'is_use' => $is_use,
            'desc' => '凌凯短信配置'
        );
        
        if (empty($info)) {
            $data['create_time'] = time();
            $res = $config_module->save($data);
        } else {
            $data['modify_time'] = time();
            $res = $config_module->save($data, [
                'instance_id' => $instanceid,
                'key' => 'LKSMSCONFIG'
            ]);
        }
        if ($is_use) hook('closeSms', ['name' => 'NsLksms']);
        return $res;
    }
    
    /**
     * 发送短信
     * @param unknown $corpId
     * @param unknown $password
     * @param unknown $signature
     * @param unknown $account
     * @param unknown $sms_params
     * @param unknown $content
     */
    public function smsSend($corpId, $password, $signature, $account, $sms_params, $content){
        $lk_sms = new LinkSms();
        $lk_sms->setCorpID($corpId);
        $lk_sms->setPassword($password);
        $lk_sms->setSignature($signature);
        $lk_sms->setMobile($account);
        $res = $this->setSmsContent($content, $sms_params, $lk_sms);
        if (isset($res['code']) && $res['code'] < 0) return $res;
        $res = $lk_sms->send();
        return $res;
    }
    
    /**
     * 设置短信发送内容
     * @param unknown $sms_params
     * @param unknown $sms
     */
    private function setSmsContent($content, $sms_params, $sms){
        if (empty($content)) return ['code' => -1, 'message' => '短信通知内容未设置'];
        if (!empty($sms_params)) {
            $sms_params_arr = json_decode($sms_params, true);
            foreach ($sms_params_arr as $key => $value) {
                $content = str_replace('{'.$key.'}', $value, $content);
            }
        }
        $sms->setContent($content);
    }
    
}