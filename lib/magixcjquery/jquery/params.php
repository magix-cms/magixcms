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
 * @access private
 * @copyright clashdesign
 * @version 0.1
 * @package jQuery params
 *
 */
require dirname(__FILE__).'/interfaces/IextendParams.php';
class magixcjquery_jquery_params{
	/**
	 * ini var
	 *
	 * @var bool
	 */
	private static $each;
	/**
	 * function construc class
	 *
	 */
	function __construct(){}
	/**
	 * ini method each params
	 *
	 * @return void
	 */
	private function eachMethod(){
    	return self::$each = new forEachParams();
    }
    function this(){
    	return 'this';
    }
	/**
	 * function name
	 *
	 * @param string $name
	 * @return void
	 */
	function name($name){
		return $name;
	}
	/**
	 * function properties
	 *
	 * @param string $properties
	 * @return void
	 */
	function properties($properties){
		return $properties;
	}
	/**
	 * function eachMethod
	 *
	 * @return void
	 */
	function each(){
		return self::eachMethod();
	}
	/**
	 * function forProperties
	 *
	 * @param string $properties
	 * @return void
	 */
	function forProperties($properties){
		return self::each()->eachProperties($properties);
	}
	/**
	 * function forOptions
	 *
	 * @param string $properties
	 * @return void
	 */
	function forOptions($options){
		return self::each()->eachOptions($options);
	}
	/**
	 * function forOptions
	 *
	 * @param string $properties
	 * @return void
	 */
	function forSpecialOptions($options){
		return self::each()->eachSpecialOptions($options);
	}
	/**
	 * function forSimpleValue (while simple value with double quote)
	 *
	 * @param string $value
	 * @return void
	 */
	function forSimpleValue($value){
		return self::each()->eachSimpleValue($value);
	}
	/**
	 * function forValue
	 *
	 * @param string $value
	 * @return void
	 */
	function forValue($value){
		return self::each()->eachValue($value);
	}
	/**
	 * function forUIOptions
	 *
	 * @param string $opt
	 * @return void
	 */
	function forUIOptions($opt){
		return self::each()->eachUIOptions($opt);
	}
	/**
	 * function forUIValue
	 *
	 * @param string $opt
	 * @return void
	 */
	function forUIValue($opt){
		return self::each()->eachUIValue($opt);
	}
	/**
	 * function keyval
	 *
	 * @param string $keyval
	 * @return void
	 */
	function keyval($keyval){
		return self::each()->eachValue($keyval);
	}
	/**
	 * function key
	 *
	 * @param string $key
	 * @param string $function
	 * @return void
	 */
	function key($key,$function){
		return $key.','.$function;
	}
	/**
	 * function jclass
	 *
	 * @param string $class
	 * @return void
	 */
	function jclass($class){
		return $class;
	}
	/**
	 * function content
	 *
	 * @param string $content
	 * @return void
	 */
	function content($content){
		return $content;
	}
	/**
	 * function value
	 *
	 * @param string $content
	 * @return void
	 */
	function value($value){
		return $value;
	}
	/**
	 * function speed params
	 *
	 * @param $speed
	 * @return void
	 */
	function speed($speed){
		return $speed;
	}
	/**
	 * function callback params
	 *
	 * @param $callback
	 * @return void
	 */
	function callback($callback){
		return $callback;
	}
	/**
	 * function end
	 *
	 * @return string
	 */
	function end(){
		return ';';
	} 
}
/**
 * final class for implements foreach value and foreach properties
 *
 */
final class forEachParams implements IextendParams{
	/**
     * function each value separate by commat width doublequote
     *
     * @param array() $value
     * @return array
     */
    public function eachSimpleValue($value = array()){
    	
    	foreach ($value as $val){
    		$tabs[] = '"'.$val.'"';
    	}
    return implode(',',$tabs);
    }
    /**
     * function each value separate by commat
     *
     * @param array() $value
     * @return array
     */
    public function eachValue($value = array()){
    	
    	foreach ($value as $key=>$val){
    		$tabs[] = '"'.$key.'"';
    		$tabs[] .= '"'.$val.'"';
    	}
    return implode(',',$tabs);
    }
    /**
	 * function each properties separate by two point and commat
	 *
	 * @param array $properties
	 * @param string $val
	 * @return array
	 */
	public function eachProperties($properties = array()){
    	
    	foreach ($properties as $key => $val){
    		$tabs[] = '"'.$key.'"'.':'.'"'.$val.'"';
    	}
    return implode(',',$tabs);
    }
    /**
	 * function each properties separate by two point and commat
	 *
	 * @param array $properties
	 * @param string $val
	 * @return array
	 */
	public function eachOptions($options = array()){
    	
    	foreach ($options as $key => $val){
    		$tabs[] = $key .':'.'"'.$val.'"';
    	}
    return implode(',',$tabs);
    }
    /**
	 * function each properties separate by two point and no quote
	 *
	 * @param array $options
	 * @param string $val
	 * @return array
	 */
	public function eachSpecialOptions($options = array()){
    	
    	foreach ($options as $key => $val){
    		$tabs[] = $key .':'.$val;
    	}
    return implode(',',$tabs);
    }
    /**
	 * function each properties separate by two point and no quote
	 *
	 * @param array $properties
	 * @param string $val
	 * @return array
	 */
	public function eachUIOptions($opt = array()){
    	
    	foreach ($opt as $key => $val){
    		$tabs[] = $key.':'.$val;
    	}
    return implode(',',$tabs);
    }
    /**
     * function each value separate by commat no doublequote
     *
     * @param array() $value
     * @return array
     */
    public function eachUIValue($value = array()){
    	
    	foreach ($value as $val){
    		$tabs[] = $val;
    	}
    return implode(',',$tabs);
    }
}
?>