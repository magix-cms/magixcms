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
 * @copyright magix cjquery
 * @version 0.1
 * @package View Helper
 * @name script
 *
 */
class magixcjquery_view_helper_script{
	/**
	 * Instance
	 * @var void
	 * @access private
	 */
	private static $instance = null;
	/**
     * instance singleton
     * @access public
     */
    private static function getInstance(){
    	if (!isset(self::$instance)){
    		if(is_null(self::$instance)){
				self::$instance = new magixcjquery_view_helper_script();
			}
      	}
		return self::$instance;
    }
	/**
	 * 
	 * start Ini link meta
	 * 
	 * @access private
	 */
	private function startScript(){
		if(self::getInstance()){
			return '<script ';
		}
	}
	/**
	 * end script meta
	 * 
	 * @access private
	 */
	private function endScript(){
		if(self::getInstance()){
			return '</script>'.PHP_EOL;
		}
	}
	/**
	 * Retourne le type
	 * @param string $type
	 */
	private function type($type){
		if(self::getInstance()){
			switch($type){
				case 'javascript':
					return 'type="text/javascript"';
				break;
			}
		}
	}
	/**
	 * Retourne le type de chargement
	 * @param string $load
	 */
	private function load($load){
		if(self::getInstance()){
			switch($load){
				case 'async':
					return ' async';
					break;
				case 'defer':
					return ' defer';
					break;
				default:
					return '';
			}
		}
	}
	/**
	 *
	 * magixcjquery_view_helper_script::src($uri,$type)
	 * <script type="text/javascript" src="/monscript.js"></script>
	 *
	 * @param string $uri
	 * @param string media
	 */
	public static function src($uri,$type,$load = 'normal'){
		if(self::getInstance()){
			return self::getInstance()->startScript().'src="'.$uri.'" '.self::getInstance()->type($type).self::getInstance()->load($load).'>'.self::getInstance()->endScript();
		}
	}
}