<?php

namespace Addons\StudyMath;
use Common\Controller\Addon;

/**
 * 数学插件
 * @author XIXI工作室
 */

    class StudyMathAddon extends Addon{

        public $info = array(
            'name'=>'StudyMath',
            'title'=>'数学',
            'description'=>'给小朋友出数学题',
            'status'=>1,
            'author'=>'XIXI工作室',
            'version'=>'0.1',
            'has_adminlist'=>1
        );

	public function install() {
		$install_sql = './Addons/StudyMath/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/StudyMath/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }