<?php
/**
 * Index.php
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

namespace app\admin\controller;

use data\extend\database;
use data\service\AppletVersion;
use data\service\DbQuery;
use think\Db;
use think\Session;
use data\service\Version as VersionService;
use data\service\Auth;
/**
 * 升级
 */
class Version extends BaseController
{
    /**
     * 检测升级
     */
    public function checkUpgrade(){
        $up_model = new VersionService();
        $last_version_release = input("last_version_release", '');
        $info = $up_model->getUpgradeInfo($last_version_release);
        if(!empty($info["data"]))
        {
            $info["data"]["error"] = [];
            try {
                //判断upload/upgrade可写权限
                $upgrade_root = 'upload/upgrade/'.$info['data']['sys_version'].'/'.$info['data']['sys_release'];
                dir_mkdir($upgrade_root);
                if(!is_writeable($upgrade_root)){
                    $info["data"]["error"][] = $upgrade_root;
                }
                //备份路径
                $backup_path = 'upload/backup';
                dir_mkdir($backup_path);
                if(!is_writeable($backup_path)){
                    $info["data"]["error"][] = $backup_path;
                }
                //文件重置
                foreach ($info['data']['files'] as $k => $v)
                {
                    if(!checkExistDir($v)){
                        $info["data"]["error"][] = $v;
                    }else{
                        if(file_exists($v) && !is_writeable($v)){
                            $info["data"]["error"][] = $v;
                        }
                    }
                    if(file_exists('upload/upgrade/'.$info['data']['sys_version'].'/'.$info['data']['sys_release'].'/release/'.$v))
                    {
                        unset($info['data']['files'][$k]);
                    }
                }
                if(!empty($info['data']['files']))
                {
                    sort($info['data']['files']);
                }
                if(file_exists('upload/upgrade/'.$info['data']['sys_version'].'/'.$info['data']['sys_release'].'/database.sql'))
                {
                    unlink('upload/upgrade/'.$info['data']['sys_version'].'/'.$info['data']['sys_release'].'/database.sql');
                }
                //生成升级sql文件
                $dir_make = dir_mkdir('upload/upgrade/'.$info['data']['sys_version'].'/'.$info['data']['sys_release']);

                if($dir_make)
                {
                    $res = file_put_contents('upload/upgrade/'.$info['data']['sys_version'].'/'.$info['data']['sys_release'].'/db_upgrade.sql', charsetToUtf8($info['data']['sqls']));
                }else{
                    $info["data"]["error"][] = 'upload/upgrade/'.$info['data']['sys_version'].'/'.$info['data']['sys_release'].'/db_upgrade.sql';
                }
                $info["data"]['script_count'] = count($info["data"]['scripts']);
                $info["data"]['file_count'] = count($info["data"]['files']);
                Session::set("version_update", $info['data']);//记录更新文件序列
                return success($info['data']);
            } catch (Exception $e){
                return error( $e->getMessage());
            }

        }else{

            if($info["code"] < 0){
                $message = $info["message"];
                if($info["code"] == -100){
                    $message .= " 服务续费请跳转到官网<a href='https://www.niushop.com.cn/member/index.html'>续费</a>";
                }
                return error( $message);
            }

        }
    }

    /**
     * 查询可升级版本
     * @return unknown
     */
    public function getUpgradeVersion(){
        $up_model = new VersionService();

        $list = $up_model->getUpgradeVersion();

        return $list;
    }
    /**
     * 升级页面
     */
    public function upgradeView(){
        $last_version_release = input("last_version_release", '');
        $child_menu_list = array(
            array(
                'url' => "upgrade/devolutioninfo",
                'menu_name' => "授权信息",
                "active" => 0
            ),
            array(
                'url' => "upgrade/onlineupdate",
                'menu_name' => "在线更新",
                "active" => 1
            )
        );
        $this->assign('child_menu_list', $child_menu_list);
        $this->assign("version", NIU_VERSION);
        $this->assign("last_version_release", $last_version_release);
        return view($this->style . "Version/version");
    }

