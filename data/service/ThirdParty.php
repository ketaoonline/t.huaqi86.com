<?php
/**
 * ThirdParty.php 第三方服务
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
 * @date : 2015.4.24
 * @version : v1.0.0.0
 */

namespace data\service;

use data\model\UserModel;

class ThirdParty extends BaseService
{
	protected $auth_key = 'addexdfsdfewfscvsrdf!@#';
	
	// 服务提供商
	private $provider = [
		// 授权
		'oauth' => [
			'weixin' => [
				'provider' => 'weixin',
				'name' => '微信小程序',
				'field' => 'wx_applet_openid'
			],
			'weixinPublic' => [
				'provider' => 'weixinPublic',
				'name' => '微信公众号',
				'field' => 'wx_openid'
			]
		],
		'payment' => [
			'wxpay' => [
				'provider' => 'wxpay',
				'name' => '微信小程序',
				'field' => 'wx_applet_openid'
			],
			'wxPublic' => [
				'provider' => 'wxPublic',
				'name' => '微信公众号',
				'field' => 'wx_openid'
			]
		]
	];
	
	/**
	 * 获取到授权之后
	 * @param unknown $params
	 * @return Ambigous <multitype:unknown , multitype:unknown string >
	 */
	public function authAfter($params)
	{
		$data = [
			"{$this->provider['oauth'][$params['provider']]['field']}" => $params['openid']
		];
		
		if (!empty($params['unionid'])) $data['wx_unionid'] = $params['unionid'];
		
		$member = new Member();
		$sys_user = new UserModel();
		// 绑定账号
		if ($params['mode'] == 'quick') {
			
			//一键手机号快捷登录
			$retval = $member->login($params['account'], '');
			//手机号不存在进行注册
			if ($retval == USER_ERROR) {
				// 手机号注册
				$retval = $member->registerMember('', $params['password'], '', $params['account'], '', '', '', '', '');
			}
			
		} else if ($params['mode'] == 'account') {
			
			//检测账号是否存在
			$retval = $member->login($params['account'], $params['password']);
			
			if ($retval == USER_ERROR) {
				
				if ($params['flag'] == 'register') {
					// 账号注册
					$retval = $member->registerMember($params['account'], $params['password'], '', '', '', '', '', '', '');
				}
			}
			
		} else if ($params['mode'] == 'mobile') {
			
			//检测手机号是否存在
			$retval = $member->login($params['account'], '');
			if ($retval == USER_ERROR) {
				
				if ($params['flag'] == 'register') {
					// 手机号注册
					$retval = $member->registerMember('', $params['password'], '', $params['account'], '', '', '', '', '');
				}
			}
		}
		
		if ($retval > 0) {
			$user_info = $sys_user->getInfo([ 'uid' => $retval ], 'nick_name,user_headimg');
			if (empty($user_info['nick_name']) || $params['mode'] == 'perfect') $data['nick_name'] = $params['nickname'];
			if (empty($user_info['user_headimg']) || $params['mode'] == 'perfect') $data['user_headimg'] = $params['avatar'];
			
			//清除之前的openid
			$sys_user_before = new UserModel();
			$sys_user_before->save([ "{$this->provider['oauth'][$params['provider']]['field']}" => '' ], [ "{$this->provider['oauth'][$params['provider']]['field']}" => $params['openid'] ]);
			
			$sys_user->save($data, [ 'uid' => $retval ]);
			
			$token = array(
				'uid' => $retval,
				'request_time' => time()
			);
			$encode = $this->niuEncrypt(json_encode($token));
			
			$url = str_replace('api.php', 'index.php', __URL(__URL__ . 'wap/login/pullOutUserImg?uid=' . $retval));
			http($url, 1);
			
			$data = [ 'code' => 0, 'token' => $encode ];
		} else {
			$data = AjaxReturn($retval);
		}
		return $data;
	}
	
