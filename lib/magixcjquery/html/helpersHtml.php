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
 * @package HTML
 *
 */
class magixcjquery_html_helpersHtml{
	/**
	 * replace baskslash separator
	 * function unixSeparator
	 * @return string
	 */
	public static function unixSeparator(){
		if (DIRECTORY_SEPARATOR == '\\') {
			$str = str_replace('\\','/',DIRECTORY_SEPARATOR);
		}else{
			$str = DIRECTORY_SEPARATOR;
		}
		return $str;
	}
	/**
	 * replace slash separator
	 * windowsSeparator
	 * @return string
	 */
	public static function windowsSeparator(){
		if (DIRECTORY_SEPARATOR == '/') {
			$str = str_replace('/','\\',DIRECTORY_SEPARATOR);
		}else{
			$str = DIRECTORY_SEPARATOR;
		}
		return $str;
	}
	/**
	 * convert text in ASCII
	 *
	 * @param string $str
	 * @return string
	 */
	 public static function convertASCII($str){
    	return ord($str);
    }
    /**
	 * decode text in ASCII
	 *
	 * @param string $str
	 * @return string
	 */
    public static function decodeASCII($str){
    	return chr($str);
    }
	/**
	* Decode HTML entities
	*
	* Returns a string with all entities decoded.
	*
	* @param string	$str			String to protect
	* @param string	$keep_special	Keep special characters: &gt; &lt; &amp;
	* @return	string
	*/
	public static function decodeEntities($str,$keep_special=false)
	{
		if ($keep_special) {
			$str = str_replace(
				array('&amp;','&gt;','&lt;'),
				array('&amp;amp;','&amp;gt;','&amp;lt;'),
				$str);
		}
		
		# Some extra replacements
		$extra = array(
			'&apos;' => "'"
		);
		
		$str = str_replace(array_keys($extra),array_values($extra),$str);
		
		return html_entity_decode($str,ENT_QUOTES,'UTF-8');
	}
	/**
	 * function encode entities HTML
	 *
	 * @param string $str
	 * @param void $keep_special
	 * @return string
	 */
	public static function encodeEntities($str,$keep_special=false){
		if ($keep_special) {
			$str = str_replace(
				array('&','<','</','>'),
				array('&amp;', '&lt;','&lt;/','&gt;'),
				$str);
		}
		
		# Some extra replacements
		$extra = array(
			"'" => '&apos;'
		);
		
		$str = str_replace(array_keys($extra),array_values($extra),$str);
		
		return $str;
		//return filter_var($str, FILTER_SANITIZE_SPECIAL_CHARS,FILTER_FLAG_ENCODE_HIGH);
		//return htmlspecialchars($str,ENT_QUOTES, 'UTF-8');
	}
	/**
	* URL escape
	*
	* Returns an escaped URL string for HTML content
	*
	* @param string	$str		String to escape
	* @return	string
	*/
	public static function escapeURL($str){
		return str_replace('&','&amp;',$str);
	}
	/**
	* Javascript escape
	*
	* Returns a protected JavaScript string
	*
	* @param string	$str		String to protect
	* @return	string
	*/
	public static function escapeJS($str){
		$str = htmlspecialchars($str,ENT_NOQUOTES,'UTF-8');
		$str = str_replace("'","\"",$str);
		$str = str_replace('"','\"',$str);
		return $str;
	}
	/**
	* Remove host in URL
	*
	* Removes host part in URL
	*
	* @param string	$str		URL to transform
	* @return	string
	*/
	public static function stripHostURL($url)
	{
		return preg_replace('|^[a-z]{3,}://.*?(/.*$)|','$1',$url);
	}
	/**
	 *
	 * @get the full url of page
	 *
	 * @return string
	 *
	 */
	public static function getUrl($file=false,$absolute=true){
	    /*** check for https ***/
	    $protocol = isset($_SERVER['HTTPS']) == 'on' ? 'https' : 'http';
	    if($file){
	    	$source = '://';
		    $source .= $_SERVER['HTTP_HOST'];
		    $source .= $_SERVER['REQUEST_URI'];
	    }else{
		    $source = '://';
		    $source .= $_SERVER['HTTP_HOST'];
	    }
	     if ($absolute){
	     	/*** return the full address ***/
			$path = $protocol.$source;
	     }else{
	     	/*** return / ***/
	     	//if (substr($path, 0, 1) != '/'){
	     	//$path = '/';
	     	//}
	     	$path = '';
	     }
	    
	    return $path;
 	}
}
?>