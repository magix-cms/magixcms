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
 * @package Is Filter Var
 *
 */
class magixcjquery_filter_isVar{
	/**
	 * Constante for URL format
	 * @var void
	 */
	const REGEX_URL_FORMAT = '~^(https?|ftps?)://   # protocol
      (([a-z0-9-]+\.)+[a-z]{2,6}              		# a domain name
          |                                   		#  or
        \d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}    		# a IP address
      )
      (:[0-9]+)?                              		# a port (optional)
      (/?|/\S+)                               		# a /, nothing or a / with something
    $~ix';
	/**
	 * function isEmpty
	 *
	 * @param string $val
	 * @return false
	 */
	public static function isEmpty($val){
		$val = magixcjquery_filter_var::trimText($val);
		return empty($val) && $val !== 0;
	}
	/**
	 * function isURL
	 * is Valide URL
	 *
	 * @param bool $url
	 * @return bool
	 */
	public static function isURL($url){
		/*filter_var($url, FILTER_VALIDATE_URL);//FILTER_FLAG_SCHEME_REQUIRED
		return $url;*/
		//String
		$clean = (string) $url;
		if($url != ''){
		    if (!preg_match(self::REGEX_URL_FORMAT, $clean)){
		    	//Generate exception
		      throw new Exception('Invalid URL: '.$url);
		    }
		}
	    return $clean;
	}
	/**
	 * function isMail
	 *
	 * @param bool $mail
	 * @return bool
	 */
	public static function isMail($mail){
		return filter_var($mail, FILTER_VALIDATE_EMAIL) ? $mail : false;
	}
	/**
	 * Checks if variable of Numeric
	 *
	 * @param bool $str
	 * @return bool
	 */
	public static function isPostNumeric($str){
		return (integer) ctype_digit($str) ? $str : false;
	}
	/**
	 * Checks if variable of Float
	 *
	 * @param bool $str
	 * @return bool
	 */
	public static function isPostFloat($str){
		return filter_var($str, FILTER_VALIDATE_FLOAT) ? $str : false;
	}
	/**
	 * Checks if variable of Integer
	 *
	 * @param bool $str
	 * @return bool
	 */
	public static function isPostInt($str){
		return filter_var($str,FILTER_VALIDATE_INT) ? $str : false;
	}
	/**
	 * Checks if variable of String
	 *
	 * @param bool $str
	 * @return bool
	 */
	public static function isPostAlpha($str){
			return (string) ctype_alpha($str) ? $str : false;
	}
	/**
	 * Checks if variable of alphanumeric
	 *
	 * @param bool $str
	 * @return bool
	 */
	public static function isPostAlphaNumeric($str){
			return (string) ctype_alnum($str) ? $str : false;
	}
	/**
	 * Function pour vérifier la longueur minimal d'un texte
	 *
	 * @param string $getPost
	 * @param integer $size
	 * @return vars
	 */
	public static function sizeSmallString($getPost, $size){
		$small = strlen($getPost) < $size;
		return $small;
	}
	/**
	 * Function pour vérifier la longueur maximal d'un texte
	 *
	 * @param string $getPost
	 * @param integer $size
	 * @return vars
	 */
	public static function sizeLargestString($getPost, $size){
		$largest = strlen($getPost) > $size;
		return $largest;
	}
}
?>