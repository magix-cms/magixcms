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
 * @package jQuery EVENT manipulation
 *
 */
require('interfaces/interface.magixEvent.php');
class magixcjquery_jquery_event implements ImagixEvent{
##### Event Helpers #####
	/**
	 * the .bind() method
	 *
	 * @param string $nid
	 * @param string $action
	 * @param string $script
	 * @param string $end
	 * @return string
	 */
	public static function jBind($nid=false, $action, $script, $end=true){
		$event = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$event .= '.bind(';
		$event .= $action ? '"'.$action.'"' : '';
		$event .= ',function(){';
		$event .= $script ? $script.'})' : '';
		$event .= $end ? ';' : '';
		return $event;
	}
	/**
	 * the .unbind() method opposite of bind
	 *
	 * @param string $nid
	 * @param string $action
	 * @param string $script
	 * @param string $end
	 * @return string
	 */
	public static function jUnBind($nid=false, $action, $script, $end=true){
		$event = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$event .= '.unbind(';
		$event .= $action ? '"'.$action.'"' : '';
		$event .= ',function(){';
		$event .= $script ? $script.'})' : '';
		$event .= $end ? ';' : '';
		return $event;
	}
######## Live Events ######
	/**
	 * the .live() method
	 *
	 * @param string $nid
	 * @param string $action
	 * @param string $script
	 * @param string $end
	 * @return string
	 */
	public static function jLive($nid=false, $action, $script, $end=true){
		$event = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$event .= '.live(';
		$event .= $action ? '"'.$action.'"' : '';
		$event .= ',function(){';
		$event .= $script ? $script.'})' : '';
		$event .= $end ? ';' : '';
		return $event;
	}
	/**
	 * the .die() method opposite of live
	 *
	 * @param string $nid
	 * @param string $action
	 * @param string $script
	 * @param string $end
	 * @return string
	 */
	public static function jDie($nid=false, $action, $script, $end=true){
		$event = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$event .= '.die(';
		$event .= $action ? '"'.$action.'"' : '';
		$event .= ',function(){';
		$event .= $script ? $script.'})' : '';
		$event .= $end ? ';' : '';
		return $event;
	}
####### Interaction Helpers #######
	/**
	 * function hover method
	 *
	 * @param over $over
	 * @param out $out
	 * @return void
	 */
	public static function jHover($nid=false, $over, $out,$end=true){
		$event = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$event .= '.hover(';
		$event .= $over ? 'function(){'.$over.'},' : false;
		$event .= $out ? 'function(){'.$out.'}' : false;
		$event .= ')';
		$event .= $end ? ';' : '';
		return $event;
	}
####### Event Helpers #######
	/**
	 * the .blur() method
	 *
	 * @param string $nid
	 * @param string $action
	 * @param string $script
	 * @param string $end
	 * @return string
	 */
	public static function jBlur($nid=false, $script, $end=true){
		$event = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$event .= '.blur(';
		$event .= $script ? 'function(){'.$script.'}' : '';
		$event .= ')';
		$event .= $end ? ';' : '';
		return $event;
	}
	/**
	 * the .click() method
	 *
	 * @param string $nid
	 * @param string $action
	 * @param string $script
	 * @param string $end
	 * @return string
	 */
	public static function jClick($nid=false, $script, $end=true){
		$event = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$event .= '.click(';
		$event .= 'function(){';
		$event .= $script ? $script.'})' : '';
		$event .= $end ? ';' : '';
		return $event;
	}
	/**
	 * the .change() method
	 *
	 * @param string $nid
	 * @param string $action
	 * @param string $script
	 * @param string $end
	 * @return string
	 */
	public static function jChange($nid=false, $script, $end=true){
		$event = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$event .= '.change(';
		$event .= 'function(){';
		$event .= $script ? $script.'})' : '';
		$event .= $end ? ';' : '';
		return $event;
	}
	/**
	 * the .focus() method
	 *
	 * @param string $nid
	 * @param string $action
	 * @param string $script
	 * @param string $end
	 * @return string
	 */
	public static function jFocus($nid=false, $script, $end=true){
		$event = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$event .= '.focus(';
		$event .= 'function(){';
		$event .= $script ? $script.'})' : '';
		$event .= $end ? ';' : '';
		return $event;
	}
}