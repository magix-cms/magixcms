<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of magix cjQuery.
# The above copyright notice and this permission notice shall be included in
# all copies or substantial portions of the Software.
# Magix cjQuery is a library written in PHP 5.
# It can work with a layer of abstraction, to validate data, handle jQuery code in PHP.
# Copyright (C)Magix cjQuery 2009 Gerits Aurelien
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as
# published by the Free Software Foundation, either version 3 of the
# License, or (at your option) any later version.
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.
# You should have received a copy of the GNU Affero General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
# -- END LICENSE BLOCK -----------------------------------
//require dirname(__FILE__).('/FirePHPCore/FirePHP.class.php');
define('INSIGHT_IPS', '*');
define('INSIGHT_AUTHKEYS', '*');
define('INSIGHT_PATHS', dirname(__FILE__));
define('INSIGHT_SERVER_PATH', '/index.php');
define('INSIGHT_DEBUG', false);
set_include_path(dirname(__FILE__) . '/lib-1.0b1rc6' . PATH_SEPARATOR . get_include_path());
if (M_FIREPHP==false){
	define('FIREPHP_ACTIVATED', false);
}
//define('INSIGHT_CONFIG_PATH', dirname(__FILE__).'/package.json');
//require_once(dirname(__FILE__).('/lib/FirePHP/init.php'));
require_once('lib-1.0b1rc6/FirePHP/Init.php'); 
/*
############
############ Using FirePHP on production sites can expose sensitive information ###########
############
*/
/**
 * 
 * Magix cjQuery
 * 
 * @author Gérits Aurélien
 * @copyright Magix cjQuery
 * @version 0.3
 * @package debug with FirePHP
 * FirePHP (false or true)
 * define('M_FIREPHP',true);
 *
 */
