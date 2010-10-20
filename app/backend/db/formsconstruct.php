<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Magix CMS.
# Magix CMS, a CMS optimized for SEO
# Copyright (C) 2010 - 2011  Gerits Aurelien <aurelien@magix-cms.com>
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.

# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
# -- END LICENSE BLOCK -----------------------------------
/**
 * MAGIX CMS
 * @category   DB 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    0.2alpha
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name formsconstruct
 *
 */
class backend_db_formsconstruct{
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
	static public $admindbforms;
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
	public static function adminDbForms(){
        if (!isset(self::$admindbforms)){
         	self::$admindbforms = new backend_db_formsconstruct();
        }
    	return self::$admindbforms;
    }
    /**
     * Selectionne les formulaires inséré dans la DB
     */
    function s_forms(){
    	$sql = 'SELECT count( i.idforms ) AS countinput, f.idforms, f.titleforms, f.urlforms,f.idlang, lang.codelang
				FROM mc_forms AS f
				LEFT JOIN mc_forms_input AS i ON ( i.idforms = f.idforms )
				LEFT JOIN mc_lang AS lang ON ( f.idlang = lang.idlang )
				GROUP BY f.idforms';
		return $this->layer->select($sql);
    }
    function c_forms_size(){
    	$sql = 'SELECT count( f.idforms ) as countforms FROM mc_forms as f';
		return $this->layer->selectOne($sql);
    }
    /**
     * Insert un nouveau formulaire
     * @param $idlang
     * @param $titleforms
     * @param $urlforms
     */
    function i_forms($idlang,$titleforms,$urlforms){
    	$sql = 'INSERT INTO mc_forms (idlang,titleforms,urlforms) 
		VALUE(:idlang,:titleforms,:urlforms)';
		$this->layer->insert($sql,
		array(
			':idlang'			=>	$idlang,
			':titleforms'		=>	$titleforms,
			':urlforms'			=>	$urlforms
		));
    }
	/**
	 * 
	 *  Insert un nouveau champ dans un formulaire
	 * @param $iforms
	 * @param $type
	 * @param nameinput
	 * @param $required
	 * @param $value
	 */
    function i_forms_input($iforms,$label,$type,$nameinput,$required,$size,$maxlength,$value=null){
    	$sql = 'INSERT INTO mc_forms_input (idforms,label,type,nameinput,required,size,maxlength,value) 
		VALUE(:idforms,:label,:type,:nameinput,:required,:size,:maxlength,:value)';
		$this->layer->insert($sql,
		array(
			':idforms'		=>	$iforms,
			':label'		=>	$label,
			':type'			=>	$type,
			':nameinput'	=>	$nameinput,
			':required'		=>	$required,
			':size'			=>	$size,
			':maxlength'	=>	$maxlength,
			':value'		=>	$value,
		));
    }
    /**
     * Selectionne les formulaires pour la construction du menu select
     */
    function s_selected_forms(){
    	$sql = 'SELECT f.idforms, f.titleforms, lang.codelang
				FROM mc_forms AS f
				LEFT JOIN mc_lang AS lang ON ( f.idlang = lang.idlang )
				ORDER BY f.idlang';
		return $this->layer->select($sql);
    }
    /**
     * selectionne les champs du formulaire
     * @param $getforms
     */
    function s_input_in_forms($getforms){
    	$sql = 'SELECT i.idinput,i.label,i.type,i.nameinput,i.required,i.size,i.maxlength,i.value
				FROM mc_forms_input AS i
				WHERE idforms = :getforms';
		return $this->layer->select($sql,array('getforms'=>$getforms));
    }
    /**
     * selectionne les données pour une fiche
     * @param $getforms
     */
    function s_getforms_unique($getforms){
    	$sql = 'SELECT f.titleforms,f.urlforms
				FROM mc_forms AS f
				WHERE f.idforms = :getforms';
		return $this->layer->selectOne($sql,array('getforms'=>$getforms));
    }
    /**
     * Supprime un champ
     * @param $delinput
     */
	function d_input($delinput){
		$sql = 'DELETE FROM mc_forms_input WHERE idinput = :delinput';
			$this->layer->delete($sql,
			array(
				':delinput'	=>	$delinput
			)); 
	}
}