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
require('interfaces/interface.Attributes.php');
/**
 * 
 * Magix cjQuery
 * 
 * @author Gérits Aurélien
 * @access public
 * @copyright clashdesign
 * @version 0.1
 * @package jQuery DOM manipulation
 *
 */
class magixcjquery_jquery_attributes extends magixcjquery_jquery_params implements IAttributes  {
	/**
	 * jquery html function
	 *
	 * @param string $var
	 * @param string $nid 
	 * @param string $text
	 * @return string
	 */
	public static function jHml($nid=false, $content = false, $end=true){
			$attr = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
			$attr .= $content ? '.html('.parent::content($content).')' : '';
			$attr .= $end ? ';' : '';
		return $attr;
	}
	/**
	 * jquery text function
	 *
	 * @param string $var
	 * @param string $nid 
	 * @param string $content
	 * @return string
	 */
	public static function jText($nid=false, $content = false, $end=true){
			$attr = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
			$attr .= $content ? '.text('.parent::content($content).')' : '';
			$attr .= $end ? ';' : '';
		return $attr; 
	}
	/**
	 * jquery attr function
	 * Set a name or properties or key/value or key/function object as properties to all matched elements.
	 *
	 * @param string $var
	 * @param string $nid
	 * @param string $name
	 * @param string $properties
	 * @return string
	 */
	/*public static function jAttr($nid=false, $name=false,$properties=false, $keyval=false,$key=false,$function=false, $end=true){
		$attr = $nid ? magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$attr .= $name ? '.attr("'.$name.'")' : '';
		$attr .= $properties ? $nid.'.attr({'.$properties.'})' : '';
		$attr .= $keyval ? '.attr('.eachParamsAttr::eachValue($keyval).')' : '';
		$attr .= $key ? '.attr("'.$key.','.$function.'")' : '';
		$attr .= $end ? ';' : '';
		return $attr;
	}*/
	public static function jAttr($nid=false,$seq,$attributes,$end=true){
		$attr = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.($nid).')' : '';
		switch ($seq) {
			case 'properties':
				$attr .= '.attr({'.parent::properties($attributes).'})';
				break;
			case 'keyval':
				$attr .= '.attr({'.parent::forOptions($attributes).'})';
				break;
			case 'name':
				$attr .= '.attr('.parent::name($attributes).')';
			break;
		}
		$attr .= $end ? parent::end() : '';
		return $attr;
	}
	/**
	 * jQuery removeAttr function 
	 * Remove an attribute from each of the matched elements.
	 *
	 * @param string $var
	 * @param string $nid
	 * @param string $name
	 * @return string
	 */
	public static function jRemoveAttr($nid=false, $name, $end=true){
		$attr = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$attr .= $name ? '.removeAttr("'.parent::name($name).'")' : ''; 
		$attr .= $end ? ';' : '';
		return $attr;
	}
	/**
	 * jQuery addClass function
	 * Adds the specified class(es) to each of the set of matched elements.
	 *
	 * @param string $var
	 * @param string $nid
	 * @param string $class
	 * @return string
	 */
	public static function jAddClass($nid=false, $class, $end=true){
		$attr = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$attr .= $class ? '.addClass("'.parent::jclass($class).'")' : ''; 
		$attr .= $end ? ';' : '';
		return $attr;
	}
	/**
	 * jQuery removeClass function
	 * Removes all or the specified class(es) from the set of matched elements.
	 *
	 * @param string $var
	 * @param string $nid
	 * @param string $class
	 * @return string
	 */
	public static function jRemoveClass($nid=false, $class=false, $end=true){
		$attr = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$attr .= $class ? '.removeClass("'.parent::jclass($class).'")' : ''; 
		$attr .= $end ? ';' : '';
		return $attr;
	}
	/**
	 * jQuery toggleClass function
	 * Adds the specified class if it is not present, removes the specified class if it is present.
	 *
	 * @param string $var
	 * @param string $nid
	 * @param string $class
	 * @return string
	 */
	public static function jToggleClass($nid=false, $class, $switch=false, $end=true){
		$attr = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$attr .= $class ? '.toggleClass("'.parent::jclass($class) : '';
		$attr .= $switch ? ','.$switch : '';
		$attr .= '")';
		$attr .= $end ? ';' : '';
		return $attr;
	}
	/**
	 * jQuery hasClass function
	 * Returns true if the specified class is present on at least one of the set of matched elements.
	 *
	 * @param string $var
	 * @param string $nid
	 * @param string $class
	 * @return string
	 */
	public static function jHasClass($nid=false, $class, $end=true){
		$attr = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$attr .= $class ? '.hasClass("'.parent::jclass($class).'")' : ''; 
		$attr .= $end ? ';' : '';
		return $attr;
	}
	/**
	 * jQuery val function
	 *
	 * @param string $var
	 * @param string $nid
	 * @param string $value
	 * @return string
	 */
	public static function jVal($nid=false, $value=false, $end=true){
		$attr = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$attr .= '.val(';
		$attr .= $value ? '"'.parent::value($value).'"' : '';
		$attr .= ')';
		$attr .= $end ? ';' : '';
		return $attr;
	}
}
?>