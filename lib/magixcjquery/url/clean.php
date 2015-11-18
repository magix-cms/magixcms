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
 * @package URL
 *
 */
class magixcjquery_url_clean{
	/**function rplMagixString($params){
	        $params = magixConvertText::downTextCase($params);
			$params = str_replace("( |')", "-", $params);
			$accent = array('&','â','à','é','è','ê','î','ô','û','ç');
			$unaccented = array('and','a','a','e','e','e','i','o','u','c');
			$params = str_replace($accent, $unaccented, $params);
			$params = eregi_replace("[^a-z0-9]","-",$params);
			$params = eregi_replace("(^(_)*|(_)*$)","",$params);
			$params = eregi_replace("(.){2,3}","",$params);
		return $params;
	}**/
	/**
	 * Converti une URL pour une réécriture stricte suivant les paramètres choisi
	 * @param string $str
	 * @param array $option
	 * @throws Exception
	 * @return string
	 * @example:
	 * magixcjquery_url_clean::rplMagixString(
	 	'/public/test/truc-machin01/aussi/version-2.3.5/',
	 	array('dot'=>'display','ampersand'=>'strict','cspec'=>array('[\/]'),'rspec'=>array(''))
	 );
	 */
	public static function rplMagixString($str,$option = array('dot'=>false,'ampersand'=>'strict','cspec'=>'','rspec'=>'')){
	/**Clean accent*/
	$Caracs = array("¥" => "Y", "µ" => "u", "À" => "A", "Á" => "A",
                "Â" => "A", "Ã" => "A", "Ä" => "A", "Å" => "A",
                "Æ" => "A", "Ç" => "C", "È" => "E", "É" => "E",
                "Ê" => "E", "Ë" => "E", "Ì" => "I", "Í" => "I",
                "Î" => "I", "Ï" => "I", "Ð" => "D", "Ñ" => "N",
                "Ò" => "O", "Ó" => "O", "Ô" => "O", "Õ" => "O",
                "Ö" => "O", "Ø" => "O", "Ù" => "U", "Ú" => "U",
                "Û" => "U", "Ü" => "U", "Ý" => "Y", "ß" => "s",
                "à" => "a", "á" => "a", "â" => "a", "ã" => "a",
                "ä" => "a", "å" => "a", "æ" => "a", "ç" => "c",
                "è" => "e", "é" => "e", "ê" => "e", "ë" => "e",
                "ì" => "i", "í" => "i", "î" => "i", "ï" => "i",
                "ð" => "o", "ñ" => "n", "ò" => "o", "ó" => "o",
                "ô" => "o", "õ" => "o", "ö" => "o", "ø" => "o",
                "ù" => "u", "ú" => "u", "û" => "u", "ü" => "u",
                "ý" => "y", "ÿ" => "y");
     $str = strtr("$str", $Caracs);
     $str = magixcjquery_filter_var::trimText($str);
	 if(is_bool($option)){
	 	if($option != false){
	 		/*replace & => $amp (w3c convert)*/
	 		$str = str_replace('&','&amp;',$str);
	 		$str = str_replace('.','',$str);
	 	}
	 }elseif(is_array($option)){
	 	if(array_key_exists('dot', $option)){
	 		if($option['dot'] == 'none'){
	 			$str = str_replace('.','',$str);
	 		}
	 	}
	 	if(array_key_exists('ampersand', $option)){
	 		if($option['ampersand'] == 'strict'){
	 			/*replace & => $amp (w3c convert)*/
	 			$str = str_replace('&','&amp;',$str);
	 		}elseif($option['ampersand'] == 'none'){
	 			/*replace & => ''*/
	 			$str = str_replace('&','',$str);
	 		}else{
	 			/*replace & => $amp (w3c convert)*/
	 			$str = str_replace('&','&amp;',$str);
	 		}	
	 	}
	 }
	 /* stripcslashes backslash */
	 $str = magixcjquery_filter_var::cleanQuote($str);
	 $tbl_o = array("@'@i",'@[[:blank:]]@i','[\?]','[\#]','[\@]','[\,]','[\!]','[\:]','[\(]','[\)]');
	 $tbl_r = array ('-','-',"","","","","","","","");
	 $cSpec = '';
	 $rSpec = '';
	 if(is_array($option)){
	 	if(array_key_exists('cspec', $option) AND array_key_exists('rspec', $option)){
	 		if(is_array($option['cspec']) AND is_array($option['rspec'])){
	 			if($option['cspec'] != '' AND $option['rspec'] != ''){
	 				$cSpec = array_merge($tbl_o,$option['cspec']);
	 				$rSpec = array_merge($tbl_r,$option['rspec']);
	 			}else{
	 				throw new Exception('cspec or rspec option is NULL');
	 			}
	 		}else{
			 	/*replace blank and special caractère*/
			 	$cSpec = $tbl_o;
			 	$rSpec = $tbl_r;
	 		}
	 	}else{
		 	/*replace blank and special caractère*/
		 	$cSpec = $tbl_o;
		 	$rSpec = $tbl_r;
	 	}
	 }else{
	 	/*replace blank and special caractère*/
	 	$cSpec = $tbl_o;
	 	$rSpec = $tbl_r;
	 }
	 /*Removes the indent if end of string*/  
	 $str = rtrim(preg_replace($cSpec,$rSpec,$str),"-");
	 /*Convert UTF8 encode*/
	 $str = magixcjquery_string_convert::decode_utf8($str);
	 /*Convert lower case*/
	 $str = magixcjquery_string_convert::downTextCase($str);
     return $str;  
	}
	/**
	* URL cleanup
	*
	* @param string	$str URL to tidy
	* @param boolean	$keep_slashes	Keep slashes in URL
	* @param boolean	$keep_spaces	Keep spaces in URL
	* @return string
	*/
	public static function tidyMakeClean($str,$keep_slashes=true,$keep_spaces=false){
		$str = magixcjquery_filter_var::clean($str);
		$str = str_replace(array('?','&','#','=','+','<','>','"','%'),'',$str);
		$str = str_replace("'",' ',$str);
		$str = preg_replace('/[\s]+/',' ',magixcjquery_filter_var::trimText($str));
		if (!$keep_slashes) {
			$str = str_replace('/','-',$str);
		}
		if (!$keep_spaces) {
			$str = str_replace(' ','-',$str);
		}
		$str = preg_replace('/[-]+/','-',$str);
		# Remove path changes in URL
		$str = preg_replace('%^/%','',$str);
		$str = preg_replace('%\.+/%','',$str);
		
		return $str;
	}
	public static function make2tagString($str){
		/**Clean accent*/
		$Caracs = array("¥" => "Y", "µ" => "u", "À" => "A", "Á" => "A",
	                "Â" => "A", "Ã" => "A", "Ä" => "A", "Å" => "A",
	                "Æ" => "A", "Ç" => "C", "È" => "E", "É" => "E",
	                "Ê" => "E", "Ë" => "E", "Ì" => "I", "Í" => "I",
	                "Î" => "I", "Ï" => "I", "Ð" => "D", "Ñ" => "N",
	                "Ò" => "O", "Ó" => "O", "Ô" => "O", "Õ" => "O",
	                "Ö" => "O", "Ø" => "O", "Ù" => "U", "Ú" => "U",
	                "Û" => "U", "Ü" => "U", "Ý" => "Y", "ß" => "s",
	                "à" => "a", "á" => "a", "â" => "a", "ã" => "a",
	                "ä" => "a", "å" => "a", "æ" => "a", "ç" => "c",
	                "è" => "e", "é" => "e", "ê" => "e", "ë" => "e",
	                "ì" => "i", "í" => "i", "î" => "i", "ï" => "i",
	                "ð" => "o", "ñ" => "n", "ò" => "o", "ó" => "o",
	                "ô" => "o", "õ" => "o", "ö" => "o", "ø" => "o",
	                "ù" => "u", "ú" => "u", "û" => "u", "ü" => "u",
	                "ý" => "y", "ÿ" => "y");
	     $str = strtr("$str", $Caracs);
	     $str = magixcjquery_filter_var::trimText($str);
		 /* stripcslashes backslash */
		 $str = magixcjquery_filter_var::cleanQuote($str);
		 /*replace blank and special caractère*/
		 $cSpec = array("@'@i",'[\?]','[\#]','[\@]','[\,]','[\!]','[\:]','[\(]','[\)]');
		 $rSpec = array (" "," "," "," "," "," "," "," "," "); 
		 /*Removes the indent if end of string*/  
		 $str = rtrim(preg_replace($cSpec,$rSpec,$str),"");
		 /*Convert UTF8 encode*/
		 $str = magixcjquery_string_convert::decode_utf8($str);
		 /*Convert lower case*/
		 $str = magixcjquery_string_convert::downTextCase($str);
	    return $str;  
	}
}