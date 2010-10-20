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
 * @category   Model 
 * @package    magixglobal
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
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
			$log = magixcjquery_error_log::getLog();
	        $log->logfile = M_TMP_DIR;
	        $log->write('An error has occured :'. $e->getMessage(),__FILE__, $e->getLine());
	        magixcjquery_debug_magixfire::magixFireError($e);
		}
	}
	/**
	 * Retourne le dossier base(ROOT) de Magix CMS
	 */
	public static function base_path(){
		$search  = array('app'.DIRECTORY_SEPARATOR.'magixglobal'.DIRECTORY_SEPARATOR.'model');
		$replace = array('');
		return str_replace($search, $replace, dirname(realpath( __FILE__ )));
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
}
?>