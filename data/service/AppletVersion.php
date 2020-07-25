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
use data\model\NsdownloadappletModel;



class AppletVersion extends BaseService
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
     *
     * @return mixed
     */
	public function getAppletList(){
        //验证授权
        $post_url = $this->service_Url . "/auth/Applet/getMemberAppletList";

        $data = array(
            "cert" => $this->sign,
        );

        $result = $this->doPost($post_url, $data);//授权
        $result = json_decode($result, true);
        return $result;
    }

    /**
     * 小程序版本列表
     * @param $params
     * @return mixed
     */
    public function getAppletVersionList($params){
        //验证授权
        $post_url = $this->service_Url . "/auth/Applet/getAppletVersionList";

        $data = array(
            "cert" => $this->sign,
            "applet_module_mark" => $params["applet_module_mark"]
        );

        $result = $this->doPost($post_url, $data);//授权
        $result = json_decode($result, true);
        return $result;
    }

    /**
     * 小程序版本列表
     * @param $params
     * @return mixed
     */
    public function getAppletVersionUpgradeInfo($params){
        //验证授权
        $post_url = $this->service_Url . "/auth/Applet/getAppletVersionUpgradeInfo";

        $data = array(
            "cert" => $this->sign,
            "applet_module_mark" => $params["applet_module_mark"],
            "last_version_release" => $params["last_version_release"],
            "type" => $params["type"]
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
        $post_url = $this->service_Url . "/auth/Applet/download?token=".$param["token"];
        return $post_url;
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
    
    /**
     * 获取官网最新版小程序列表
     */
    public function getwebAppletList($mark){
        //验证授权
        $post_url = $this->service_Url . "/auth/Applet/getAppletVersionList";
        
        $data = array(
            "mark" => $mark,
        );
        
        $result = $this->doPost($post_url, $data);//授权
        $result = json_decode($result, true);
        return $result;
    }
    /**
     * 获取商城本地是否存在记录
     * @param unknown $version_name
     * @param unknown $mark
     */
    public function getlocApplet($version_name,$mark){
        $downloadmodel = new NsdownloadappletModel();
        $downlist = $downloadmodel->getInfo([
            "version_name"=>$version_name,
            "mark"=>$mark
        ],'*');
        return $downlist;
        
    }
    
    /**
     * 添加小程序版本数据到本地
     */
    public function addlocApplet($res){
        $downloadmodel = new NsdownloadappletModel();
        $data = array(
            'version_name'=>$res['version_name'],
            'mark'=>$res['mark'],
            'creattime'=>time(),
            'is_look'=>0
        );
        $result = $downloadmodel -> save($data);
        return $result;
    }
    /**
     * 修改本地小程序记录是否查看
     */
    public function updatelocApplet($res){
        $downloadmodel = new NsdownloadappletModel();
        $result = $downloadmodel->save(['is_look'=>1],['version_name'=>$res['version_name'],'mark'=>$res['module_mark']]);
        return $result;
    }
    
    
}