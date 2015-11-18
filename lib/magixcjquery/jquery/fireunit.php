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
 * @copyright magixcjquery AND clashdesign
 * @version 0.1
 * @package fireunit
 *
 */
class magixcjquery_jquery_fireunit extends magixcjquery_jquery_params{
	/**
	 * test if fireunit is defined and typeof object
	 *
	 * @return void
	 */
	public static function iniTest(){
		return 'if(typeof fireunit == "undefined" && typeof fireunit !== "object"){return false;}';
	}
	/**
	 * function execute fireunit.ok(true/false, string)
	 *
	 * @param void $return
	 * @return string
	 */
	public static function ok($return,$string){
		$ok = 'fireunit.ok( ';
		$ok .= $return ? 'true':'false';
		$ok .= ','.$string.' );';
		return $ok;
	}
	/**
	 * function compare string
	 * shows a diff of the results if they're different
	 *
	 * @param void $array_str
	 * @return string
	 */
	public static function compare($str1,$str2,$callback){
		return 'fireunit.compare('.$str1.','.$str2.','.$callback.');';
	}
	/**
	 * function recompare string
	 * shows a diff of the results if they're different
	 *
	 * @param void $array_str
	 * @return string
	 */
	public static function reCompare($str1,$str2,$callback){
		return 'fireunit.reCompare('.$str1.','.$str2.','.$callback.');';
	}
	/**
	 * function browserEvent
	 *
	 * @param string $event
	 * @param string $selector
	 * @return void
	 * 
	 * example : 
	 * var input : $(":input")
	 * fireunit.mouseDown(input);
	 */
	public static function browserEvent($event,$selector){
		return 'fireunit.'.$event.'('.'$('.$selector.')'.');';
	}
	/**
	 * forecHttp
	 *
	 * @param void $callback
	 * @return void
	 */
	public static function forceHttp($callback){
		return 'fireunit.forceHttp(){'.$callback.'}';
	}
	/**
	 * run multiple pages of tests:
	 *
	 * @param array() $tpages
	 * @return string
	 */
	public static function runTests($tpages){
		return 'fireunit.runTests('.parent::forSimpleValue($tpages).');';
	}
	/**
	 * Place at the end of every test file in order to continue
	 *
	 * @return string
	 */
	public static function testDone(){
		return 'setTimeout(function(){fireunit.testDone()}, 1000);';
	}
}
?>