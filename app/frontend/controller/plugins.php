<?php
/**
 * @category   Controller 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.cms-site.com)
 * @license    Proprietary software
 * @version    1.0 2009-08-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name PLUGINS
 * @version 1.0
 *
 */
class frontend_controller_plugins{
	/*public static function addTemplate($plugin){
		frontend_config_smarty::getInstance()->addTemplateDir($_SERVER['DOCUMENT_ROOT'].'/plugins/'.$plugin.'/');
	}*/
	/**
	 * Affiche les pages du plugin
	 * @param void $page
	 */
	public static function append_display($plugin,$page){
		return frontend_config_smarty::getInstance()->display($_SERVER['DOCUMENT_ROOT'].'/plugins/'.$plugin.'/skin/public/'.$page);
	}
	/**
	 * Affiche les pages du plugin
	 * @param void $page
	 */
	public static function append_fetch($plugin,$page){
		return frontend_config_smarty::getInstance()->fetch($_SERVER['DOCUMENT_ROOT'].'/plugins/'.$plugin.'/skin/public/'.$page);
	}
	/**
	 * Affiche les pages du plugin
	 * @param void $page
	 */
	public static function append_assign($assign,$fetch){
		return frontend_config_smarty::getInstance()->assign($assign,$fetch);
	}
}