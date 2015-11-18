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
 * @package View Helper
 * @name doctype
 *
 */
class magixcjquery_view_helper_doctype{
	/**
	 * Constante for doctype type
	 * @var string
	 */
	const XHTML11             = 'XHTML11';
	/**
	 * Constante for doctype type
	 * @var string
	 */
	const XHTML1_STRICT       = 'XHTML1_STRICT';
	/**
	 * Constante for doctype type
	 * @var string
	 */
	const XHTML1_TRANSITIONAL = 'XHTML1_TRANSITIONAL';
	/**
	 * Constante for doctype type
	 * @var string
	 */
	const HTML4_STRICT        = 'HTML4_STRICT';
	/**
	 * Constante for doctype type
	 * @var string
	 */
	const HTML4_LOOSE         = 'HTML4_LOOSE';
	/**
	 * Constante for doctype type
	 * @var string
	 */
	const HTML5				  = 'HTML5';
	/**
	 * Constante for doctype type
	 * @var string
	 */
	const CUSTOM_XHTML        = 'CUSTOM_XHTML';
	/**
	 * Constante for doctype type
	 * @var string
	 */
	const CUSTOM              = 'CUSTOM';
	/**
	 * Default DocType
	 * @var string
     */
    protected static $_defaultDoctype = self::HTML4_LOOSE;
	/**
	 * Function construc class
	 */
	function __construct(){}
	/**
	 * 
	 * Add doctype 
	 * 
	 * @param string $doctype
	 */
	public static function doctype($doctype=null){
		if (null !== $doctype) {
            switch ($doctype) {
            	case self::XHTML11:
            		$type = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
            		"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">';//.PHP_EOL;
            		break;
            	case self::XHTML1_STRICT:
            		$type = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   					"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';//.PHP_EOL;
            		break;
            	case self::XHTML1_TRANSITIONAL:
            		$type = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
            		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';//.PHP_EOL;
            		break;
            	case self::HTML4_STRICT:
            		$type = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" 
            		"http://www.w3.org/TR/html4/strict.dtd">';//.PHP_EOL;
            		break;
            	case self::HTML5:
            		$type = '<!doctype html>';//.PHP_EOL;
            		break;
            	case self::$_defaultDoctype:
            		$type = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
            		"http://www.w3.org/TR/html4/loose.dtd">';//.PHP_EOL;
            		break;
            }
		}
		return $type;
	}
}