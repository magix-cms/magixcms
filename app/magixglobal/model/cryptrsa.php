<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Magix CMS.
# Magix CMS, a CMS optimized for SEO
# Copyright (C) 2010 - 2011  Gerits Aurelien <aurelien@magix-cms.com>
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.

# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
# -- END LICENSE BLOCK -----------------------------------
/**
 * MAGIX CMS
 * @category   Model 
 * @package    magixglobal
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name cryptrsa
 *
 */
class magixglobal_model_cryptrsa{
	/**
	 * @static
	 * @access public 
	 * SHA1 HASH
	 */
	public static function hash_sha1($string){
		return sha1($string);
	}
	/**
	 * @static
	 * @access public 
	 * SHA1 HASH
	 */
	public static function hash_md5($string){
		return md5($string);
	}
	/**
	 * @static
	 * @access public 
	 * retourne un identifiant unique
	 */
	public static function uniq_id(){
		$id = uniqid(mt_rand(), true);
		return base_convert($id, 10, 36);
	}
	/**
	 * 
	 * Génération de token ou jeton
	 */
	public function tokenId(){
		return md5(session_id() . time() . $_SERVER['HTTP_USER_AGENT']);
	}
	/**
	 * Génération de micro id
	 * @return string
	 */
	public static function random_generic_ui() {
	    return sprintf('%04x%04x',
	      // 32 bits for "time_low"
	      mt_rand(0, 0xffff), mt_rand(0, 0xffff),
	      // 16 bits for "time_mid"
	      mt_rand(0, 0xffff),
	      // 48 bits for "node"
	      mt_rand(0, 0xffff)
	    );
	}
	/**
	 * Génération de pseudo ID aléatoire
	 * @return string
	 */
	public static function uuid_generator() {
	    return sprintf('%04x%04x%04x%04x%04x%04x%04x%04x',
	
	      // 32 bits for "time_low"
	      mt_rand(0, 0xffff), mt_rand(0, 0xffff),
	
	      // 16 bits for "time_mid"
	      mt_rand(0, 0xffff),
	
	      // 16 bits for "time_hi_and_version",
	      // four most significant bits holds version number 4
	      mt_rand(0, 0x0fff) | 0x4000,
	
	      // 16 bits, 8 bits for "clk_seq_hi_res",
	      // 8 bits for "clk_seq_low",
	      // two most significant bits holds zero and one for variant DCE1.1
	      mt_rand(0, 0x3fff) | 0x8000,
	
	      // 48 bits for "node"
	      mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
	    );
	}
	/**
	 * @access public
	 * @static
	 * Génération d'un identifiant alphanumérique
	 * @param integer $numStr
	 */
	public static function short_alphanumeric_id($numStr){
		$uId = '';
		srand( (double)microtime()*rand(1000000,9999999) ); // Genere un nombre aléatoire
		$arrChar = array(); // Nouveau tableau
		for( $i=65; $i<90; $i++ ) {
			array_push( $arrChar, chr($i) ); // Ajoute A-Z au tableau
			array_push( $arrChar, strtolower( chr( $i ) ) ); // Ajouter a-z au tableau
		}
		for( $i=48; $i<57; $i++ ) {
			array_push( $arrChar, chr( $i ) ); // Ajoute 0-9 au tableau
		}
		for( $i=0; $i< $numStr; $i++ ) {
			//$uId .= $arrChar[rand( 0, count( $arrChar ) )]; // Ecrit un aléatoire
			$uId .= $arrChar[rand( 0,count($arrChar)-1)];// Ecrit un aléatoire
		}
		return $uId;
	}
	/**
	 * @access public
	 * @static
	 * Génère un ID aléatoire sur base de différent paramètres de transformation (numérique => alphanumérique,alphanumérique => numérique)
	 * @param unknown_type $in
	 * @param unknown_type $to_num
	 * @param unknown_type $pad_up
	 * @param string $passKey
	 */
	public static function alphaID($in, $to_num = false, $pad_up = false, $passKey = null){
		  $index = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		  if ($passKey !== null) {
		    // Although this function's purpose is to just make the
		    // ID short - and not so much secure,
		    // with this patch by Simon Franz (http://blog.snaky.org/)
		    // you can optionally supply a password to make it harder
		    // to calculate the corresponding numeric ID
		 
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
}