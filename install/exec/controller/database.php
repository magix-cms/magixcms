<?php
/**
 * MAGIX CMS
 * @category   Controller 
 * @package    INSTALL
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.2
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name database
 *
 */
class exec_controller_database{
	/**
	 * post ctable
	 * @var void
	 */
	public $process;
	/**
	 * Constructor
	 */
	function __construct(){
		if(magixcjquery_filter_request::isGet('process')){
			$this->process = (string) magixcjquery_form_helpersforms::inputClean($_GET['process']);
		}
	}
	/**
	 * @access private
	 * load sql file
	 */
	private function load_sql_file(){
		return magixglobal_model_system::base_path().'install'.DIRECTORY_SEPARATOR.'sql'.DIRECTORY_SEPARATOR.'db.sql';
	}
	/**
	 * @access private
	 * install_db
	 */
	private function install_db(){
		if(file_exists(self::load_sql_file())){
			magixglobal_model_db::create_new_sqltable(self::load_sql_file());
			exec_config_smarty::getInstance()->display('request/success-table.phtml');
		}
	}
	/**
	 * Affiche la page de la construction des tables
	 */
	private function display_database_page(){
		exec_config_smarty::getInstance()->display('database.phtml');
	}
	/**
	 * Execution 
	 */
	public function run(){
		if(magixcjquery_filter_request::isGet('process')){
			self::install_db();
		}else{
			self::display_database_page();
		}
	}
}