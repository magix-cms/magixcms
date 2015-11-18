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
 * @package jQuery TRAVERSING manipulation
 *
 */
class magixcjquery_jquery_traversing extends magixcjquery_jquery_params{
	/**
	 * jquery eq function
	 *
	 * @param string $nid 
	 * @param string $numeric
	 * @return string
	 */
	public static function jEq($nid=false, $content, $end=true){
			$attr = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
			$attr .= '.eq('.is_numeric(parent::content($content)).')';
			$attr .= $end ? ';' : '';
		return $attr;
	}
	public static function jFilter(){}
	public static function jIs(){}
	public static function jMap(){}
	public static function jNot(){}
	public static function jSlice(){}
	public static function jAdd(){}
	/**
	 * Get a set of elements containing all of the unique immediate children of each of the matched set of elements.
	 *
	 * @param string $nid
	 * @param string $script
	 * @param string $end
	 * @return string
	 */
	public static function jChildren($nid=false, $script, $end=true){
		$traversing = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$traversing .= '.children(';
		$traversing .= $script ? 'function(){'.$script.'}' : '';
		$traversing .= ')';
		$traversing .= $end ? ';' : '';
		return $traversing;
	}
	public static function jClosest(){}
	/**
	 * New in jQuery 1.3 Get a set of elements containing the closest parent element that matches the specified selector, the starting element included.
	 *
	 * @param string $nid
	 * @param string $end
	 * @return string
	 */
	public static function jContent($nid=false, $end=true){
		$traversing = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$traversing .= '.content(';
		$traversing .= ')';
		$traversing .= $end ? ';' : '';
		return $traversing;
	}
	/**
	 * Searches for descendent elements that match the specified expression.
	 *
	 * @param string $nid 
	 * @param string $expr
	 * @param string $end
	 * @return string
	 */
	public static function jFind($nid=false,$expr, $end=true){
		$traversing = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$traversing .= '.find("';
		$traversing .= parent::content($expr);
		$traversing .= '")';
		$traversing .= $end ? ';' : '';
		return $traversing;
	}
	/**
	 * Get a set of elements containing the unique next siblings of each of the given set of elements.
	 *
	 * @param string $nid
	 * @param string $expr
	 * @param string $end
	 * @return string
	 */
	public static function jNext($nid=false,$expr=false, $end=true){
		$traversing = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$traversing .= '.next(';
		$traversing .= $expr ? parent::content($expr) :'';
		$traversing .= ')';
		$traversing .= $end ? ';' : '';
		return $traversing;
	}
	/**
	 * Find all sibling elements after the current element.
	 *
	 * @param string $nid
	 * @param string $expr
	 * @param string $end
	 * @return string
	 */
	public static function jNextAll($nid=false,$expr=false, $end=true){
		$traversing = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$traversing .= '.nextAll(';
		$traversing .= $expr ? parent::content($expr) :'';
		$traversing .= ')';
		$traversing .= $end ? ';' : '';
		return $traversing;
	}
	public static function jOffsetParent(){}
	/**
	 * Get a set of elements containing the unique parents of the matched set of elements.
	 *
	 * @param string $nid
	 * @param string $expr
	 * @param string $end
	 * @return string
	 */
	public static function jParent($nid=false,$expr=false, $end=true){
		$traversing = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$traversing .= '.parent(';
		$traversing .= $expr ? parent::content($expr) :'';
		$traversing .= ')';
		$traversing .= $end ? ';' : '';
		return $traversing;
	}
	/**
	 * Get a set of elements containing the unique ancestors of the matched set of elements (except for the root element).
	 *
	 * @param string $nid
	 * @param string $expr
	 * @param string $end
	 * @return string
	 */
	public static function jParents($nid=false,$expr=false, $end=true){
		$traversing = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$traversing .= '.parents(';
		$traversing .= $expr ? parent::content($expr) :'';
		$traversing .= ')';
		$traversing .= $end ? ';' : '';
		return $traversing;
	}
}