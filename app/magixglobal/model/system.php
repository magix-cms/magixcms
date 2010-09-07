<?php
/**
 * @category   Model 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2010-09-06
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name system
 * @version 1.0
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
	public function root_path($arraydir=array(),$dirname=array(),$pathdir){
		if (is_array($arraydir) AND is_array($dirname)) {
			$search  = $arraydir;
			$replace = $dirname;
			return str_replace($search, $replace, $pathdir);
		}
	}
}
?>