    /**
     * 下载操作
     * @return \think\response\View
     */
    public function downloadAction(){
        $child_menu_list = array(
            array(
                'url' => "upgrade/devolutioninfo",
                'menu_name' => "授权信息",
                "active" => 0
            ),
            array(
                'url' => "upgrade/onlineupdate",
                'menu_name' => "在线更新",
                "active" => 1
            )
        );
        $this->assign('child_menu_list', $child_menu_list);
        $this->assign("version", NIU_VERSION);
        $session = Session::get("version_update");
        if(empty($session))
            $this->error("找不到可升级的版本!");

        $count = $session["file_count"]*2;
        if(!empty($session["sqls"])){
            $count += 1;
        }
        $this->assign("count", $count);
        $this->assign("version_info", $session);
        $this->assign("download_path", 'upload/upgrade/'.$session['sys_version'].'/'.$session['sys_release'].'/release/');
        return view($this->style . "Version/download_action");
    }
    /**
     * 查询新版本升级
     */
    public function upgradeAction(){

        $child_menu_list = array(
            array(
                'url' => "upgrade/devolutioninfo",
                'menu_name' => "授权信息",
                "active" => 0
            ),
            array(
                'url' => "upgrade/onlineupdate",
                'menu_name' => "在线更新",
                "active" => 1
            )
        );
        $this->assign('child_menu_list', $child_menu_list);
        $this->assign("version", NIU_VERSION);
        $session = Session::get("version_update");
        if(empty($session))
            $this->error("找不到可升级的版本!");

        $count = $session["file_count"]*2;
        if(!empty($session["sqls"])){
            $count += 1;
        }
        $this->assign("count", $count);
        $this->assign("version_info", $session);
        return view($this->style . "Version/upgrade_action");

    }
    /**
     * 下载系统文件
     */
    public function download(){
        try{
                $index = input("index", 0);
                $session = Session::get("version_update");

                if(!empty($session))
                {

                    $up_model = new VersionService();
                    $file = isset($session['files'][$index]) ? $session['files'][$index] : '';

                    if(empty($file))
                    {
                        return success('upload/upgrade/'.$session['sys_version'].'/'.$session['sys_release'].'/release/', 10);
                    }

                    $data = array(
                        'file' => $file,
                        "version_release" => $session["sys_release"],
                        "module_mark" => $session["sys_version"],
                        "token" => $session["token"]
                    );

                    $info = $up_model->download($data);//异步下载更新文件
                    //下载文件失败
                    if(empty($info["data"]))
                        return $info;

                    $file_path = dirname($file);
                    $info = base64_decode($info['data']);
                    $dir_make = dir_mkdir('upload/upgrade/'.$session['sys_version'].'/'.$session['sys_release'].'/release/'.$file_path);


                    if($dir_make)
                    {
                        if(!empty($info))
                        {
                            $temp_path = 'upload/upgrade/'.$session['sys_version'].'/'.$session['sys_release'].'/release/'.$file;
                            if(preg_match('/[\x{4e00}-\x{9fa5}]/u', $temp_path) > 0){
                                $temp_path = iconv('utf-8','gbk',$temp_path);
                            }

                            $res = file_put_contents($temp_path, $info);
                            if($res)
                            {
                                return success($file);
                            }else{
                                return error($file);
                            }
                        }else{
                            return error("升级文件不存在");
                        }

                    }else{
                        return error("文件读写权限不足");
                    }

                }else{
                    return error("当前没有可升级的文件");
                }
        } catch (Exception $e){
            return error( $e->getMessage());
        }
    }

    /**
     * 备份将覆盖的文件
     */
    public function backupFile(){
        try{
                $session = Session::get("version_update");
                if(!empty($session))
                {
                    //检测文件完整性
                    foreach ($session['files'] as $k => $v)
                    {
                        $temp_path = 'upload/upgrade/'.$session['sys_version'].'/'.$session['sys_release'].'/release/'.$v;
                        if(preg_match('/[\x{4e00}-\x{9fa5}]/u', $temp_path) > 0){
                            $temp_path = iconv('utf-8','gbk',$temp_path);
                        }
                        if(!file_exists($temp_path))
                        {
                            return error("", "文件缺失!");
                        }
                    }

                    dir_mkdir('upload/backup/release');
                    //文件备份
                    $this->backOriginalFile('upload/upgrade/'.$session['sys_version'].'/'.$session['sys_release'].'/release', 'upload/upgrade/'.$session['sys_version'].'/'.$session['sys_release'].'/release/','upload/backup/release/');
                    return success();
                }
        } catch (Exception $e){
            return error( $e->getMessage());
        }
    }

