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
 * Magix XML
 * 
 * @author Gérits Aurélien
 * @access public
 * @copyright clashdesign
 * @version 0.1
 * @package Singleton XML
 *
 */
class magixcjquery_xml_xml{
	/**
	  *
	  * @var XML
	  * @access private
	  */
	public $xmlWriter = null;
	 /**
	* @var Singleton
	* @access private
	* @static
	*/
	private static $_instance = null;
	/**
	 * 
	 * Constructor
	 */
	function __construct() {
		$this->xmlWriter = new XMLWriter();
	}
	/**
	 * W3C date Format
	 * @param $str
	 * @return void
	 */
	public function isW3CDate($str) {
		$stamp = strtotime( $str );
		  if (!is_numeric($stamp))
		  {
		     return false;
		  }
		  $month = date( 'm', $stamp );
		  $day   = date( 'd', $stamp );
		  $year  = date( 'Y', $stamp );
		 
		  if (checkdate($month, $day, $year))
		  {
		     return $str;
		  }
		 
		  return false; 
	}
	/**
	 * @access public
	 * @static
	 * xmlInstance class
	 */
	public static function xmlInstance() {
		if(is_null(self::$_instance)) {
			self::$_instance = new magixcjquery_xml_xml();
		}
		return self::$_instance;
	}
	/**
	 * 
	 * Returns the folder path
	 * @param string $path
	 * @throws Exception
	 */
	public function folder_path($fpath){
		if(is_dir($fpath)){
			return $fpath;
		}else{
			throw new Exception("Path is not valid folder");
		}
	}
	/**
	 * Create XML File
	 * @param $file (string)
	 * @return void
	 */
	public function createFile($fpath,$file){
		if (!file_exists(self::folder_path($fpath).$file)) {
			//@umask(0755);
			if(is_writable(self::folder_path($fpath))){
				$handle = @fopen(self::folder_path($fpath).$file,'a+');
				if($handle){
					if(@chmod(self::folder_path($fpath).$file,0755)){
						return true;
					}
					fclose($handle);
				}
			}else{
				throw new Exception("Folder is not writable");
			}
		}
	}
	/**
	 * Open File and Create new xmlwriter using source uri for output
	 * @param $file (string)
	 * @return void
	 */
	public function openUriXml($fpath,$file){
		if (file_exists(self::folder_path($fpath).$file)) {
			if (!is_writable(self::folder_path($fpath).$file)) {
				throw new Exception('file is not writable');
			}else{
				$this->xmlWriter->openUri(self::folder_path($fpath).$file);
			}
		}else{
			throw new Exception('not file exist');
		}
	}
	/**
	 * Convert valid date format in W3C
	 * http://www.w3.org/TR/NOTE-datetime
	 * @param $date
	 * @return string
	 */
	public function dateIsW3c($date){
		$dateTime = new DateTime($date);
		 //return $dateTime->format(DATE_ISO8601);
		 return $dateTime->format(DateTime::W3C);
	}
	/**
	 * Toggle indentation on/off
	 * @param $indent = true/false
	 * @return void
	 */
	public function indent($indent=true){
		$this->xmlWriter->setIndent($indent);
	}
	/**
	 * End Parent element
	 * @return void
	 */
	public function endElement(){
		$this->xmlWriter->endElement();
	}
}

?>