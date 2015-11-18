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
 * Accordion UI
 *
 */
class magixcjquery_jquery_plugins_ui_accordion extends magixcjquery_jquery_params{
	/**
	 * Constant active params
	 *
	 */
	const active = 'active';
	/**
	 * Constant animated params
	 *
	 */
	const animated = 'animated';
	/**
	 * Constant autoHeight params
	 *
	 */
	const autoHeight = 'autoHeight';
	/**
	 * Constant clearStyle params
	 *
	 */
	const clearStyle = 'clearStyle';
	/**
	 * Constant collapsible params
	 *
	 */
	const collapsible = 'collapsible';
	/**
	 * Constant event params
	 *
	 */
	const event = 'event';
	/**
	 * Constant fillSpace params
	 *
	 */
	const fillSpace = 'fillSpace';
	/**
	 * Constant header params
	 *
	 */
	const Header = 'header';
	/**
	 * Constant icons params
	 *
	 */
	const icons = 'icons';
	/**
	 * Constant navigation params
	 *
	 */
	const navigation = 'navigation';
	/**
	 * Constant navigationFilter params
	 *
	 */
	const navigationFilter = 'navigationFilter';
	/**
	 * Selector for the active element. Set to false to display none at start. Needs «collapsible: true».
	 *
	 * @return string
	 */
	function opt_Active(){
		return self::active;
	}
	/**
	 * Choose your favorite animation, or disable them (set to false). 
	 * In addition to the default, 'bounceslide' and 'easeslide' are supported (both require the easing plugin).
	 *
	 * @return string
	 */
	function opt_animated(){
		return self::animated;
	}
	/**
	 * If set, the highest content part is used as height reference for all other parts. Provides more consistent animations.
	 *
	 * @return string
	 */
	function opt_autoHeight(){
		return self::autoHeight;
	}
	/**
	 * 
	 * If set, clears height and overflow styles after finishing animations. 
	 * This enables accordions to work with dynamic content. Won't work together with autoHeight.
	 *
	 * @return string
	 */
	function opt_clearStyle(){
		return self::clearStyle ;
	}
	/**
	 * Whether all the sections can be closed at once. Allows collapsing the active section by the triggering event (click is the default).
	 *
	 * @return string
	 */
	function opt_collapsible(){
		return self::collapsible ;
	}
	/**
	 * The event on which to trigger the accordion.
	 *
	 * @return string
	 */
	function opt_event(){
		return self::event ;
	}
	/**
	 * If set, the accordion completely fills the height of the parent element. Overrides autoheight.
	 *
	 * @return string
	 */
	function opt_fillSpace(){
		return self::fillSpace ;
	}
	/**
	 * Selector for the header element.
	 *
	 * @return string
	 */
	function opt_header(){
		return self::Header;
	}
	/**
	 * Icons to use for headers. Icons may be specified for 'header' and 'headerSelected', 
	 * and we recommend using the icons native to the jQuery UI CSS Framework manipulated by jQuery UI ThemeRoller
	 *
	 * @return string
	 */
	function opt_icons(){
		return self::icons ;
	}
	/**
	 * If set, looks for the anchor that matches location.href and activates it. 
	 * Great for href-based state-saving. Use navigationFilter to implement your own matcher.
	 *
	 * @return string
	 */
	function opt_navigation(){
		return self::navigation ;
	}
	/**
	 * Overwrite the default location.href-matching with your own matcher.
	 *
	 * @return string
	 */
	function opt_navigationFilter(){
		return self::navigationFilter ;
	}
	/**
	 * function ini jaccordion
	 *
	 * @param string $nid
	 * @param string $end
	 * @return string
	 */
	public static function jaccordion($nid=true,$option=array(),$end=true){
		$ui = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
	    $ui .= '.accordion({';
	    $ui .= parent::forUIOptions($option);
	    $ui .= '})';
		$ui .= $end ? ';' : '';
		return $ui;
	}
}
?>