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
 * Extends jQuery
 * plugins jQuery magicalHover
 *
 */
class magixcjquery_jquery_plugins_magicalhover{
	/**
	 * function ini rollover 
	 *
	 * @param string $nid
	 * @param string $speedView
	 * @param string $speedRemove
	 * @param string $altAnim
	 * @param string $speedTitle
	 * @param string $debug
	 * @param string $end
	 * @return string
	 */
	public static function iniRollover($nid=false, $speedView,$speedRemove,$altAnim=false,$speedTitle,$debug=false, $end=true){
			$hover = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
			$hover .= '.magicalHover({';
			$hover .= $speedView ? 'speedView:'.$speedView.',' : '';
			$hover .= $speedRemove ? 'speedRemove:'.$speedRemove.',' : '';
			$hover .= $altAnim ? 'altAnim:true' .',':'altAnim:false'.',';
			$hover .= $speedTitle ? 'speedTitle:'.$speedTitle.',' : '';
			$hover .= $debug ? 'debug:true' :'debug:false';
			$hover .= '})';
			$hover .= $end ? ';' : '';
		return $hover;
	}
}
?>