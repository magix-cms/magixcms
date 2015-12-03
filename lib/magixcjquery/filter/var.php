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
 * @package Filter Var
 *
 */
class magixcjquery_filter_var{
	/**
	 * function trim text function
	 *
	 * @param string $str
	 * @return string
	 */
	public static function trimText($str){
		return trim($str);
	}
		/**
	* Remove markup
	*
	* Removes every tags, comments, cdata from string
	*
	* @param string	$str		String to clean
	* @return	string
	*/
	public static function clean($str)
	{
		$str = strip_tags($str);
		return $str;
	}
	/**
	* HTML escape
	*
	* Replaces HTML special characters by entities.
	*
	* @param string $str	String to escape
	* @return	string
	*/
	public static function escapeHTML($str)
	{
		return htmlspecialchars($str,ENT_COMPAT,'UTF-8');
	}
	/**
	* HTML Extreme escape
	*
	* Replaces HTML characters by entities.
	*
	* @param string $str	String to escape
	* @return	string
	*/
	public static function escapeExtremeHTML($str)
	{
		return htmlentities($str,ENT_COMPAT,'UTF-8');
	}
	/**
	 * decode Extreme htmlentities
	 *
	 * @param string $str
	 * @return string
	 */
    public static function decodeExtremeHTML($str){
    	return html_entity_decode($str,ENT_COMPAT,'UTF-8');
    }
    /**
	 * function pour supprimer les antislash
	 *
	 * @param string $string
	 * @return string
	 */
	public static function cleanQuote($string){
			return stripcslashes($string);
	}
/**
	 * function pour ajouter des antislash
	 *
	 * @param string $string
	 * @return string
	 */
	public static function magicQuote($string){
		if (version_compare(phpversion(), '5.2.0', '<')) {
			return addslashes($string);
		}else{
			return filter_var($string, FILTER_SANITIZE_MAGIC_QUOTES);
		}
	}
    /**
     * removes all illegal e-mail characters from a string.
     * This filter allows all letters, digits and $-_.+!*'{}|^~[]`#%/?@&=
     *
     * @param string $mail
     * @return string
     */
    public static function sanitizeMail($mail){
    	return filter_var($mail, FILTER_SANITIZE_EMAIL);
    }
    /**
	* URL sanitize
	*
	* Encode every parts between / in url
	*
	* @param string	$str		String to sanitize
	* @return	string
	*/
	public static function sanitizeURL($str){
		if (version_compare(phpversion(), '5.2.0', '<')) {
			return str_replace('%2F','/',rawurlencode($str));
		}else {
			return filter_var($str, FILTER_SANITIZE_URL);
		}
	}
	/**
	* URL  revert sanitize
	*
	* Decode every parts between / in url
	*
	* @param string	$str		String to sanitize
	* @return	string
	*/
	public static function revertSanitizeURL($str)
	{
		return rawurldecode($str);
	}
	/**
	 * filter removes all illegal characters from a number.
	 * This filter allows digits and . + -
	 *
	 * @param string $str
	 * @return string
	 */
	public static function sanitizeNumeric($str)
	{
		return filter_var($str, FILTER_SANITIZE_NUMBER_INT);
	}
	/**
	 * filter removes all illegal characters from a float number.
	 * This filter allows digits and + - by default
	 *
	 * @param string $str
	 * @return string
	 */
	public static function sanitizeFloat($str,$flag)
	{
		switch ($flag) {
			case 'fraction':
				$flag = FILTER_FLAG_ALLOW_FRACTION;
				break;
			case 'thousand':
				$flag = FILTER_FLAG_ALLOW_THOUSAND;
				break;
			case 'scientific':
				$flag = FILTER_FLAG_ALLOW_SCIENTIFIC;
				break;
		}
		return filter_var($str, FILTER_SANITIZE_NUMBER_FLOAT,$flag);
	}
/**
	 * funtion intval —  Retourne la valeur numérique entière équivalente d'une variable 
	 * @param $int
	 * @return Get the integer value of a variable
	 */
	public static function intval($int){
		return intval($int);
	}
}