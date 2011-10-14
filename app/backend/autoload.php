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
 * @category   Autoloader 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.2
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be> | <gerits.aurelien@gmail.com>
 * @name Autoloader
 *
 */
class backend_Autoloader{
	/**
	 * @static
	 * @var path
	 * string
	 */
	private static $path;
	/**
	 * @static
	 * @var prefix
	 * string
	 */
	private static $prefix;
	 /**
	  * Registration
	  * @access public
	  * @static
	  * @name register
	  */
	  public static function register(){
	    self::$prefix = substr(__CLASS__, 0, strpos(__CLASS__, '_')+1);
	    self::$path   = dirname(dirname(realpath(__FILE__))).DIRECTORY_SEPARATOR;
	    // ici est opéré la registration
	    spl_autoload_register(array(__CLASS__, 'autoload'));
	  }
 	/**
 	 * Autoload
 	 * @param void $class
 	 * @access public
 	 * @static
 	 */
	  public static function autoload($class)
	  {
	    // vérifie que 'backend_' est bien le prefix demandé
	    if (strpos($class, self::$prefix) === 0) {
	    	if(file_exists(self::$path.str_replace('_', DIRECTORY_SEPARATOR, $class).'.php')){
	      		include self::$path
	             .str_replace('_', DIRECTORY_SEPARATOR, $class)
	             .'.php';
	    	}
	    }
	  }
	  /**
	   * Supprime un fichier de l'autoload (contraire de register)
	   * @param void $class
	   * @access public
 	 	* @static
	   */
	  public static function unregister($class){
	  	spl_autoload_unregister(array($class, 'autoload'));
	  }
}
?>