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
 * @category   MODEL 
 * @package    magixglobal
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> | <gerits.aurelien@gmail.com>
 * @name language
 *
 */
class magixglobal_model_language{
	
	static protected $reg_codelang = array('fr','en','nl','es','it','de','cn');
	function _construct(){}
	/**
	 * 
	 * Détection de la langue du navigateur
	 * @param $aLanguages
	 * @param $sDefault
	 */
	protected function browserSelectLang($aLanguages, $sDefault = 'fr') {
		if(!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			$aBrowserLanguages = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
			foreach($aBrowserLanguages as $sBrowserLanguage) {
				$sLang = strtolower(substr($sBrowserLanguage,0,2));
				if(in_array($sLang, $aLanguages)) {
					return $sLang;
				}
			}
		}
		return $sDefault;
	}
	/**
	 * 
	 * Execution de la detection de la langue du navigateur
	 */
	protected function detect_browser_Lang(){
		return self::browserSelectLang(self::$reg_codelang, 'en');
	}
	/**
	 * 
	 * Selection de la langue dans la base de donnée
	 * @param $codelang
	 */
	protected function db_select_lang($iso){
		foreach (frontend_db_lang::s_id_current_lang($iso) as $lang){
			return $lang['iso'];
		}
	}
	/**
	 * 
	 * Execute la détection si la langue du navigateur correspond avec la langue dans la liste
	 */
	public function register_lang(){
		if(self::db_select_lang(self::detect_browser_Lang()) != null){
			return self::detect_browser_Lang();
		}
	}
	/**
	 * 
	 * Notification suivant la langue
	 */
	public function notify_lang(){
		if(self::register_lang() != frontend_model_template::current_Language()){
			switch(self::register_lang()){
				case "fr":
					return "test fr";
				break;
				case "en":
					return "test en";
				break;
			}
		}elseif(self::register_lang() == null){
			switch($this->getlang){
				case "fr":
					return "test fr";
				break;
				case "en":
					return "test en";
				break;
			}
		}
	}
}