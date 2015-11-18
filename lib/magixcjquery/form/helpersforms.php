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
 * @package FORM HELPERS
 *
 */
class magixcjquery_form_helpersforms{
	/**
	 * Combine function trim and escapeHTML for input
	 *
	 * @param string $str
	 * @return string
	 */
	public static function inputClean($str){
		return magixcjquery_filter_var::trimText(magixcjquery_filter_var::escapeHTML($str));
	}
	/**
	 * Combine function trim and Extreme escapeHTML for input
	 *
	 * @param string $str
	 * @return string
	 */
	public static function inputExtremeClean($str){
		return magixcjquery_filter_var::trimText(magixcjquery_filter_var::escapeExtremeHTML($str));
	}
	/**
	 * Combine function trim and strip_tag for input
	 *
	 * @param string $str
	 * @return string
	 */
	public static function inputTagClean($str){
		return magixcjquery_filter_var::trimText(magixcjquery_filter_var::clean($str));
	}
	/**
	 * Conbine function trim and rplMagixString
	 * 
	 * @param string $str
	 * @return string
	 */
	public static function inputRewriteUrl($str){
		return magixcjquery_filter_var::trimText(magixcjquery_url_clean::rplMagixString($str));
	}
	/**
	 * Conbine function trim and Clean Quote
	 *
	 * @param string $str
	 * @return string
	 */
	public static function inputCleanQuote($str){
		return magixcjquery_filter_var::trimText(magixcjquery_filter_var::cleanQuote($str));
	}
	/**
	 * Combine function trim and escapeHTML and downTextCase for input
	 *
	 * @param string $str
	 * @return string
	 */
	public static function inputCleanStrolower($str){
		return magixcjquery_filter_var::trimText(magixcjquery_filter_var::escapeHTML(magixcjquery_string_convert::downTextCase($str)));
	}
	/**
	 * Combine function trimText and cleanTruncate for input
	 * @param string $str
	 * @param intégrer $lg_max
	 * @param string $delimiter
	 */
	public static function inputCleanTruncate($str,$lg_max,$delimiter){
		return magixcjquery_filter_var::trimText(magixcjquery_string_convert::cleanTruncate($str,$lg_max,$delimiter));
	}
	/**
	 * Combine function trimText and isPostAlphaNumeric for input
	 * @param string $str
	 * 
	 */
	public static function inputAlphaNumeric($str){
		return magixcjquery_filter_var::trimText(magixcjquery_filter_isVar::isPostAlphaNumeric($str));
	}
	/**
	 * Combine function trimText and isPostNumeric for input
	 * @param string $str
	 * 
	 */
	public static function inputNumeric($str){
		return magixcjquery_filter_var::trimText(magixcjquery_filter_isVar::isPostNumeric($str));
	}
	/**
	 * Special function for clean array
	 *
	 * @param string $array
	 * @return string
	 */
	public static function arrayClean($array){
		foreach($array as $key => $val) {
		    if (!is_array($array[$key])) {
		    	$array[$key] = self::inputClean($val);
		    }
	    	else{
	    		$array[$key] = self::arrayClean($array[$key]);
	    		//$array[$key] = self::inputClean($array[$key]);
	    	}
	    }
   		return $array;
	}
	/**
	 * Special function for extreme clean array
	 *
	 * @param string $array
	 * @return string
	 */
	public static function arrayExtremeClean($array){
		foreach($array as $key => $val) {
		    if (!is_array($array[$key])) {
		    	$array[$key] = self::inputExtremeClean($val);
		    }
	    	else{
	    		$array[$key] = self::arrayClean($array[$key]);
	    	}
	    }
   		return $array;
	}
}