	/**
	 * 获取到授权之后
	 * @param unknown $params
	 * @return Ambigous <multitype:unknown , multitype:unknown string >
	 */
	public function authAfterRegister($params)
	{
		$data = [
			"{$this->provider['oauth'][$params['provider']]['field']}" => $params['openid']
		];
		
		if (!empty($params['unionid'])) $data['wx_unionid'] = $params['unionid'];
		
		$member = new Member();
		$sys_user = new UserModel();
		
		if ($params['mode'] == 'quick') {
			
			//一键手机号快捷登录
			$retval = $member->login($params['account'], '');
			//手机号不存在进行注册
			if ($retval == USER_ERROR) {
				// 手机号注册
				$retval = $member->registerMember('', $params['password'], '', $params['account'], '', '', '', '', '');
			}
			
		} else if ($params['mode'] == 'account') {
			
			//检测账号是否存在
			$retval = $member->login($params['account'], $params['password']);
			if ($retval == USER_ERROR) {
				// 账号注册
				$retval = $member->registerMember($params['account'], $params['password'], '', '', '', '', '', '', '');
			}
			
		} else if ($params['mode'] == 'mobile') {
			
			//检测手机号是否存在
			$retval = $member->login($params['account'], '');
			if ($retval == USER_ERROR) {
				// 手机号注册
				$retval = $member->registerMember('', $params['password'], '', $params['account'], '', '', '', '', '');
			}
		}
		
		if ($retval > 0) {
			$user_info = $sys_user->getInfo([ 'uid' => $retval ], 'nick_name,user_headimg');
			if (empty($user_info['nick_name']) || $params['mode'] == 'perfect') $data['nick_name'] = $params['nickname'];
			if (empty($user_info['user_headimg']) || $params['mode'] == 'perfect') $data['user_headimg'] = $params['avatar'];
			
			$sys_user->save($data, [ 'uid' => $retval ]);
			
			$token = array(
				'uid' => $retval,
				'request_time' => time()
			);
			$encode = $this->niuEncrypt(json_encode($token));
			
			$data = [ 'code' => 0, 'token' => $encode ];
		} else {
			$data = AjaxReturn($retval);
		}
		return $data;
	}
	
	/**
	 * 支付时获取用户openid
	 * @param unknown $provider 服务提供商
	 * @param unknown $uid 用户id
	 */
	public function getOpenid($provider, $uid)
	{
		$sys_user = new UserModel();
		$field = $this->provider['payment'][ $provider ]['field'];
		$info = $sys_user->getInfo([ 'uid' => $uid ], $field);
		$openid = '';
		if (!empty($info)) {
			$openid = $info[ $field ];
		}
		return $openid;
	}
	
	/**
	 * 检测openid是否存在
	 * @param unknown $type 服务类型
	 * @param unknown $provider 服务提供商
	 * @param unknown $openid 服务商平台用户标识
	 * @param string $unionid 微信开放平台unionid
	 */
	public function checkOpenidIsExits($type, $provider, $openid, $unionid = '')
	{
		$sys_user = new UserModel();
		$condition = [
			"{$this->provider[$type][$provider]['field']}" => $openid
		];
		
		$info = $sys_user->getInfo($condition, 'uid');
		if (empty($info) && !empty($unionid)) {
			$condition = [
				"wx_unionid" => $unionid
			];
			$info = $sys_user->getInfo($condition, 'uid');
			if (!empty($info)) {
				$sys_user->save([
					"{$this->provider[$type][$provider]['field']}" => $openid
				], $condition);
			}
		}
		
		if (!empty($info['uid'])) {
			$token = array(
				'uid' => $info['uid'],
				'request_time' => time()
			);
			$encode = $this->niuEncrypt(json_encode($token));
			$data = [
				'is_bound' => 1,
				'token' => $encode
			];
		} else {
			$data = [ 'is_bound' => 0 ];
		}
		return $data;
	}
	
	/**
	 * 根据openid查询手机号
	 * @param $provider
	 * @param $openid
	 * @return array|false|null|\PDOStatement|string|\think\Model
	 */
	public function getMobileByOpenId($provider, $openid)
	{
		$member = new Member();
		$res = $member->getMobileByOpenId([ "{$this->provider['oauth'][$provider]['field']}" => $openid ]);
		if (!empty($res)) {
			return [ 'mobile' => $res['user_tel'] ];
		}
		return null;
	}
	
	/**
	 * 系统加密方法
	 *
	 * @param string $data 要加密的字符串
	 * @param string $key 加密密钥
	 * @param int $expire 过期时间 单位 秒
	 * @return string
	 */
	public function niuEncrypt($data, $key = '', $expire = 0)
	{
		$key = md5(empty($key) ? $this->auth_key : $key);
		$data = base64_encode($data);
		$x = 0;
		$len = strlen($data);
		$l = strlen($key);
		$char = '';
		
		for ($i = 0; $i < $len; $i++) {
			if ($x == $l)
				$x = 0;
			$char .= substr($key, $x, 1);
			$x++;
		}
		
		$str = sprintf('%010d', $expire ? $expire + time() : 0);
		
		for ($i = 0; $i < $len; $i++) {
			$str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1))) % 256);
		}
		return str_replace(array(
			'+',
			'/',
			'='
		), array(
			'-',
			'_',
			''
		), base64_encode($str));
	}
}