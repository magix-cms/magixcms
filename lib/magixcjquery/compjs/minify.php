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
 * class Minify
 * @author Aurelien
 *
 */
class magixcjquery_compjs_minify{
	/**
	 * 
	 * @staticvar _jshrink
	 * @access private
	 */
	private static $_jshrink;
	/**
	 * 
	 * @staticvar _jsmin
	 * @access private
	 */
	private static $_jsmin;
	/**
	 * 
	 * @staticvar _packer
	 * @access private
	 */
	private static $_packer;
	/**
	 * 
	 * @var array()
	 * @access protected
	 */
	protected static $optDefaultJShrink = array('flaggedComments' => true);
	/**
	 * 
	 * @var unknown_type
	 */
	protected static $optDefaultPacker = array('encoding' => 'Normal','fastDecode' => true,'specialChars' => false);
	/**
	 * @return array JShrink options
	 * @param void $options
	 */
	public static function _optionsJShrink($options = false){
		if($options != false){
			$set = $options;
		}else{
			$set = self::$optDefaultJShrink;
		}
		return $set;
	}
	/**
	 * 
	 * @see http://code.google.com/p/jshrink-/
	 */
	protected function _setJShrink(){
		require_once 'source/JShrink-0.2.class.php';
		self::$_jshrink = new JShrink();
	}
	/**
	 * @return ini JShrink minify
	 * @param string $source
	 * @param void $options
	 */
	protected function _iniJShrink($source,$options){
		self::_setJShrink();
		return self::$_jshrink->minify($source,$options);
	}
	/**
	 * 
	 * @see http://code.google.com/p/jsmin/
	 */
	protected function _setJSMin(){
		require_once 'source/jsmin-1.1.1.php';
		//self::$_jsmin = new JSMin();
	}
	/**
	 * Minify source with jsmin
	 * @param string $source
	 */
	protected static function _iniJSMin($source){
		self::_setJSMin();
		return JSMin::minify($source);
	}
	/*public static function fileGetMin($source){
			return JSMin::minify(file_get_contents($source));
	}*/
	/**
	 * calculate time start
	 *
	 * @return void
	 */
	public static function timeStart(){
		return microtime(true);
	}
	/**
	 * calculate time end
	 *
	 * @return void
	 */
	public static function timeEnd(){
		return microtime(true);
	}
	public static function _optionsPacker($options = array()){
		if($options == null){
			$opt = array(
				'encoding' 		=> 'Normal',
				'fastDecode' 	=> true,
				'specialChars' 	=> false
			);
		}else{
			$opt = $options;
		}
		return $opt;
	}
	/*
	 * 
	 * 
	 * 
	 * */
	protected function _setPacker($source,$_encoding,$_fastDecode = true,$_specialChars = false){
		require_once 'source/class.JavaScriptPacker.php';
		return self::$_packer = new JavaScriptPacker($source,$_encoding,$_fastDecode = true,$_specialChars = false);
	}
	/**
	 * function ini packer
	 *
	 * @param $script
	 * @param numeric $_encoding
	 * @param $_fastDecode
	 * @param $_specialChars
	 * @return void
	 */
	protected static function _iniPacker($source,$options){
		$packer = self::_setPacker($source,$options['encoding'],$options['fastDecode'],$options['specialChars']);
		return $packer->pack();
	}
	/**
	 * ratio
	 *
	 * @param void $script
	 * @param void $packed
	 * @return string
	 */
	public static function ratio($script,$packed){
		$originalLength = strlen($script);
		$packedLength = strlen($packed);
		return number_format($packedLength / $originalLength, 3);
	}
	/**
	 * calculate time exec
	 *
	 * @param void $script
	 * @param void $packed
	 * @return void
	 */
	public static function time($t1,$t2){
		return sprintf('%.4f', ($t2 - $t1) );
	}
	/**
	 * @return minify result
	 * @param string $compressor
	 * 		=> select compressor
	 * @param string $source
	 */
	public static function jscompressor($compressor,$source){
		switch($compressor){
			case 'jshrink':
				$ini = self::_iniJShrink($source,self::_optionsJShrink());
			break;
			case 'jsmin':
				$ini = self::_iniJSMin($source);
			break;
			case 'packer':
				$ini = self::_iniPacker($source,self::_optionsPacker());
			break;
		}
		return $ini;
	}
}