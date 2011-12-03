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
 * @category   MODEL 
 * @package    frontend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> | <gerits.aurelien@gmail.com>
 * @name IniLang
 *
 */
class frontend_model_IniLang{
	/**
	 * lang setting conf
	 *
	 * @var string 'fr', ' 'en', ...
	 */
	public $loadlang;
	/**
	 * function construct class
	 *
	 */
	function __construct(){
		if (isset($_GET['strLangue'])) {
			$this->loadlang = magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3);
		}
	}
	/**
	 * function display home backend
	 *
	 */
	private function loadGlobalLang(){
		$langue = explode(",",$_SERVER['HTTP_ACCEPT_LANGUAGE']);
		$langue = strtolower(substr(chop($langue[0]),0,2));
		switch ($langue){
			case 'en':
				$langue = 'en';
				break;
			case 'fr':
				$langue = 'fr';
				break;
			case 'de':
				$langue = 'de';
				break;
			case 'nl':
				$langue = 'nl';
				break;
			case 'es':
				$langue = 'es';
				break;
			case 'it':
				$langue = 'it';
				break;
			default:
				$langue = 'fr';
		}
		if (empty($_SESSION['strLangue']) || !empty($this->loadlang)) {
			
	 		 return $_SESSION['strLangue'] = empty($this->loadlang) ? $langue : $this->loadlang;
	 		 
		}else{
			if (isset($this->loadlang)) {
	 		 	return $this->loadlang  = $langue;
	 		 }
		}
	}
	/**
	 * Retourne l'OS courant si windows
	 */
	private function getOS(){
		if(stripos($_SERVER['HTTP_USER_AGENT'],'win')){
			return 'windows';
		}
	}
	/**
	 * Modification du setlocale suivant la langue courante pour les dates
	 */
	private function setTimeLocal(){
		if(frontend_model_template::current_Language() == 'nl'){
			if($this->getOS() === 'windows'){
				setlocale(LC_TIME, 'nld_nld','nl');
			}else{
				setlocale(LC_TIME, 'nl_NL.UTF8','nl');
			}
		}elseif(frontend_model_template::current_Language() == 'fr'){
			setlocale(LC_TIME, 'fr_FR.UTF8', 'fra');
		}elseif(frontend_model_template::current_Language() == 'de'){
			setlocale(LC_TIME, 'de_DE.UTF8', 'de');
		}elseif(frontend_model_template::current_Language() == 'es'){
			setlocale(LC_TIME, 'es_ES.UTF8', 'es');
		}elseif(frontend_model_template::current_Language() == 'it'){
			setlocale(LC_TIME, 'it_IT.UTF8', 'it');
		}else{
			setlocale(LC_TIME, 'en_US.UTF8', 'en');
		}
	}
	public function autoLangSession(){
		$this->loadGlobalLang();
	}
}
?>