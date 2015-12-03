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
 * @package jQuery effects basics
 *
 */
class magixcjquery_jquery_effects extends magixcjquery_jquery_params {
	/**
	 * constante width (px,em,%)
	 */
	const width = 'width';
	/**
	 * constante height (px,em,%)
	 */
	const height = 'height';
	/**
	 * constante top
	 */
	const top = 'top';
	/**
	 * constante left
	 */
	const left = 'left';
	/**
	 * constante bottom
	 */
	const bottom = 'bottom';
	/**
	 * constante right
	 */
	const right = 'right';
	/**
	 * contante opacity 
	 */
	const opacity = 'opacity';
	/**
	 * constante marginLeft
	 */
	const marginLeft = 'marginLeft';
	/**
	 * constante marginRight
	 */
	const marginRight = 'marginRight';
	/**
	 * const marginTop
	 */
	const marginTop = 'marginTop';
	/**
	 * constante marginBottom
	 */
	const marginBottom = 'marginBottom';
	/**
	 * constante global padding
	 */
	const padding = 'padding';
	/**
	 * contante fontSize (px,em,%)
	 */
	const fontSize = 'fontSize';
	/**
	 * Constante global borderWidth
	 */
	const borderWidth = 'borderWidth';
	/**
	 * constante borderRightWidth
	 */
	const borderRightWidth = 'borderRightWidth';
	/**
	 * constante borderLeftWidth
	 */
	const borderLeftWidth = 'borderLeftWidth';
	/**
	 * constante borderTopWidth
	 */
	const borderTopWidth = 'borderTopWidth';
	/**
	 * constante borderBottomWidth
	 */
	const borderBottomWidth = 'borderBottomWidth';
	/**
	 * jQuery show() function 
	 * Displays each of the set of matched elements if they are hidden.
	 *
	 * @param string $nid
	 * @param string $speed
	 * @param string $callback True if callback
	 * @return string
	 */
	public static function jShow($nid=false, $speed=false, $callback=false, $end=true){
		$fx = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$fx .= '.show(';
		$fx .= $speed ? parent::speed($speed) : '';
		$fx .= $callback ? parent::callback($callback) : '';
		$fx .= ')';
		$fx .= $end ? ';' : '';
		return $fx;
	}
	/**
	 * jQuery hide() function 
	 * Hides each of the set of matched elements if they are shown.
	 *
	 * @param string $nid
	 * @param string $speed
	 * @param string $callback True if callback
	 * @return string
	 */
	public static function jHide($nid=false, $speed=false, $callback=false, $end=true){
		$fx = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$fx .= '.hide(';
		$fx .= $speed ? parent::speed($speed) : '';
		$fx .= $callback ? parent::callback($callback) : '';
		$fx .= ')';
		$fx .= $end ? ';' : '';
		return $fx;
	}
	/**
	 * jQuery fadeIn() function 
	 * Fade in all matched elements by adjusting their opacity and firing an optional callback after completion.
	 *
	 * @param string $nid
	 * @param string $speed
	 * @param string $callback True if callback
	 * @return string
	 */
	public static function jFadeIn($nid=false, $speed=false, $callback=false, $end=true){
		$fx = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$fx .= '.fadeIn(';
		$fx .= $speed ? parent::speed($speed) : '';
		$fx .= $callback ? parent::callback($callback) : '';
		$fx .= ')';
		$fx .= $end ? ';' : '';
		return $fx;
	}
	/**
	 * jQuery fadeOut() function 
	 * Fade out all matched elements by adjusting their opacity to 0, then setting display to "none" and firing an optional callback after completion.
	 *
	 * @param string $nid
	 * @param string $speed
	 * @param string $callback True if callback
	 * @return string
	 */
	public static function jFadeOut($nid=false, $speed=false, $callback=false, $end=true){
		$fx = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$fx .= '.fadeOut(';
		$fx .= $speed ? parent::speed($speed) : '';
		$fx .= $callback ? parent::callback($callback) : '';
		$fx .= ')';
		$fx .= $end ? ';' : '';
		return $fx;
	}
	/**
	 * jQuery fadeTo() function 
	 * Fade the opacity of all matched elements to a specified opacity and firing an optional callback after completion.
	 *
	 * @param string $nid
	 * @param string $speed
	 * @param string $callback True if callback
	 * @return string
	 */
	public static function jFadeTo($nid=false, $speed=false, $opacity=false, $callback=false, $end=true){
		$fx = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$fx .= '.fadeOut(';
		$fx .= $speed ? parent::speed($speed) : '';
		$fx .= $opacity ? ','.$opacity : '';
		$fx .= $callback ? parent::callback($callback) : '';
		$fx .= ')';
		$fx .= $end ? ';' : '';
		return $fx;
	}
	/**
	 * jQuery slideDown() function 
	 * Reveal all matched elements by adjusting their height and firing an optional callback after completion.
	 *
	 * @param string $nid
	 * @param string $speed
	 * @param string $callback True if callback
	 * @return string
	 */
	public static function jSlideDown($nid=false, $speed=false, $callback=false, $end=true){
		$fx = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$fx .= '.slideDown(';
		$fx .= $speed ? parent::speed($speed) : '';
		$fx .= $callback ? parent::callback($callback) : '';
		$fx .= ')';
		$fx .= $end ? ';' : '';
		return $fx;
	}
	/**
	 * jQuery slideUp() function 
	 * Hide all matched elements by adjusting their height and firing an optional callback after completion
	 *
	 * @param string $nid
	 * @param string $speed
	 * @param string $callback True if callback
	 * @return string
	 */
	public static function jSlideUp($nid=false, $speed=false, $callback=false, $end=true){
		$fx = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$fx .= '.slideUp(';
		$fx .= $speed ? parent::speed($speed) : '';
		$fx .= $callback ? parent::callback($callback) : '';
		$fx .= ')';
		$fx .= $end ? ';' : '';
		return $fx;
	}
	/**
	 * jQuery slideToggle() function 
	 * Toggle the visibility of all matched elements by adjusting their height and firing an optional callback after completion
	 *
	 * @param string $nid
	 * @param string $speed
	 * @param string $callback True if callback
	 * @return string
	 */
	public static function jSlideToggle($nid=false, $speed=false, $callback=false, $end=true){
		$fx = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$fx .= '.slideToggle(';
		$fx .= $speed ? parent::speed($speed) : '';
		$fx .= $callback ? parent::callback($callback) : '';
		$fx .= ')';
		$fx .= $end ? ';' : '';
		return $fx;
	}
	/**
	 * jQuery toggle() function 
	 * Toggle displaying each of the set of matched elements.
	 *
	 * @param string $nid
	 * @param string $speed
	 * @param string $callback True if callback
	 * @return string
	 */
	public static function jToggle($nid=false, $speed=600, $callback=false, $end=true){
		$fx = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$fx .= '.toggle(';
		$fx .= $speed ? parent::speed($speed).',' : '';
		//$fx .= $switch ? ','.$switch : '';
		$fx .= $callback ? ''.parent::callback($callback) : '';
		$fx .= ')';
		$fx .= $end ? ';' : '';
		return $fx;
	}
	/**
	 * jQuery animate() function
	 *
	 * @param string $nid
	 * @param array $params array(Constante=>'val')
	 * @param string $duration
	 * @param string $easing
	 * @param string $callback True if callback
	 * @return string
	 */
	public static function jAnimate($nid=false, $params, $duration=false, $easing=false, $callback=false, $end=true){
		$fx = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$fx .= '.animate({';
		$fx .= $params ? parent::forOptions($params).'}' : '';
		$fx .= $duration ? ',{duration:'.$duration : '';
		$fx .= $easing ? ','.$easing : '';
		$fx .= '}';
		$fx .= $callback ? ','.parent::callback($callback).'}' : '';
		$fx .= ')';
		$fx .= $end ? ';' : ''; 
		return $fx;
	}
	/**
	 * jQuery stop() function 
	 * Stops all the currently running animations on all the specified elements.
	 *
	 * @param string $nid
	 * @param string $clearQueue
	 * @param string $goToEnd
	 * @return string
	 */
	public static function jStop($nid=false, $clearQueue=false, $goToEnd=false, $end=true){
		$fx = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$fx .= '.stop(';
		$fx .= $clearQueue ? $clearQueue : '';
		$fx .= $goToEnd ? $goToEnd : '';
		$fx .= ')'; 
		$fx .= $end ? ';' : '';
		return $fx;
	}
	/**
	 * optionnel function jQuery.fx.off
	 * 
	 */
	/**
	 * Globally disable all animations.
	 *
	 * @param bool $on true/false
	 * @return string
	 */
	public static function fxOff($on){
		
		$fx = 'jQuery.fx.off = '.$on.';';
		return $fx;
	}
}
/*class eachParamsEffects extends magixEffects {
	/**
	 * function each properties separate by two point and commat
	 *
	 * @param array $properties
	 * @param string $val
	 * @return array
	 */
	/*public function eachParams($params = array()){
    	
    	foreach ($params as $key => $val){
    		$tabs[] = $key.':'.'"'.$val.'"';
    	}
    return implode(',',$tabs);
    }
}*/