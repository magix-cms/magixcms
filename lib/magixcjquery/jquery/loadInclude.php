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
 * @package jQuery execute
 *
 */
class magixcjquery_jquery_loadInclude{
/**
 * function include <script> script file </script>
 *
 * @param string $url
 * @param array $js
 * @return string
 */
	public static function jsArray($url,$js=array()){
		$jsload = '';
		foreach ($js as $javascript){
			$jsload .= '<script type="text/javascript" src="'.$url.$javascript.'.js"></script>'."\n";
		}
		return $jsload;
    }
    /**
     * function include script file with jquery where array()
     *
     * @param string $url
     * @param array $js
     */
    public static function getScriptArray($url,$js=array()){
    	$jsload = '';
		$count = count($js);
		for($i=0;$i<$count;$i++){
			$jsload .= magixcjquery_jquery_magixcjQuery::getjQueryHandling().'.getScript("'.$url.$js[$i].'.js");';
		}
		return $jsload;
    }
}