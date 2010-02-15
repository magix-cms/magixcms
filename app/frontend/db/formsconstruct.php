<?php
/**
 * @category   DB CLass 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 * @name formsconstruct
 * @version 1.0 alpha
 *
 */
class frontend_db_formsconstruct{
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
	static public $publicdbforms;
	/**
	 * Function construct class
	 *
	 */
	function __construct(){
		$this->layer = new magixcjquery_magixdb_layer();
	}
	/**
	 * instance frontend_db_home with singleton
	 */
	public static function publicDbForms(){
        if (!isset(self::$publicdbforms)){
         	self::$publicdbforms = new frontend_db_formsconstruct();
        }
    	return self::$publicdbforms;
    }
	function s_public_getforms($getforms){
    	$sql = 'SELECT f.idforms,f.titleforms,f.urlforms
				FROM mc_forms AS f
				WHERE f.idforms = :getforms';
		return $this->layer->selectOne($sql,array(':getforms'=>$getforms));
    }
	function s_public_input_in_forms($getforms){
    	$sql = 'SELECT i.idinput,i.label,i.type,i.nameinput,i.required,i.size,i.maxlength,i.value
				FROM mc_forms_input AS i
				WHERE i.idforms = :getforms';
		return $this->layer->select($sql,array(':getforms'=>$getforms));
    }
	function s_public_required_input_in_forms($getforms){
    	$sql = 'SELECT i.idinput,i.label,i.type,i.nameinput,i.required,i.size,i.maxlength,i.value
				FROM mc_forms_input AS i
				WHERE i.idforms = :getforms AND required=1';
		return $this->layer->select($sql,array(':getforms'=>$getforms));
    }
}