    /**
     * 备份数据库
     * @return mixed[]|string[]
     */
    public function backupSql(){
        ini_set('memory_limit','500M');
        try{
            $session = Session::get("version_update");
            if(!empty($session)) {
                $db_query_service = new DbQuery();
                $sql = $db_query_service->backupSql();

                $filename = "upload/backup/backup.sql"; //存放路径，默认存放到项目最外层
                $fp = fopen($filename, 'w');
                fputs($fp, $sql);
                fclose($fp);
                return success("");
            }
        } catch (Exception $e){
            return error( $e->getMessage());
        }
    }

    /**
     * 更新文件覆盖
     * @return mixed[]|string[]
     */
    public function executeFile(){
        try{
            $session = Session::get("version_update");
            if(!empty($session)) {
                //文件替换
                dir_copy('upload/upgrade/' . $session['sys_version'] . '/' . $session['sys_release'] . '/release', './');
                return success("");
            }
        } catch (Exception $e){
            return error( $e->getMessage());
        }
    }

    /**
     * 备份文件
     * @param $from_path
     * @param $replace_path 将替换的
     * @param $to_path
     */
    public function backOriginalFile($from_path, $replace_path, $to_path){
        try{
            //得到原文件的文件结构
            //1、首先先读取文件夹
            $temp = scandir($from_path);
            //遍历文件夹
            foreach($temp as $v){
                $temp = $from_path.'/'.$v;
                $temp_path = substr_replace($temp,"",strpos($temp,$replace_path),strlen($replace_path));
                if(is_dir($temp)){//如果是文件夹则执行
                    if($v=='.' || $v=='..'){//判断是否为系统隐藏的文件.和..  如果是则跳过否则就继续往下走，防止无限循环再这里。
                        continue;
                    }
                    if(is_dir($temp_path)){
                        dir_mkdir($to_path.$temp_path);
                    }
                    $this->backOriginalFile($temp, $replace_path, $to_path);//因为是文件夹所以再次调用自己这个函数，把这个文件夹下的文件遍历出来
                }else{
                    if(file_exists($temp_path)){
                        copy($temp_path,$to_path.$temp_path);
                    }
                }

            }
        } catch (Exception $e){
            return error( $e->getMessage());
        }
    }
    /**
     * 更新sql 执行
     * @return mixed[]|string[]
     */
    public function executeSql(){
        try{
            $session = Session::get("version_update");
            if(!empty($session)) {
                //执行数据库
                $sql = checkBom('upload/upgrade/'.$session['sys_version'].'/'.$session['sys_release'].'/db_upgrade.sql');
    //            $sql = file_get_contents('upload/upgrade/'.$session['sys_version'].'/'.$session['sys_release'].'/db_upgrade.sql');
                $sql_arr = parseSql($sql);
                foreach($sql_arr as $k => $v){

                    $v = trim($v);
                    if(!empty($v) && $v != ""){
                        Db::execute($v);
                    }
                }
                
                $auth_service = new Auth();
                $auth_service->toUpdateRole();
                return success("");
            }
        } catch (Exception $e){
            return error( $e->getMessage());
        }
    }

    /**
     * 更新结束
     */
    public function upgradeEnd(){
        Session::set("version_update", null);
        return success("");
    }

    
    /**
     * 版本恢复
     */
    public function recovery(){
        try{
            //回滚备份的文件
           if(dir_is_empty('upload/backup/')){
                return error("没有可会滚得备份!");
            }
            dir_copy('upload/backup/release', './');
            //回滚执行的sql语句
            $sql_path = 'upload/backup/backup.sql';
            //执行数据库
            $sql = checkBom($sql_path);

            $sql_arr = parseSql($sql);
            foreach($sql_arr as $k => $v){
                $v = trim($v);
                if(!empty($v) && $v != ""){
                    Db::execute($v);
                }
            }
            return success("备份回滚成功!");
        } catch (Exception $e){
            return error( $e->getMessage());
        }

    }
}