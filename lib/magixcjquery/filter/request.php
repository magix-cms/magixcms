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
 * @package Filter Request
 *
 */
class magixcjquery_filter_request{
	/**
	 * Checks if variable of POST type exists
	 *
	 * @param bool $str
	 * @return bool
	 */
	public static function isPost($str){
		if (version_compare(phpversion(), '5.2.0', '<')) {
			return isset($_POST[$str]) ? true : false;
		}else{
			return filter_has_var(INPUT_POST, $str) ? true : false;
		}
	}
	/**
	 * Checks if variable of GET type exists
	 *
	 * @param bool $str
	 * @return bool
	 */
	public static function isGet($str){
		if (version_compare(phpversion(), '5.2.0', '<')) {
			return isset($_GET[$str]) ? true : false;
		}else{
			return filter_has_var(INPUT_GET, $str) ? true : false;
		}
	}
	/**
	 * Checks if variable of REQUEST type exists
	 *
	 * @param bool $str
	 * @return bool
	 */
	public static function isRequest($str){
		if (version_compare(phpversion(), '5.2.0', '<')) {
			return isset($_REQUEST[$str]) ? true : false;
		}else{
			return filter_has_var(INPUT_REQUEST, $str) ? true : false;
		}
	}
	/**
	 * Checks if variable of SESSION type exists
	 *
	 * @param bool $str
	 * @return bool
	 */
	public static function isSession($str){
		if (version_compare(phpversion(), '5.2.0', '<')) {
			return isset($_SESSION[$str]) ? true : false;
		}else{
			return isset($_SESSION[$str]) ? true : false;
			//return filter_has_var(INPUT_SESSION, $str) ? true : false;
			//note : INPUT_SESSION not implemented for the moment
		}
	}
	/**
	 * Checks if variable of SERVER type exists
	 *
	 * @param bool $str
	 * @return bool
	 */
	public static function isServer($str){
		if (version_compare(phpversion(), '5.2.0', '<')) {
			return isset($_SERVER[$str]) ? true : false;
		}else{
			return filter_has_var(INPUT_SERVER, $str) ? true : false;
		}
	}
}
?>