class magixcjquery_debug_magixfire{
	/**
	 * Instance FirePHP class
	 * @var Instance
	 * @access protected
	 * @static
	 */
  protected static $Instance;
	/**
	* timer start
	* @var timerStart
	*/
  protected static $timerStart = 0;
  /**
   * timer stop
   * @var timerEnd
   */
  protected static $timerEnd = 0;
  /**
   * @static function Instance
   * Singleton function
   */
  protected static function Instance(){
  		if (!isset(self::$Instance)){
         	self::$Instance = new FirePHP();
        }
    return self::$Instance;
  }
  /*
   * get Instance FirePHP and execute if M_FIREPHP = true
   */
	protected static function getIniInstance(){
	    if (M_FIREPHP){
	    	$firephp = self::Instance()->getInstance(true);
	    	$firephp->setLogToInsightConsole('Firebug');
	    }else{
	    	$firephp = self::Instance()->getInstance(false);
	    }
	    return $firephp;
	}
	protected function is_assoc($array) {
    	return (is_array($array) && 0 !== count(array_diff_key($array, array_keys(array_keys($array)))));
  	}
   /**
   * Get options from the library
   *
   * @return array The currently set options
   */
  	public static function getOptions() {
  		return self::Instance()->getOptions();
  	}
  	/**
   * Set some options for the library
   * 
   * Options:
   *  - maxObjectDepth: The maximum depth to traverse objects (default: 10)
   *  - maxArrayDepth: The maximum depth to traverse arrays (default: 20)
   *  - useNativeJsonEncode: If true will use json_encode() (default: true)
   *  - includeLineNumbers: If true will include line numbers and filenames (default: true)
   * 
   * @param $maxObjectDepth
   * @param $maxArrayDepth
   * @param $useNativeJsonEncode
   * @param $includeLineNumbers
   * @return void
   */
  	public static function set_options($maxObjectDepth=10,$maxArrayDepth=20,$useNativeJsonEncode=true,$includeLineNumbers=true){
  		$tabs = array('maxObjectDepth' => $maxObjectDepth,
                 'maxArrayDepth' => $maxArrayDepth,
                 'useNativeJsonEncode' => $useNativeJsonEncode,
                 'includeLineNumbers' => $includeLineNumbers);
  		return self::Instance()->setOptions($tabs);
  	}
  /**
   * Specify a filter to be used when encoding an object
   * 
   * Filters are used to exclude object members.
   * 
   * @param string $Class The class name of the object
   * @param array $Filter An array of members to exclude
   * @return void
   * exemple : magixcjquery_debug_magixfire::setObjectFilter('ClassName',
                           array('MemberName'));
   */
  	public static function setObjectFilter($Class, $Filter){
  		return self::Instance()->setObjectFilter($Class, $Filter);
  	}
	/**
	 * function configErrorHandler
	 * Ini send Convert E_WARNING, E_NOTICE, E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE 
	 * and E_RECOVERABLE_ERROR to Firebug automatically.
	 * exemple in config application :
	 * magixcjquery_debug_firephp::configErrorHandler();
	 * try {
	 * throw new Exception('Test Exception');
	 * catch(Exception $e) {
	        magixcjquery_debug_magixfire::magixFireError($e);
		}
	 * 
	 */
  	public static function configErrorHandler(){
  		if (M_FIREPHP){
  			// converts errors into exceptions
  			self::Instance()->registerErrorHandler($throwErrorExceptions=true);
  			// makes FirePHP handle exceptions and sends it to FirePHP
  			self::Instance()->registerExceptionHandler();
  			self::Instance()->registerAssertionHandler(
	  			$convertAssertionErrorsToExceptions=true,
	  			$throwAssertionExceptions=false
  			);
  		}
  	}
  	/**
  	 * 
  	 * Log object with label to firebug console
  	 * 
     * @param mixes $Object
     * @param string $Label
  	 */
  	public static function magixFireLog($object,$label=false){
  		if(self::getIniInstance()){
  			return self::Instance()->log($object,$label);
  		}
  	}
	/**
  	 * 
  	 * Log object with label to firebug console
  	 * 
  	 * @param void $object
  	 * @param string $label
  	 */
	public static function magixFireInfo($object,$label=false){
  		if(self::getIniInstance()){
  			return self::Instance()->info($object,$label);
  		}
  	}
	/**
  	 * 
  	 * Log object with label to firebug console
  	 * 
  	 * @param void $object
  	 * @param string $label
  	 */
	public static function magixFireError($object,$label=false){
  		if(self::getIniInstance()){
  			return self::Instance()->error($object,$label);
  		}
  	}
	/**
  	 * 
  	 * Log object with label to firebug console
  	 * 
  	 * @param void $object
  	 * @param string $label
  	 */
	public static function magixFireWarn($object,$label=false){
  		if(self::getIniInstance()){
  			return self::Instance()->warn($object,$label);
  		}
  	}
	/**
  	 * Start a group for following messages.
  	 * 
  	 * @param void $object
  	 * @param string $label
  	 * @return true
   	 * @throws Exception	
  	 */
	public static function magixFireGroup($object,$label=false){
  		if(self::getIniInstance()){
  			return self::Instance()->group($object,$label);
  		}
  	}
  /**
   * Ends a group you have started before
   *
   * @return true
   * @throws Exception
   */
	public static function magixFireGroupEnd(){
  		if(self::getIniInstance()){
  			return self::Instance()->groupEnd();
  		}
  	}
	/**
  	 * Dumps key and variable to firebug server panel
  	 * @return true
   	 * @throws Exception
  	 * @param void $object
  	 * @param void $vars
  	 * @param string $label(false)
  	 */
	public static function magixFireDump($object,$vars,$label=false){
  		if(self::getIniInstance()){
  			if (!is_array($vars)) {
  				self::magixFireLog("vardump: ".$object.'=>'.$vars,$label);
  			}else {
				self::magixFireGroup("vardump: ".$object." (associative array)");
				if (self::is_assoc($vars)) {
					self::magixFireLog("(");
					foreach($vars as $var=>$value) {
						self::magixFireLog("['".$var."'] => ".$value);
					}
				}else {
					self::magixFireLog("(");
					foreach($vars as $var) {
						self::magixFireLog($var);
					}
				}
				self::magixFireLog(")");
				self::magixFireGroupEnd();
	        }
  		}
  	}
  	/**
   * Log a table in the firebug console
   *
   * @see magixcjquery_debug_magixfire::magixFireTable
   * @param string $Label
   * @param string $Table
   * @return true
   * @throws Exception
   * @example
   * $table   = array();
   * $table[] = array('Col 1 Heading','Col 2 Heading');
   * $table[] = array('Row 1 Col 1','Row 1 Col 2');
   * $table[] = array('Row 2 Col 1','Row 2 Col 2');
   * $table[] = array('Row 3 Col 1','Row 3 Col 2');
   */
  	public static function magixFireTable($label,$table){
  		if(self::getIniInstance()){
  			return self::Instance()->table($label, $table);
  		}
  	}
  	/**
   * Log a trace in the firebug console
   *
   * @see magixcjquery_debug_magixfire::TRACE
   * @param string $Label
   * @return true
   * @throws Exception
   */
  	public static function magixFireTrace($label){
  		if(self::getIniInstance()){
  			return self::Instance()->trace($label);
  		}
  	}
	/**
	 * start Current Unix timestamp with microseconds
	 * @access protected
	 * 
	*/
	protected static function timeStart(){
	  	if(self::getIniInstance()){
		    self::$timerStart = microtime();
		    self::$timerEnd = 0;
	  	}
	  }
	/**
	 * Stop Current Unix timestamp with microseconds
	 * @access protected
	*/
	protected static function timeStop(){
	  	if(self::getIniInstance()){
	    	self::$timerEnd =microtime();
	  	}
	  }
  	/**
  	 * @see timeStart calculation with microtime
  	 * @access public
  	 */
  	public static function MagixTimerStart(){
  		if(self::getIniInstance()){
  			return self::timeStart();
  		}
  	}
  	/**
  	 * @see timeStop calculation end microtime
  	 * @access public
  	 */
	public static function MagixTimerStop(){
		if(self::getIniInstance()){
  			return self::timeStop();
		}
  	}
	/**
	 * @see calculation for execute start and stop
	 * @access protected
	 */
	  protected static function getResultCalculation(){
	    if(self::$timerEnd == 0) self::MagixTimerStop();
	      return self::$timerEnd - self::$timerStart;
	  }
  	/**
  	 * return result where Timerget 
  	 * @see getResultCalculation
  	 * @access public
  	 */
  	public static function MagixTimerResult(){
  		return self::magixFireLog("execution time :". self::getResultCalculation() . ' seconds');
  	}
}
?>