<?php

namespace Addons\TimeBank;
use Common\Controller\Addon;

/**
 * 时间银行插件
 * @author XIXI工作室
 */

    class TimeBankAddon extends Addon{

        public $info = array(
            'name'=>'TimeBank',
            'title'=>'时间银行',
            'description'=>'玺玺时间管理工具',
            'status'=>1,
            'author'=>'XIXI工作室',
            'version'=>'0.1',
            'has_adminlist'=>0
        );

	public function install() {
		$install_sql = './Addons/TimeBank/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/TimeBank/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }