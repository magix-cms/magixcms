<?php
/**
 * @category   Plugins Autoloader
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.cms-site.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
class plugins_Autoloader{
	/**
	 * Chemin vers le dossier des plugins
	 * @var string
	 * @static
	 * @access private
	 */
  private static $path;
  	/**
	 * Prefix obligatoire (plugins_)
	 * @var string
	 * @static
	 * @access private
	 */
  private static $prefix;
  /**
   * Enregistrement des classes dans l'autoload
   */
  public static function register(){
  	self::$prefix = substr(__CLASS__, 0, strpos(__CLASS__, '_')+1);
  	self::$path = dirname(dirname(realpath(__FILE__))).DIRECTORY_SEPARATOR; 
    // ici est opéré la registration
    spl_autoload_register(array(__CLASS__, 'autoload'));
  }
  /**
   * Auto chargement des classes
   * @param unknown_type $class
   */
  public static function autoload($class){
    // vérifie que 'frontend_' est bien le prefix demandé
    if (strpos($class, self::$prefix) === 0) {
    	if(file_exists(self::$path.str_replace('_', DIRECTORY_SEPARATOR, $class).'.php')){
      		include self::$path
             .str_replace('_', DIRECTORY_SEPARATOR, $class)
             .'.php';
    	}
    }
  }
	/**
   * Supprime un fichier de l'autoload
   * @param $class
   */
  public static function unregister($class){
  	spl_autoload_unregister(array($class, 'autoload'));
  }
}
?>