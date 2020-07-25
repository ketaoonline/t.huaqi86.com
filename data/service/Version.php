<?php
/**
 * User.php
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

use data\model\VersionDevolutionModel;
use data\model\VersionPatchModel;

class Version extends BaseService
{
	
	/**
	 * 接口域名
	 */
	private $service_Url = "https://api.niushop.com.cn";
	private $host_url = "";
	private $sign = "";
	function __construct()
	{
		parent::__construct();
		$this->host_url = $_SERVER['HTTP_HOST'];
        $this->sign = file_get_contents('./cert.key');
	}

    /**
     * 获取升级信息
     * @param $param
     */
	public function getUpgradeInfo($last_version_release){

	    //验证授权
        $post_url = $this->service_Url . "/auth/Upgrade/getUpgradeInfo";

        $data = array(
            "version_release" => NIU_RELEASE,
            "cert" => $this->sign,
            "last_version_release" => $last_version_release,
            "module_mark" => NIU_MODULE_MARK
        );

        $result = $this->doPost($post_url, $data);//授权
        $result = json_decode($result, true);
        return $result;
    }
    
    /**
     * 查询可升级版本
     */
    public function getUpgradeVersion(){
        //验证授权
        $post_url = $this->service_Url . "/auth/Upgrade/getUpgradeVersion";
        $data = array(
            "cert" => $this->sign,
			"version_release" => NIU_RELEASE,
            "module_mark" => NIU_MODULE_MARK
        );
        $result = $this->doPost($post_url, $data);//授权
        $result = json_decode($result, true);
        return $result;
    }

    /**
     * 查询服务到期时间
     */
    public function getExpireDate(){
        //验证授权
        $post_url = $this->service_Url . "/auth/Upgrade/getUserExpireDate";
        $data = array(
            "cert" => $this->sign,
			"version_release" => NIU_RELEASE,
            "module_mark" => NIU_MODULE_MARK
        );
        
        $result = $this->doPost($post_url, $data);//授权
        $result = json_decode($result, true);
        return $result;
    }
    /**
     * 在线下载文件
     * @param $param
     */
    public function download($param){
        //验证授权
        $file = $param["file"];//下载文件路径
        $post_url = $this->service_Url . "/auth/Upgrade/download";
        $data = array(
            "module_mark" => $param["module_mark"],
            "version_release" => $param["version_release"],
            "file" => $file,
            "token" => $param["token"]
        );
        
        $result = $this->doPost($post_url, $data);//授权
        if(empty($result))
            return error([]);

        $result = json_decode($result, true);
        return $result;
    }

    /**
     * post 服务器请求
     */
    private function doPost($post_url, $post_data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $post_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        if ($post_data != '' && !empty($post_data)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
//            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($post_data)));
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}