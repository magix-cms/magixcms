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
 * @package Convert String
 *
 */
class magixcjquery_string_convert{
	/**
	 * function lowerCase Text
	 *
	 * @param string $str
	 */
	public static function upTextCase($str){
		
		if (function_exists("mb_strtoupper")) {
			if (mb_detect_encoding($str,"utf-8") == "utf-8") {
				$str = mb_strtoupper($str,'utf-8');
			}
			elseif(mb_detect_encoding($str, "ISO-8859-1")){
				$str = mb_strtoupper($str, "ISO-8859-1");
			}
		}else{
			$str = strtoupper($str);
		}
		return $str;
	}
	/**
	 * function UpperCase Text
	 *
	 * @param string $str
	 */
	public static function downTextCase($str){
		
		if (function_exists("mb_strtolower")) {
			if (mb_detect_encoding($str,"UTF-8") == "UTF-8") {
				$str = mb_strtolower($str,'UTF-8');
			}elseif(mb_detect_encoding($str, "ISO-8859-1")){
				$str = mb_strtolower($str,'ISO-8859-1');
			}
		}else{
			$str = strtolower($str);
		}
		return $str;
	}
	/**
	 * Function ramdom string with choose number characters
	 *
	 * @param intéger $nbCarMax
	 * @param string $special
	 * @return string
	 */
	public static function passTextGenerator($nbCarMax,$special=false){
	    //Caractères autorisés : On retire 0, O, I, 1 et l pour éviter les confusions
	    $alpha = "abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ";
	    $numeric = "23456789";
	    //Caractères spéciaux autorisés
	    $special = $special ? "-_." :"";
	    $chaine = $alpha.$numeric.$special;
	    $pass = "";
	    for($i =0; $i < $nbCarMax; $i++) {
		if ($i==0) $maxChars = strlen($alpha);
	       else $maxChars = strlen($chaine);
	        // on choisie un nombre au hasard entre 0 et le nombre de caractères de la chaine
	        $nb = mt_rand(0,($maxChars -1));
	        // on ajoute la lettre a la valeur de $pass
	        $pass.=$chaine[$nb];
	    }
	    return $pass;
	}
	/**
	* Password generator
	*
	* Returns an 8 characters random password.
	*
	* @todo Add a length param
	*
	* @return	string
	*/
	public static function string_generator()
	{
		$pwd = array();
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$chars2 = '$!@';
		
		foreach (range(0,8) as $i) {
			$pwd[] = $chars[rand(0,strlen($chars)-1)];
		}
		
		$pos1 = array_rand(array(0,1,2,3));
		$pos2 = array_rand(array(4,5,6,7));
		$pwd[$pos1] = $chars2[rand(0,strlen($chars2)-1)];
		$pwd[$pos2] = $chars2[rand(0,strlen($chars2)-1)];
		
		return implode('',$pwd);
	}
	/**
	 * @access public
	 * @static
	 * Create short IDs with PHP
	 * @param string $in
	 * @param bool $to_num
	 * @param bool $pad_up
	 * @param string $passKey
	 */
	public static function alphaID($in, $to_num = false, $pad_up = false, $passKey = null){
		  $index = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		  if ($passKey !== null) {
		    for ($n = 0; $n<strlen($index); $n++) {
		      $i[] = substr( $index,$n ,1);
		    }
		    $passhash = hash('sha256',$passKey);
		    $passhash = (strlen($passhash) < strlen($index))
		      ? hash('sha512',$passKey)
		      : $passhash;
		 
		    for ($n=0; $n < strlen($index); $n++) {
		      $p[] =  substr($passhash, $n ,1);
		    }
		    array_multisort($p,  SORT_DESC, $i);
		    $index = implode($i);
		  }
		 
		  $base  = strlen($index);
		 
		  if ($to_num) {
		    // Digital number  <<--  alphabet letter code
		    $in  = strrev($in);
		    $out = 0;
		    $len = strlen($in) - 1;
		    for ($t = 0; $t <= $len; $t++) {
		      $bcpow = bcpow($base, $len - $t);
		      $out   = $out + strpos($index, substr($in, $t, 1)) * $bcpow;
		    }
		    if (is_numeric($pad_up)) {
		      $pad_up--;
		      if ($pad_up > 0) {
		        $out -= pow($base, $pad_up);
		      }
		    }
		    $out = sprintf('%F', $out);
		    $out = substr($out, 0, strpos($out, '.'));
		  } else {
		    // Digital number  -->>  alphabet letter code
		    if (is_numeric($pad_up)) {
		      $pad_up--;
		      if ($pad_up > 0) {
		        $in += pow($base, $pad_up);
		      }
		    }
		    $out = "";
		    for ($t = floor(log($in, $base)); $t >= 0; $t--) {
		      $bcp = bcpow($base, $t);
		      $a   = floor($in / $bcp) % $base;
		      $out = $out . substr($index, $a, 1);
		      $in  = $in - ($a * $bcp);
		    }
		    $out = strrev($out); // reverse
		  }
		  return $out;
	}
	/**
	 * @access public
	 * @static
	 * Générer des identifiants unique avec PHP style Youtube
	 * @param string $numStr
	 */
	public static function short_unique_id($numStr){
		srand( (double)microtime()*rand(1000000,9999999) ); // Genere un nombre aléatoire
		$arrChar = array(); // Nouveau tableau
		for( $i=65; $i<90; $i++ ) {
			array_push( $arrChar, chr($i) ); // Ajoute A-Z au tableau
			array_push( $arrChar, strtolower( chr( $i ) ) ); // Ajouter a-z au tableau
		}
		for( $i=48; $i<57; $i++ ) {
			array_push( $arrChar, chr( $i ) ); // Ajoute 0-9 au tableau
		}
		$uId = '';
		for( $i=0; $i< $numStr; $i++ ) {
			$uId .= $arrChar[rand( 0, count( $arrChar ) )]; // Ecrit un aléatoire
		}
		return $uId;
	}
	/**
     *
     * @Utf8_decode
     *
     * @Replace accented chars with latin
     *
     * @param string $string The string to convert
     *
     * @return string The corrected string
     *
     */
    function decode_utf8($string)
    {
        $accented = array(
            'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ă', 'Ą',
            'Ç', 'Ć', 'Č', 'Œ',
            'Ď', 'Đ',
            'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ă', 'ą',
            'ç', 'ć', 'č', 'œ',
            'ď', 'đ',
            'È', 'É', 'Ê', 'Ë', 'Ę', 'Ě',
            'Ğ',
            'Ì', 'Í', 'Î', 'Ï', 'İ',
            'Ĺ', 'Ľ', 'Ł',
            'è', 'é', 'ê', 'ë', 'ę', 'ě',
            'ğ',
            'ì', 'í', 'î', 'ï', 'ı',
            'ĺ', 'ľ', 'ł',
            'Ñ', 'Ń', 'Ň',
            'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ő',
            'Ŕ', 'Ř',
            'Ś', 'Ş', 'Š',
            'ñ', 'ń', 'ň',
            'ò', 'ó', 'ô', 'ö', 'ø', 'ő',
            'ŕ', 'ř',
            'ś', 'ş', 'š',
            'Ţ', 'Ť',
            'Ù', 'Ú', 'Û', 'Ų', 'Ü', 'Ů', 'Ű',
            'Ý', 'ß',
            'Ź', 'Ż', 'Ž',
            'ţ', 'ť',
            'ù', 'ú', 'û', 'ų', 'ü', 'ů', 'ű',
            'ý', 'ÿ',
            'ź', 'ż', 'ž',
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р',
            'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'р',
            'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
            'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'
            );

        $replace = array(
            'A', 'A', 'A', 'A', 'A', 'A', 'AE', 'A', 'A',
            'C', 'C', 'C', 'CE',
            'D', 'D',
            'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'a', 'a',
            'c', 'c', 'c', 'ce',
            'd', 'd',
            'E', 'E', 'E', 'E', 'E', 'E',
            'G',
            'I', 'I', 'I', 'I', 'I',
            'L', 'L', 'L',
            'e', 'e', 'e', 'e', 'e', 'e',
            'g',
            'i', 'i', 'i', 'i', 'i',
            'l', 'l', 'l',
            'N', 'N', 'N',
            'O', 'O', 'O', 'O', 'O', 'O', 'O',
            'R', 'R',
            'S', 'S', 'S',
            'n', 'n', 'n',
            'o', 'o', 'o', 'o', 'o', 'o',
            'r', 'r',
            's', 's', 's',
            'T', 'T',
            'U', 'U', 'U', 'U', 'U', 'U', 'U',
            'Y', 'Y',
            'Z', 'Z', 'Z',
            't', 't',
            'u', 'u', 'u', 'u', 'u', 'u', 'u',
            'y', 'y',
            'z', 'z', 'z',
            'A', 'B', 'B', 'r', 'A', 'E', 'E', 'X', '3', 'N', 'N', 'K', 'N', 'M', 'H', 'O', 'N', 'P',
            'a', 'b', 'b', 'r', 'a', 'e', 'e', 'x', '3', 'n', 'n', 'k', 'n', 'm', 'h', 'o', 'p',
            'C', 'T', 'Y', 'O', 'X', 'U', 'u', 'W', 'W', 'b', 'b', 'b', 'E', 'O', 'R',
            'c', 't', 'y', 'o', 'x', 'u', 'u', 'w', 'w', 'b', 'b', 'b', 'e', 'o', 'r'
            );

        return str_replace($accented, $replace, $string);
    }
    /**
	 * Convert first letters string in Uppercase
	 *
	 * @param $str
	 * @return string
	 */
	public static function ucFirst($str){
		$str = self::upTextCase(substr($str,0,1)).substr($str,1);
		return $str;
	}
	/**
	 * truncate string with clean delimiter
	 * Tronque une chaîne de caractères sans couper au milieu d'un mot
	 * @param $string
	 * @param $lg_max (length max)
	 * @param $delimiter (delimiter ...)
	 */
	public static function cleanTruncate($string,$lg_max,$delimiter){
		if(magixcjquery_filter_isVar::sizeLargestString($string,$lg_max)){
		    $string = substr($string, 0, $lg_max);
		    $last_space = strrpos($string, " ");  
		    $string = substr($string, 0, $last_space).$delimiter; 
		}
		return $string;
	}
}