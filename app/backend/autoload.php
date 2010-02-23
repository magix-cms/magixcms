<?php
/**
 * @category   Autoload
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
class backend_Autoloader
{
  private static $path;   // = '/path/to/parent_of_Perso/'
  private static $prefix; // = 'Perso_'
 
  public static function register()
  {
    // $prefix et $path sont computés ici
    // mais pourrait être codés en dure.
    // Les calculer dynamiquement (1 seule fois)
    // permet juste un peu de souplesse par rapport
    // au nom de la classe et son emplacement
    self::$prefix = substr(__CLASS__, 0, strpos(__CLASS__, '_')+1);
    self::$path   = dirname(dirname(realpath(__FILE__))).DIRECTORY_SEPARATOR;
    
    // ici est opéré la registration
    spl_autoload_register(array(__CLASS__, 'autoload'));
  }
 
  public static function autoload($class)
  {
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