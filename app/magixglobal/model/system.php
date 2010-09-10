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
	public static function magixlog($str,$e){
		//Systeme de log + firephp
		$log = magixcjquery_error_log::getLog();
        $log->logfile = M_TMP_DIR;
        $log->write($str. $e->getMessage(),__FILE__, $e->getLine());
        return magixcjquery_debug_magixfire::magixFireError($e);
	}
}
?>