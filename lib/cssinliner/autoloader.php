<?php
/**
 * CSS Inliner
 *
 * @access public
 * @version 0.1
 *
 */
/**
 * Autoload for CSS Inliner
 */
namespace cssinliner;

class cssinliner_Autoloader
{
	private static $DS;
	private static $ROOT;
	private static $path;
	private static $className = __CLASS__;
	private static $prefix;

	public static function register(){
		self::$DS = DIRECTORY_SEPARATOR; // meilleur portabilité sur les différents systeme.
		self::$ROOT = dirname(__FILE__).self::$DS; // pour se simplifier la vie
		spl_autoload_register(array(__CLASS__, 'autoload'));
		//self::$prefix = substr(self::$className, 0, strpos(self::$className, '_')+1);
	}

	public static function autoload($class){
		if(strpos($class,'\\')) {
			$parts = preg_split('#\\\#', $class);
			$className = array_pop($parts);

			// on créé le chemin vers la classe
			// on utilise DS car plus propre et meilleure portabilité entre les différents systèmes (windows/linux)

			//array_shift($parts);
			$path = implode(self::$DS, $parts);
			$file = $className . '.php';

			$filepath = self::$ROOT . $path . self::$DS . $file;

			// var_dump($filepath); => C:\xampp\htdocs\Labs\Eloyas\app\tester\Test.php

			require $filepath;
		}
	}
}
?>