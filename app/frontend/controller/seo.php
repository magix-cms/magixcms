<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 magix-cms.com <support@magix-cms.com>
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com> <contact@aurelien-gerits.be>
 #
 # Redistributions of files must retain the above copyright notice.
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

 # DISCLAIMER

 # Do not edit or add to this file if you wish to upgrade MAGIX CMS to newer
 # versions in the future. If you wish to customize MAGIX CMS for your
 # needs please refer to http://www.magix-cms.com for more information.
 */
/**
 * MAGIX CMS
 * @category   Controller 
 * @package    frontend
 * @copyright  MAGIX CMS Copyright (c) 2011 - 2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @id  $Id$  
 * @rev $Rev$ 
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be> $Author$
 * @name SEO
 *
 */
class frontend_controller_seo extends frontend_db_seo{
	/**
	 * 
	 * Définition de l'attribut
	 * @var $attribute
	 */
	public $attribute,
	/**
	 * Définition du niveau
	 */
	$level,
	/**
	 * Définition du style de métas
	 */
	$idmetas,
	/**
	 * Définition de la langue
	 */
	$iso;
	public function __construct($attribute,$level,$idmetas,$iso){
		$this->attribute = $attribute;
		$this->level = $level;
		$this->idmetas = $idmetas;
		$this->iso = $iso;
	}
	/**
	 * @access private
	 * Sélectionne les éléments dans un tableau pour traitement
	 */
	private function load_current_seo(){
		return parent::s_public_rewrite(
			$this->attribute, 
			$this->level, 
			$this->idmetas, 
			$this->iso
		);
	}

	/**
	 * @access public
	 * Remplace les données en tre crochet pour construire la réécriture
	 * @param string $record
	 * @param string $category
	 * @param string $subcategory
     * @return mixed
     */
	public function replace_var_rewrite($record='',$category='',$subcategory=''){
		$db = self::load_current_seo();
		if($db != null){
			//Tableau des variables à rechercher
			$search = array('[[record]]','[[category]]','[[subcategory]]');
			//Tableau des variables à remplacer 
			$replace = array($record,$category,$subcategory);
			//texte générique à remplacer
			$content = str_replace($search ,$replace,$db['strrewrite']);
			return $content;
		}
	}
}
?>