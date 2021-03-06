<?php
/**
 * DbQuery.php
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

use think\Db;

/**
 * sql 执行表
 */
class DbQuery extends BaseService
{
	
	/***********************************************************SQL开始*********************************************************/
	
	/**
	 * 修复表
	 */
	public function repair($tables)
	{
		if ($tables) {
			Db::startTrans();
			try {
				if (is_array($tables)) {
					$tables = implode('`,`', $tables);
					Db::query("REPAIR TABLE `{$tables}`");
				} else {
					Db::query("REPAIR TABLE `{$tables}`");
				}
				Db::commit();
				return showMessage("数据表修复完成", 1);
			} catch (\Exception $e) {
				// 回滚事务
				Db::rollback();
				return showMessage("数据表修复失败");
			}
		} else {
			return showMessage("请指定要修复的表");
		}
	}
	
	/**
	 * 优化表
	 */
	public function optimize($tables)
	{
		if ($tables) {
			if (is_array($tables)) {
				$tables = implode('`,`', $tables);
				$list = Db::query("OPTIMIZE TABLE `{$tables}`");
				if ($list) {
					
					return showMessage("数据表优化完成", 1);
				} else {
					return showMessage("数据表优化失败");
				}
			} else {
				$list = Db::query("OPTIMIZE TABLE `{$tables}`");
				if ($list) {
					return showMessage("数据表优化完成", 1);
				} else {
					return showMessage("数据表优化失败");
				}
			}
		} else {
			return showMessage("请指定要优化的表");
		}
	}
	
	private function sql_execute($sql, $is_debug)
	{
		if (trim($sql) != '') {
			$sql = str_replace("\r\n", "\n", $sql);
			$sql = str_replace("\r", "\n", $sql);
			$sql_array = explode(";\n", $sql);
			if (!$is_debug) {
				Db::startTrans();
			}
			try {
				foreach ($sql_array as $item) {
					if ($is_debug) {
						Db::startTrans();
					}
					$querySql = trim($item);
					if ($querySql != '') {
						@Db::execute($querySql . ";");
						if ($is_debug) {
							Db::rollback();
						}
					}
				}
				if (!$is_debug) {
					Db::commit();
				}
				return showMessage("执行完毕", 1);
			} catch (\Exception $e) {
				Db::rollback();
				return showMessage($e->getMessage());
			}
		} else {
			return showMessage("请填写要执行的sql语句！");
		}
	}
	
	/**
	 * 执行sql
	 */
	public function sqlQuery($sql)
	{
//         $result=$this->sql_execute($sql, true);
//         if($result["status"]==1){
		$result = $this->sql_execute($sql, false);
//         }
		return $result;
	}
	
	public function yujjia($sql)
	{
		Db::startTrans();
		try {
			Db::query($sql);
			Db::rollback();
			return "1";
		} catch (\Exception $e) {
			Db::rollback();
			return showMessage($e->getMessage());
		}
		
	}
	
	/**
	 * 查询所有表
	 */
	public function getDatabaseList()
	{
		$databaseList = Db::query("SHOW TABLE STATUS");
		return $databaseList;
	}

    /**备份数据库语句
     * @return string
     */
	public function backupSql(){
        $mysql = "set charset utf8;\r\n";
        $table_list = $this->getDatabaseList();
        foreach($table_list as $k => $table_item){
            $table = $table_item["Name"];
            $mysql .= "DROP TABLE IF EXISTS `$table`;\r\n";
            $temp_create_table_result = Db::query("show create table `$table`");
            $create_table = $temp_create_table_result[0]['Create Table'];

            $mysql .= $create_table . ";\r\n";
            Db::query("SHOW TABLE STATUS");
            $data_list =  Db::query("select * from `$table`");
            foreach($data_list as $data_k => $data_item){
                $keys = array_keys($data_item);
                $keys = array_map('addslashes', $keys);
                $keys = join('`,`', $keys);
                $keys = "`" . $keys . "`";
                $vals = array_values($data_item);
                $vals = array_map('addslashes', $vals);
                $vals = join("','", $vals);
                $vals = "'" . $vals . "'";
                $mysql .= "insert into `$table`($keys) values($vals);\r\n";
            }
        }

        return $mysql;
    }
	/***********************************************************SQL结束*********************************************************/
}