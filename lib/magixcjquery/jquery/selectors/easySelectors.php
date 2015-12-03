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
 * @copyright magixcjquery
 * @version 0.1
 * @package jQuery easySelectors
 *
 */
class magixcjquery_jquery_selectors_easySelectors {
	/**
	 * start Construct function jQuery
	 *
	 * @return string
	 */
	public static function startConstruct(){
		return magixcjquery_jquery_magixcjQuery::startFunction();
	}
	/**
	 * end construct function (jQuery)
	 *
	 * @return string
	 */
	public static function EndConstruct(){
		return magixcjquery_jquery_magixcjQuery::endFunction();
	}
	/**
	 * Parent magixUtilities (extend)
	 * Extend one object with one or more others, returning the modified object.
	 *
	 * @param boolean $deep
	 * @param object $target
	 * @param object $object1
	 * @param object $objectN
	 * @return object
	 */
	public static function extend($deep=false,$target, $object1, $objectN=false){
		return magixcjquery_jquery_utilities::extend($deep=false,$target, $object1, $objectN=false);
	}
	/**
	 * function ini Selector for easy implement selector
	 *
	 * @return string
	 */
	public static function iniSelector(){
		return magixcjquery_jquery_magixcjQuery::getjQueryHandling().'.easySelector = function() {
       if(!arguments) { return; }';
	}
	/**
	 * selector expression define
	 *
	 * @return string
	 */
	public static function expr(){
		return 
		self::extend(false,
		magixcjquery_jquery_utilities::expr('":"'),',typeof(arguments[0])==="object" ? arguments[0] : (function(){
             var newOb = {}; no[arguments[0]] = arguments[1];
             return newOb;
	         })()
	       ').'}';
	}
	/**
	 * function implement new easySelector
	 *
	 * @return string
	 */
	public static function iniJeasySelectors(){
		return 
		self::startConstruct().magixcjquery_jquery_jsmin_minify::mjsMin(self::iniSelector().self::expr()).self::EndConstruct();
	}
	/**
	 * utilities easyselector Simple function
	 *
	 * @param string $name
	 * @param void $function
	 * @return string
	 */
	public static function easySimpleConstruct($name,$function){
		return magixcjquery_jquery_magixcjQuery::getjQueryHandling().'.easySelector("'.$name.'",'.$function.');';
	}
	/**
	 * utilities easyselector Multiple function
	 *
	 * @param array $array
	 * @return string
	 */
	public static function easyMultConstruct($array){
		return magixcjquery_jquery_magixcjQuery::getjQueryHandling().'.easySelector({'.
		magixcjquery_jquery_params::forSpecialOptions($array).'});';
	}
}