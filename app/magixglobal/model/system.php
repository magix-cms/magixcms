<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2012 sc-box.com <support@magix-cms.com>
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
 * @category   Model 
 * @package    magixglobal
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be> | <gerits.aurelien@gmail.com>
 * @name system
 *
 */
class magixglobal_model_system{
	/**
	 * @access public
	 * Retourne le chemin racine de Magix CMS
	 * @param array $arraydir
	 * @param array $dirname
	 * @param string $pathdir
	 */
	public static function root_path($arraydir=array(),$dirname=array(),$pathdir){
		try {
			if (is_array($arraydir) AND is_array($dirname)) {
				$search  = $arraydir;
				$replace = $dirname;
				return str_replace($search, $replace, $pathdir);
			}
		}catch(Exception $e) {
			self::magixlog("An error has occured :", $e);
		}
	}
	/**
	 * Retourne le dossier base(ROOT) de Magix CMS
	 */
	public static function base_path(){
		try{
			$search  = array('app'.DIRECTORY_SEPARATOR.'magixglobal'.DIRECTORY_SEPARATOR.'model');
			$replace = array('');
			return str_replace($search, $replace, dirname(realpath( __FILE__ )));
		}catch(Exception $e) {
			self::magixlog("An error has occured :", $e);
		}
	}
	/**
	 * Initialise le système de LOG du CMS
	 * @param string $str
	 * @param void $e (paramètre Exception)
	 */
	public static function magixlog($str,$e){
		//Systeme de log + firephp
		$log = magixcjquery_error_log::getLog();
        $log->logfile = M_TMP_DIR;
        $log->write($str. $e->getMessage(),__FILE__, $e->getLine());
        magixcjquery_debug_magixfire::magixFireError($e);
	}
	/**
	 * extract domain
	 * exemple: http//www.mydomain.com => mydomain.com
	 */
	public static function extract_domain(){
		$parse = parse_url(magixcjquery_html_helpersHtml::getUrl(), PHP_URL_HOST);
		return substr($parse,4);
	}
	/**
	 * @access public
	 * Remplace les variables par un contenu de substitution
	 * @param array $search
	 * @param array $replace
	 * @param string $str
	 * @throws Exception
	 */
	public static function vars_replace(array $search,array $replace, $str){
		//Tableau des variables à rechercher
		if(!is_array($search)){
			throw new Exception('var search is not array');
		}
		//Tableau des variables à remplacer 
		if(!is_array($replace)){
			throw new Exception('var replace is not array');
		}
		//texte générique à remplacer
		return str_replace($search ,$replace,$str);
	}
}
?>