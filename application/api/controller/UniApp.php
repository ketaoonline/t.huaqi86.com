<?php

namespace app\api\controller;

use data\service\ThirdParty;
use data\service\Member as MemberService;

class UniApp extends BaseApi
{
	/**
	 * 检测openid是否已存在
	 */
	public function checkOpenidIsExits()
	{
		$title = "检测openid是否已存在";
		
		$type = $this->get('type', 'oauth');
		$provider = $this->get('provider', '');
		$openid = $this->get('openid', '');
		$unionid = $this->get('unionid', '');
		
		if (empty($provider)) return $this->outMessage($title, [ 'code' => -1, 'message' => '缺少必要参数provider' ]);
		if (empty($openid)) return $this->outMessage($title, [ 'code' => -1, 'message' => '缺少必要参数openid' ]);
		
		$third_party = new ThirdParty();
		$data = $third_party->checkOpenidIsExits($type, $provider, $openid, $unionid);
		return $this->outMessage($title, $data);
	}
	
	/**
	 * 绑定账号和登录
	 */
	public function login()
	{
		$title = '绑定账号和登录';
		
		$params['mode'] = $this->get('mode', 'quick'); // 模式 quick：一键手机号登录， account：账号绑定登录，mobile：手机号绑定登录
		$params['provider'] = $this->get('provider', ''); // 授权服务提供商
		$params['openid'] = $this->get('openid', '');
		$params['unionid'] = $this->get('unionid', '');
		$params['account'] = $this->get('account', ''); // 账号
		$params['password'] = $this->get('password', ''); // 密码
		$params['avatar'] = $this->get('avatar', ''); // 头像
		$params['nickname'] = $this->get('nickname', ''); // 昵称
		$params['code'] = $this->get('code', ''); // 动态码
		$params['flag'] = 'login'; // 标识 login：登录，register：注册
		$source_uid = $this->get('source_uid', ''); // 来源用户id
		
		if (empty($params['provider'])) return $this->outMessage($title, [ 'code' => -1, 'message' => '缺少必要参数provider' ]);
		if (empty($params['openid'])) return $this->outMessage($title, [ 'code' => -1, 'message' => '缺少必要参数openid' ]);
		if (empty($params['account'])) return $this->outMessage($title, [ 'code' => -1, 'message' => '缺少必要参数account' ]);
		
		if ($source_uid && addon_is_exit('Nsfx')) {
		    $_SESSION['source_uid'] = $source_uid;
		}
		
		$member = new MemberService();
		if ($params['mode'] == "mobile") {
			
			//检测手机号是否存在
			$exist = $member->memberIsMobile($params['account']);
			if (!$exist) {
				return $this->outMessage($title, "", -1, "该手机号不存在");
			}
			
			$send = new Send();
			$res_json = $send->checkDynamicCode();
			$check_res = json_decode($res_json, true);
			if ($check_res['code'] != 0) return $this->outMessage($title, $check_res['data'], $check_res['code'], $check_res['message']);
		} elseif ($params['mode'] == "account") {
			if (empty($params['password'])) return $this->outMessage($title, [ 'code' => -1, 'message' => '缺少必要参数password' ]);
			
			//检测账号是否存在
			$exist = $member->memberIsUserName($params['account']);
			$exist_tel = $member->memberIsMobile($params['account']);
			if (!$exist && !$exist_tel) {
				return $this->outMessage($title, "", -1, "该账号不存在");
			}
			
		}
		
		$third_party = new ThirdParty();
		$data = $third_party->authAfter($params);
		
		return $this->outMessage($title, $data, $data['code'], $data['message']);
	}
	
	/**
	 * 绑定账号和注册
	 */
	public function register()
	{
		$title = '绑定账号和注册';
		
		$params['mode'] = $this->get('mode', 'quick'); // 模式 quick：一键手机号登录， account：账号绑定登录，mobile：手机号绑定登录
		$params['provider'] = $this->get('provider', ''); // 授权服务提供商
		$params['openid'] = $this->get('openid', '');
		$params['unionid'] = $this->get('unionid', '');
		$params['account'] = $this->get('account', ''); // 账号
		$params['password'] = $this->get('password', ''); // 密码
		$params['avatar'] = $this->get('avatar', ''); // 头像
		$params['nickname'] = $this->get('nickname', ''); // 昵称
		$params['code'] = $this->get('code', ''); // 动态码
		$params['flag'] = 'register'; // 标识 login：登录，register：注册
		$source_uid = $this->get('source_uid', ''); // 来源用户id
		
		if ($source_uid && addon_is_exit('Nsfx')) {
			$_SESSION['source_uid'] = $source_uid;
		}
		
		if (empty($params['provider'])) return $this->outMessage($title, [ 'code' => -1, 'message' => '缺少必要参数provider' ]);
		if (empty($params['openid'])) return $this->outMessage($title, [ 'code' => -1, 'message' => '缺少必要参数openid' ]);
		if (empty($params['account'])) return $this->outMessage($title, [ 'code' => -1, 'message' => '缺少必要参数account' ]);
		if (empty($params['password'])) return $this->outMessage($title, [ 'code' => -1, 'message' => '缺少必要参数password' ]);
		
		$member = new MemberService();
		if ($params['mode'] == "quick") {
			
			//检测手机号是否已注册
			$exist = $member->memberIsMobile($params['account']);
			if ($exist) {
				return $this->outMessage($title, "", -1, "该手机号已存在");
			}
			
		} elseif ($params['mode'] == "mobile") {
			
			//检测手机号是否已注册
			$exist = $member->memberIsMobile($params['account']);
			if ($exist) {
				return $this->outMessage($title, "", -1, "该手机号已存在");
			}
			
			$send = new Send();
			$res_json = $send->checkDynamicCode();
			$check_res = json_decode($res_json, true);
			if ($check_res['code'] != 0) return $this->outMessage($title, $check_res['data'], $check_res['code'], $check_res['message']);
			
		} elseif ($params['mode'] == "account") {
			
			//检测账号是否已注册
			$exist = $member->memberIsUserName($params['account']);
			if ($exist) {
				return $this->outMessage($title, "", -1, "该账号已存在");
			}
		}
		
		$third_party = new ThirdParty();
		$data = $third_party->authAfter($params);
		
		return $this->outMessage($title, $data, $data['code'], $data['message']);
	}
	
	/**
	 * 获取openid
	 */
	public function getOpenid()
	{
		$title = '获取openid';
		$provider = $this->get('provider', '');
		if (empty($this->uid)) {
			return $this->outMessage($title, "", '-9999', "无法获取会员登录信息");
		}
		$third_party = new ThirdParty();
		$openid = $third_party->getOpenid($provider, $this->uid);
		return $this->outMessage($title, [ 'openid' => $openid ]);
	}
	
	/**
	 * 根据openid查询手机号
	 * @return string
	 */
	public function getMobileByOpenId()
	{
		$provider = $this->get('provider', ''); // 授权服务提供商
		$openid = $this->get('openid', '');//openid
		$title = '根据openid获取手机号';
		$third_party = new ThirdParty();
		$res = $third_party->getMobileByOpenId($provider, $openid);
		return $this->outMessage($title, $res);
	}
}