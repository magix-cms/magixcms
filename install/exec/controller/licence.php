<?php
/**
 * @category   Controller
 * @package    install
 * @copyright  Copyright Magix CMS (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name user
 *
 */
class exec_controller_licence extends dblicence{
	/**
	 * licence
	 * @var string licence
	 */
	public $licence;
	/**
	 * constructor
	 * 
	 */
	function __construct(){
		if(isset($_POST['licence'])){
			$this->licence = magixcjquery_form_helpersforms::inputClean($_POST['pseudo']);
		}
	}
	protected function insert_licence(){
		if(isset($this->licence)){
			if(!empty($this->licence)){
				parent::ilicence()->i_licence_config($this->licence);
			}
		}
	}
	public function display_licence_page(){
		exec_config_smarty::getInstance()->display('licence.phtml');
	}
}
class dblicence{
	/**
	 * protected var ini class magixLayer
	 *
	 * @var layer
	 * @access protected
	 */
	protected $layer;
	/**
	 * singleton dbnews
	 * @access public
	 * @var void
	 */
	static public $ilicence;
	/**
	 * Function construct class
	 *
	 */
	function __construct(){
		$this->layer = new magixcjquery_magixdb_layer();
	}
	/**
	 * instance frontend_db_news with singleton
	 */
	public static function ilicence(){
        if (!isset(self::$ilicence)){
         	self::$ilicence = new dblicence();
        }
    	return self::$ilicence;
    }
	public function i_licence_config($setting_id,$setting_value){
		$sql = array(
			'INSERT INTO mc_setting (setting_id,setting_value) VALUE(:setting_value,:setting_id)'
		);
		$this->layer->insert($sql,array(
				':setting_id'	=>	$setting_id,
				':setting_value'=>	$setting_value
			));
	}
}