<?php
/**
 * UnionPayConfig.php
 *











 */
namespace addons\NsUnionPay\data\service;

use data\service\BaseService;
use data\model\ConfigModel;
use think\Cache;

/**
 * 银联支付配置
 */
class UnionPayConfig extends BaseService
{
   
    /**
     * 获取银联支付配置信息
     */
    public function getUnionpayConfig($instance_id)
    {
        $cache = Cache::get("getUnionpayConfig" . $instance_id);
        if (empty($cache)) {
            $config_model = new ConfigModel();
            $info = $config_model->getInfo([
                'instance_id' => $instance_id,
                'key' => 'UNIONPAY'
            ], 'value,is_use');
            if (empty($info['value'])) {
                $data = array(
                    'value' => array(
                        'merchant_number' => '',
                        'sign_cert_pwd' => '',
                        'certs_path' => '',
                        'log_path' => '',
                        'service_charge' => ''
                    ),
                    'is_use' => 0
                );
            } else {
                $info['value'] = json_decode($info['value'], true);
                $data = $info;
            }
            Cache::set("getUnionpayConfig" . $instance_id, $data);
            
            return $data;
        } else {
            
            return $cache;
        }
    }

    /**
     * 银联卡支付配置保存
     *
     * @param unknown $unionPayConfig            
     * @param unknown $certificate_key            
     * @param unknown $service_charge            
     * @param unknown $is_use            
     */
    public function setUnionpayConfig($instanceid, $merchant_number, $sign_cert_pwd, $certs_path, $log_path, $service_charge, $is_use)
    {
        Cache::set("getUnionpayConfig" . $instanceid, null);
        
        $data = array(
            'merchant_number' => $merchant_number,
            'sign_cert_pwd' => $sign_cert_pwd,
            'certs_path' => $certs_path,
            'log_path' => $log_path,
            'service_charge' => $service_charge
        );
        $value = json_encode($data);
        $config_model = new ConfigModel();
        $info = $config_model->getInfo([
            'key' => 'UNIONPAY',
            'instance_id' => $instanceid
        ], 'value');
        if (empty($info)) {
            $config_module = new ConfigModel();
            $data = array(
                'instance_id' => $instanceid,
                'key' => 'UNIONPAY',
                'value' => $value,
                'is_use' => $is_use,
                'create_time' => time()
            );
            $res = $config_module->save($data);
        } else {
            $config_module = new ConfigModel();
            $data = array(
                'key' => 'UNIONPAY',
                'value' => $value,
                'is_use' => $is_use,
                'modify_time' => time()
            );
            $res = $config_module->save($data, [
                'instance_id' => $instanceid,
                'key' => 'UNIONPAY'
            ]);
        }
        return $res;
    }
    
    /**
     * 设置原路退款信息
     */
    public function setOriginalRoadRefundSetting($shop_id, $value)
    {
        
        $key = 'ORIGINAL_ROAD_REFUND_SETTING_UNIONPAY';
        $config_model = new ConfigModel();
        $info = $config_model->getInfo([
            'key' => $key,
            'instance_id' => $shop_id
        ], 'value');
    
        if (empty($info)) {
            $config_module = new ConfigModel();
            $data = array(
                'instance_id' => $shop_id,
                'key' => $key,
                'value' => $value,
                'is_use' => 1,
                'create_time' => time()
            );
            $res = $config_module->save($data);
        } else {
            $config_module = new ConfigModel();
            $data = array(
                'key' => $key,
                'value' => $value,
                'is_use' => 1,
                'modify_time' => time()
            );
            $res = $config_module->save($data, [
                'instance_id' => $shop_id,
                'key' => $key
            ]);
        }
        return $res;
    }
    
    /**
     * 获取原路退款信息
     */
    public function getOriginalRoadRefundSetting($shop_id)
    {
        $key = 'ORIGINAL_ROAD_REFUND_SETTING_UNIONPAY';
        $config_model = new ConfigModel();
        $info = $config_model->getInfo([
            'key' => $key,
            'instance_id' => $shop_id
        ], 'value');
        return $info;
    }
}