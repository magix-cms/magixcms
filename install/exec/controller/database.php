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
class exec_controller_database extends create_database{
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
		$db_structure = "";
		$structureFile = magixglobal_model_system::base_path().'install'.DIRECTORY_SEPARATOR.'sql'.DIRECTORY_SEPARATOR.'db.sql';
		if(!file_exists($structureFile)){
			throw new Exception("Error : Not File exist db.sql");
		}else{
			$db_structure = preg_split("/;\\s*[\r\n]+/",file_get_contents($structureFile));
		}
		return $db_structure;
	}
	/**
	 * @access private
	 * install_db
	 */
	private function install_db(){
		if(self::load_sql_file() != false){
			foreach(self::load_sql_file() as $query){
				$query = trim($query);
				parent::cdatabase()->c_table($query);
			}
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
class create_database{
	/**
	 * singleton dbnews
	 * @access public
	 * @var void
	 */
	static public $cdatabase;
	/**
	 * instance frontend_db_news with singleton
	 */
	public static function cdatabase(){
        if (!isset(self::$cdatabase)){
         	self::$cdatabase = new create_database();
        }
    	return self::$cdatabase;
    }
    /*
     * requête sql pour la création de la table des utilisateurs
     */
	protected function c_table($sql){
		magixglobal_model_db::layerDB()->createTable($sql);
		return true;
	}
}