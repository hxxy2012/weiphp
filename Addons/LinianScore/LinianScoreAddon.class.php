<?php

namespace Addons\LinianScore;
use Common\Controller\Addon;

/**
 * LinianScore插件
 * @author 凡星
 */

    class LinianScoreAddon extends Addon{

        public $info = array(
            'name'=>'LinianScore',
            'title'=>'历年成绩',
            'description'=>'历年成绩查询插件',
            'status'=>1,
            'author'=>'niool',
            'version'=>'0.1',
            'has_adminlist'=>0,
            'type'=>1         
        );

	public function install() {
		$install_sql = './Addons/LinianScore/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/LinianScore/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }