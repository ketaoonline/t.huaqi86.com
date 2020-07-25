<?php
/**
 * WchatApplet.php
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

namespace app\api\controller;

use data\service\Config as ConfigService;
use data\extend\WchatOauth;
use \addons\NsWeixinpay\data\service\WeiXinPay;

class WchatPublic
{
    public $params;//外界获取参数
    
    public $api_result;
    
    public function  __construct(){
        $this->params = input();
        $this->api_result = new ApiResult();
    }
    
    /**
     * 获取微信公众号授权code
     */
    public function getCode(){
        $title = '获取微信公众号授权code';
        
        $config = new ConfigService();
        $auth_info = $config->getInstanceWchatConfig(0);
        $redirect_uri = $this->get('redirect_uri', '');
        $state = $this->get('state', '');
        
        if (empty($auth_info['value']['appid'])) return $this->outMessage($title, ['code' => -1, 'message' =>'系统未配置公众号']);
        if (empty($redirect_uri)) return $this->outMessage($title, ['code' => -1, 'message' =>'缺少必要参数redirect_uri']);
        
        $redirect_uri = urlencode($redirect_uri);
        
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$auth_info['value']['appid']}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_base&state={$state}#wechat_redirect";
        
        return $this->outMessage($title, ['code' => 0, 'url' => $url]);
    }
    
    /**
     * 获取openid
     */
    public function getOpenid(){
        $title = '获取微信公众号openid';
        $code = $this->get('code', '');
        
        if (empty($code)) return $this->outMessage($title, ['code' => -1, 'message' =>'缺少必要参数code']);
        
        $wechat = new WeiXinPay();
        $res = $wechat->get_access_token($code);
        return $this->outMessage($title, $res);
    }
    
    /**
     *  获取jssdk配置
     */    
    public function getJsApiConfig(){
        $title = '获取微信公众号jssdk配置';
         
        $config = new ConfigService();
        $wexin_auth = new WchatOauth();
        $auth_info = $config->getInstanceWchatConfig(0);
         
        if (!empty($auth_info['value']['appid'])) {
            $data = [
                'appId' => $auth_info['value']['appid'],
                'timestamp' => time(),
                'nonceStr' => $wexin_auth->get_nonce_str(),
                'ticket' => $wexin_auth->jsapi_ticket()
            ];
            $url = $this->get('url', '');
            $parameters = "jsapi_ticket=" . $data['ticket'] . "&noncestr=" . $data['nonceStr'] . "&timestamp=" . $data['timestamp'] . "&url=" . $url;
            $data['signature'] = sha1($parameters);
            return $this->outMessage($title, $data);
        } else {
            return $this->outMessage($title, [], '-9001', "当前系统为配置公众号!");
        }
    }
    
    /**
     * 获取微信公众号用户基础信息
     */
    public function getOauthMemberInfo(){
        $title = '获取微信公众号用户基础信息';
        
        $access_token = $this->get('access_token', '');
        $openid = $this->get('openid', '');
        
        if (empty($access_token)) return $this->outMessage($title, ['code' => -1, 'message' =>'缺少必要参数access_token']);
        if (empty($openid)) return $this->outMessage($title, ['code' => -1, 'message' =>'缺少必要参数openid']);
        
        $token = [
            'access_token' => $access_token,
            'openid' => $openid
        ];
        
        $wechat = new WchatOauth();
        $res = $wechat->get_oauth_member_info($token);
        $data = [];       
        if (is_json($res)) $data = json_decode($res, true);
        
        return $this->outMessage($title, $data);
    }
    
    /**
     * 返回信息
     * @param $title
     * @param $data
     * @param int $code
     * @param string $message
     * @return string
     */
    protected function outMessage($title, $data, $code = 0, $message = "success")
    {
        $this->api_result->code = $code;
        $this->api_result->data = $data;
        $this->api_result->message = $message;
        $this->api_result->title = $title;
    
        if ($this->api_result) {
            return json_encode($this->api_result, JSON_UNESCAPED_UNICODE);
        } else {
            abort(404);
        }
    }
    
    /**
     * 获取API接受参数
     * @param $key
     * @param string $default_value
     * @return string
     */
    public function get($key, $default_value = "")
    {
        $value = isset($this->params[ $key ]) ? $this->params[ $key ] : $default_value;
        return $value;
    }
}

class ApiResult
{

    public $code;

    public $message;

    public $data;

    public $title;

    public function __construct()
    {
        $this->code = 0;
        $this->title = '';
        $this->message = "success";
        $this->data = null;
    }
}