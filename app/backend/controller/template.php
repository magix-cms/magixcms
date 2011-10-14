<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Magix CMS.
# Magix CMS, a CMS optimized for SEO
# Copyright (C) 2010 - 2012  Gerits Aurelien <aurelien@magix-cms.com>
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
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.1
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name templates
 *
 */
class backend_controller_template{
	/**
	 * Affiche les pages phtml
	 * @param void $page
	 */
	public static function display($page,$plugin=''){
		return backend_config_smarty::getInstance()->display($page);
	}
	/**
	 * Affiche les pages phtml supplémentaire
	 * @param void $page
	 */
	public static function fetch($page,$plugin=''){
		return backend_config_smarty::getInstance()->fetch($page);
	}
	/**
	 * Assign les variables dans les fichiers phtml
	 * @param void $page
	 */
	public static function assign($assign,$fetch){
		return backend_config_smarty::getInstance()->assign($assign,$fetch);
	}
	/**
	 * Charge les variables du fichier de config dans le site
	 * @param string $varname
	 */
	public static function getConfigVars($varname){
		if($varname != null){
			return backend_config_smarty::getInstance()->getConfigVars($varname);
		}else{
			throw new Exception("getConfigVars is null");
		}
	}
}