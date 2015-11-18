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
 * @package jQuery UTILITIES
 *
 */
class magixcjquery_jquery_utilities extends magixcjquery_jquery_params{
	/**
	 * Construct new Selector
	 *
	 * @param void $expr
	 * @return void
	 */
	public static function expr($expr){
		$selectors = magixcjquery_jquery_magixcjQuery::getjQueryHandling().'.expr['.$expr.']';
		return $selectors;	
	}
	/**
	 * Extend one object with one or more others, returning the modified object.
	 *
	 * @param boolean $deep
	 * @param object $target
	 * @param object $object1
	 * @param object $objectN
	 * @return object
	 */
	public static function extend($deep=false,$target, $object1, $objectN=false){
		$utilities = magixcjquery_jquery_magixcjQuery::getjQueryHandling().'.extend(';
		$utilities .= $deep?$deep:false;
		$utilities .= $target?$target:false;
		$utilities .= $object1?$object1:false;
		$utilities .= $objectN?$objectN:false;
		$utilities .= ');';
		return $utilities;
	}
	/**
	 * A generic iterator function, which can be used to seamlessly iterate over both objects and arrays. 
	 * Arrays and array-like objects with a length property (such as a function's arguments object) 
	 * are iterated by numeric index, from 0 to length-1. Other objects are iterated via their named properties.
	 *
	 * @param void $object
	 * @param void $callback
	 * @return string
	 */
	public static function jEach($object,$callback){
		$each = magixcjquery_jquery_magixcjQuery::getjQueryHandling().'.each(';
		$each .= $object?'['.parent::forSimpleValue($object).']':false;
		$each .= $callback?','.$callback:false;
		$each .= ');';
		return $each;
	}
}
?>