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
 * @package jQuery CSS manipulation
 *
 */
require('interfaces/interface.magixCss.php');
class magixcjquery_jquery_css extends magixcjquery_jquery_params implements ImagixCss {
	/**
	 * jquery attr function
	 * style property on the first matched element or all matched element
	 *
	 * @param string $var
	 * @param string $nid
	 * @param string $name
	 * @param array $properties
	 * @return string
	 */
	public static function jCss($nid=false,$seq='name',$params=true, $end=true){
		$css = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		switch($seq){
			case 'value':
				$css .= $params ? '.css('.parent::forValue($params) : '';
				break;
			case 'options':
				$css .= $params ? '.css({'.parent::forOptions($params).'}' : '';
				break;
			case 'name':
				$css .= $params ? '.css("'.parent::name($params).'"' : '';
				break;
		}
		$css .= ')';
		$css .= $end ? ';' : '';
		return $css;
	}
	/**
	 * jQuery height function
	 *
	 * @param string $var
	 * @param string $nid
	 * @param string $value
	 * @return string
	 */
	public static function jHeight($nid=false, $value=false, $end=true){
		$css = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$css .= '.height(';
		$css .= $value ? parent::value($value) : '';
		$css .= ')';
		$css .= $end ? ';' : '';
		return $css;
	}
	/**
	 * jQuery width function
	 *
	 * @param string $var
	 * @param string $nid
	 * @param string $value
	 * @return string
	 */
	public static function jWidth($nid=false, $value=false, $end=true){
		$css = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$css .= '.width(';
		$css .= $value ? parent::value($value) : '';
		$css .= ')';
		$css .= $end ? ';' : '';
		return $css;
	}
}
//class eachParamsCss extends magixCss {
	/**
	 * function each properties separate by two point and commat
	 *
	 * @param array $properties
	 * @param string $val
	 * @return array
	 */
/*	public function eachProperties($properties = array()){
    	
    	foreach ($properties as $key => $val){
    		$tabs[] = '"'.$key.'"'.':'.'"'.$val.'"';
    	}
    return implode(',',$tabs);
    }*/
    /**
     * function each value separate by commat
     *
     * @param array() $value
     * @return array
     */
 /*   public function eachValue($value = array()){
    	
    	foreach ($value as $key=>$val){
    		$tabs[] = '"'.$key.'"';
    		$tabs[] .= '"'.$val.'"';
    	}
    return implode(',',$tabs);
    }
}*/
?>