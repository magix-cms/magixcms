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
/**
 * 
 * Magix cjQuery
 * 
 * @author Gérits Aurélien
 * @access public
 * @copyright clashdesign
 * @version 0.1
 * @package jQuery execute
 *
 */
class magixcjquery_jquery_magixcjQuery{
	/**
	 * jQuery no Conflict Mode
	 *
	 * @see	      http://docs.jquery.com/Using_jQuery_with_Other_Libraries
	 * @staticvar Boolean Status of noConflict Mode
	 */
    private static $noConflictMode = false;

	/**
	 * class jQuery execute
	 *
	 * @return jQuery execution
	 */
	/**
	 * function ini and load jQuery
	 *
	 * @return string
	 */
	public static function loadjQuery($source, $version){
		$jquery = '<script type="text/javascript" src="'.$source.'jquery-'.$version.'.min.js"></script>';
		if (self::noConflictMode() == true) {
			$jquery .= '<script type="text/javascript">var $j = jQuery.noConflict();</script>';
		}
		return $jquery;
	}
	/**
	 * function Start jQuery
	 *
	 * @param string $var
	 * @return string
	 */
	public static function startjQuery(){
		$jquery = '<script type="text/javascript">'."\n";
		$jquery .= self::getjQueryHandling().'(document).ready(function(){';
		return $jquery;
	}
	/**
	 * function Start jQuery
	 *
	 * @param string $var
	 * @return string
	 */
	public static function startFunction(){
		$jquery = '<script type="text/javascript">'."\n";
		$jquery .= '(function(){';
		return $jquery;
	}
	/**
	 * function End jQuery
	 *
	 * @return string
	 */
	public static function endjQuery(){
		$jquery = '})</script>';
		return $jquery;
	}
	/**
	 * function End jQuery
	 *
	 * @return string
	 */
	public static function endFunction(){
		$jquery = '})(jQuery);</script>';
		return $jquery;
	}
	
	/**
	 * Enable the jQuery internal noConflict Mode to work with
	 * other Javascript libraries. Will setup jQuery in the variable
	 * $j instead of $ to overcome conflicts.
	 *
	 * @link http://docs.jquery.com/Using_jQuery_with_Other_Libraries
	 */
    public static function enableNoConflict()
    {
    	self::$noConflictMode = true;
    }

	/**
	 * Disable noConflict of jQuery if this was previously enabled.
	 *
	 * @return void
	 */
    public static function disableNoConflict()
    {
    	self::$noConflictMode = false;
    }
	/**
	 * Return current status of the jQuery no Conflict
	 *
	 * @return Boolean
	 */
    public static function noConflictMode()
    {
    	return self::$noConflictMode;
    }
	/*public function noConflictMode(){
		$jquery = '<script type="text/javascript">var $j = jQuery.noConflict();</script>';
		return $jquery;
	}*/
	/**
	 * function redeclare start jquery but no conflict with Other Libraries
	 *
	 * @param string $var
	 * @return string
	 */
	public static function getjQueryHandling(){
        return ((self::noConflictMode()== true) ? '$j':'$');
	}
    /**
	 * function domUtils for DOM name or this
	 *
	 * @param string $var
	 * @return string
	 */
    public static function jQueryDom($seq,$dom,$thi=false){
    	
    	switch ($seq) {
    		
    		case 'this':
    			return $thi ? 'this,'.$dom : 'this' ;
    			break;
    		case 'dom';
    			return $dom;
    			break;
    	}
    }
	/**
	 * 
	 * exemple
	 * 
	 * 
	public function testjQuery(){
		$jquery = magixjQuery::startjQuery();
		$jquery .= '$("#test").text("test")';
		$jquery .= magixjQuery::endjQuery();
		return $jquery;
	}*/
}
?>