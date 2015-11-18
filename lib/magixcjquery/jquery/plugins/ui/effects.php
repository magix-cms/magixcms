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
 * @package Extends jQuery
 * @author Gerits Aurelien
 * @copyright magixcjQuery
 * @version 0.1
 * plugins jQuery UI
 * Effects UI
 *
 */
class magixcjquery_jquery_plugins_ui_effects extends magixcjquery_jquery_params{
	/**
	 * constant for animate : backgroundColor
	 *
	 */
	const backgroundColor = 'backgroundColor';
	/**
	 * constant for animate : borderBottomColor
	 *
	 */
	const borderBottomColor = 'borderBottomColor';
	/**
	 * constant for animate : borderLeftColor
	 *
	 */
	const borderLeftColor = 'borderLeftColor';
	/**
	 * constant for animate : borderRightColor
	 *
	 */
	const borderRightColor = 'borderRightColor';
	/**
	 * constant for animate : borderTopColor
	 *
	 */
	const borderTopColor = 'borderTopColor';
	/**
	 * constant for animate : color
	 *
	 */
	const color = 'color';
	/**
	 * constant for animate : outlineColor
	 *
	 */
	const outlineColor = 'outlineColor';
	/**
	 * Constant for width
	 *
	 */
	const width = 'width';
	/**
	 * Constant for width
	 *
	 */
	const height = 'height';
	/**
	 * 
	 */
	/**
	 * option backgroundColor
	 *
	 * @param string $color
	 * @return string
	 */
	function opt_backgroundColor($color){
		return self::backgroundColor.':'.'"'.$color.'"';
	}
	/**
	 * function option borderBottomColor
	 *
	 * @param string $color
	 * @return string
	 */
	function opt_borderBottomColor($color){
		return self::borderBottomColor.':'.'"'.$color.'"';
	}
	/**
	 * function option borderLeftColor
	 *
	 * @param string $color
	 * @return string
	 */
	function opt_borderLeftColor($color){
		return self::borderLeftColor.':'.'"'.$color.'"';
	}
	/**
	 * function option borderRightColor
	 *
	 * @param string $color
	 * @return string
	 */
	function opt_borderRightColor($color){
		return self::borderRightColor.':'.'"'.$color.'"';
	}
	/**
	 * function option borderTopColor
	 *
	 * @param string $color
	 * @return string
	 */
	function opt_borderTopColor($color){
		return self::borderTopColor.':'.'"'.$color.'"';
	}
	/**
	 * function option color
	 *
	 * @param string $color
	 * @return string
	 */
	function opt_color($color){
		return self::color.':'.'"'.$color.'"';
	}
	/**
	 * function option outlineColor
	 *
	 * @param string $color
	 * @return string
	 */
	function opt_outlineColor($color){
		return self::outlineColor.':'.'"'.$color.'"';
	}
	/**
	 * function option width
	 *
	 * @param string $size
	 * @return string
	 */
	function opt_width($size){
		return self::width .':'.'"'.$size.'"';
	}
	/**
	 * function option height
	 *
	 * @param string $size
	 * @return string
	 */
	function opt_height($size){
		return self::height .':'.'"'.$size.'"';
	}
	/**
	 * jQuery addClass() function 
	 * Overview
	 * addClass( class, [duration] )
	 * Adds the specified class to each of the set of matched elements with an optional transition between the states.
	 *
	 * @param string $nid
	 * @param string $class
	 * @param string $duration
	 * @param string $callback True if callback
	 * @return string
	 */
	public static function addClass($nid=false, $class, $duration=false, $callback=false, $end=true){
		$uifx = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$uifx .= '.addClass("';
		$uifx .= $class.'"';
		$uifx .= $duration ? ','.$duration : '';
		$uifx .= $callback ? ','.parent::callback($callback) : '';
		$uifx .= ')';
		$uifx .= $end ? ';' : '';
		return $uifx;
	}
	/**
	 * jQuery removeClass() function 
	 * Overview
	 * removeClass( [class], [duration] )
	 * Removes all or specified class from each of the set of matched elements with an optional transition between the states.
	 *
	 * @param string $nid
	 * @param string $class
	 * @param string $duration
	 * @param string $callback True if callback
	 * @return string
	 */
	public static function removeClass($nid=false, $class, $duration=false, $callback=false, $end=true){
		$uifx = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$uifx .= '.removeClass("';
		$uifx .= $class.'"';
		$uifx .= $duration ? ','.$duration : '';
		$uifx .= $callback ? ','.parent::callback($callback) : '';
		$uifx .= ')';
		$uifx .= $end ? ';' : '';
		return $uifx;
	}
	/**
	 * jQuery animate() function
	 *
	 * @param string $nid
	 * @param array $params
	 * @param string $duration
	 * @param string $easing
	 * @param string $callback True if callback
	 * @return string
	 */
	public static function animate($nid=false, $params='', $speed=1000, $end=true){
		$uifx = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$uifx .= '.animate({';
		$uifx .= $params ? parent::forUIValue($params).'}' : '';
		$uifx .= ','.$speed;
		$uifx .= ')';
		$uifx .= $end ? ';' : ''; 
		return $uifx;
	}
}
?>