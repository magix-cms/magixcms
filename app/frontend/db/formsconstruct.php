<?php
/**
 * @category   DB CLass 
 * @package    Magix CMS
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name formsconstruct
 * @version 1.0 alpha
 *
 */
class frontend_db_formsconstruct{
	/**
	 * singleton dbnews
	 * @access public
	 * @var void
	 */
	static public $publicdbforms;
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
		return magixglobal_model_db::layerDB()->selectOne($sql,array(':getforms'=>$getforms));
    }
	function s_public_input_in_forms($getforms){
    	$sql = 'SELECT i.idinput,i.label,i.type,i.nameinput,i.required,i.size,i.maxlength,i.value
				FROM mc_forms_input AS i
				WHERE i.idforms = :getforms';
		return magixglobal_model_db::layerDB()->select($sql,array(':getforms'=>$getforms));
    }
	function s_public_required_input_in_forms($getforms){
    	$sql = 'SELECT i.idinput,i.label,i.type,i.nameinput,i.required,i.size,i.maxlength,i.value
				FROM mc_forms_input AS i
				WHERE i.idforms = :getforms AND required=1';
		return magixglobal_model_db::layerDB()->select($sql,array(':getforms'=>$getforms));
    }
}