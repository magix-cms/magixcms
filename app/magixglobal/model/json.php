<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 magix-cms.com <support@magix-cms.com>
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com> <contact@aurelien-gerits.be>
 #
 # Redistributions of files must retain the above copyright notice.
 # This program is free software: you can redistribute it and/or modify
 # it under the terms of the GNU General Public License as published by
 # the Free Software Foundation, either version 3 of the License, or
 # (at your option) any later version.
 #
 # This program is distributed in the hope that it will be useful,
 # but WITHOUT ANY WARRANTY; without even the implied warranty of
 # MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 # GNU General Public License for more details.

 # You should have received a copy of the GNU General Public License
 # along with this program.  If not, see <http://www.gnu.org/licenses/>.
 #
 # -- END LICENSE BLOCK -----------------------------------

 # DISCLAIMER

 # Do not edit or add to this file if you wish to upgrade MAGIX CMS to newer
 # versions in the future. If you wish to customize MAGIX CMS for your
 # needs please refer to http://www.magix-cms.com for more information.
 */
/**
 * MAGIX CMS
 * @category   Model 
 * @package    magixglobal
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <gerits.aurelien@gmail.com>
 * @name JSON
 *
 */
class magixglobal_model_json{
	private function stack_error(){
		if (version_compare(phpversion(),'5.3','>')) {
			switch (json_last_error()) {
		        case JSON_ERROR_NONE:
		            $error =  'No errors';
		        break;
		        case JSON_ERROR_DEPTH:
		            $error =  'Maximum stack depth exceeded';
		        break;
		        case JSON_ERROR_STATE_MISMATCH:
		            $error =  'Underflow or the modes mismatch';
		        break;
		        case JSON_ERROR_CTRL_CHAR:
		            $error =  'Unexpected control character found';
		        break;
		        case JSON_ERROR_SYNTAX:
		            $error =  'Syntax error, malformed JSON';
		        break;
		        case JSON_ERROR_UTF8:
		            $error =  'Malformed UTF-8 characters, possibly incorrectly encoded';
		        break;
		        default:
                	$error = '';
		        break;
	    	}
	    	if (!empty($error)){
            	throw new Exception('JSON Error: '.$error);       
	    	}
		}
	}
	private function array_delete_key($array,$search,$debug) {
		//$temp = array();
		foreach($array as $key =>$subarr) {
			if (isset($subarr[$search])) {
				unset($array[$key][$search]);
			}
			/*if($key!=$search) {
				/*if($key!=$search) {
			 		$temp[$key] = $value;
				}*/
				/*unset($array[$search]);
			}else{
				//trigger_error('Error key is not exist: '.$search); 
			}*/
		}
		return $array;
	}
	public function array_replace_key($array,$search) {
		$temp = '';
		/*foreach($array as $key => $value) {
			$firebug = new magixcjquery_debug_magixfire();
			$firebug->magixFireGroup('key replace test');
			$firebug->magixFireLog($value);
			$firebug->magixFireGroupEnd();
			 if($key == $search) {
			 	return str_replace($search, $temp, 'test');
			 }
		}*/
		//$firebug = new magixcjquery_debug_magixfire();
		foreach($array as $key) {
			//$firebug->magixFireLog($key['n_content']);
			if(array_key_exists($search, $key)){
	            //$temp[] = str_replace($search, $key[$search], 'test');
	            $temp[]= $key[$search];
			}else{
				$temp[]= $key;
			}
		}
		return $temp;
	}
	public function tabs_json_encode($params,$arg=array('item'=>'','action'=>''),$debug=false){
		/*if(is_array($params)){
			$result = array();
			foreach ($params as $key){
				if($debug!=false){
					$firebug = new magixcjquery_debug_magixfire();
					$firebug->magixFireDump('Dump json encode', $params);
				}
				if($exclude != ''){
					$tabs = $this->array_delete_key($key, $exclude,$debug);
				}else{
					$tabs = $key;
				}
				$result[]= json_encode($tabs);
			}
			$this->stack_error();
			return $result;
		}*/
		if(is_array($params)){
			$firebug = new magixcjquery_debug_magixfire();
			if($debug!=false){
				$firebug->magixFireDump('Dump json encode', $params);
			}
			foreach($params as $key => $val) {
				if($arg['action'] != ''){
					switch($arg['action']){
						case 'delete':
							if (isset($val[$arg['item']])) {
								unset($params[$key][$arg['item']]);
							}
						break; 
						/*case 'replace':
							if (isset($val[$arg['item']])) {
								if($params[$key][$arg['item']] != null){
									$params[$key][$arg['item']] = $arg['replace'][0];
								}else{
									$params[$key][$arg['item']] = $arg['replace'][1];
								}
							}
						break;*/
					}
					/*if (isset($val[$exclude])) {
						if($params[$key][$exclude] != null){
							$params[$key][$exclude] = '1';
						}else{
							$params[$key][$exclude] = '0';
						}
					}*/
				}
				$tabs = $params[$key];
				$result[]= json_encode($tabs);
			}
			$this->stack_error();
			return $result;
		}else{
			throw new Exception('tabs json is not array :'.$params);
		}
	}
	/**
	 * @access public
	 * Encode le tableau en format JSON
	 * @param array $json_tabs
	 * @param array $glue
	 * Exemple : 
	 * $json = new magetools_model_json();
			$json->encode(
				$json->tabs_json_encode($json_tabs,
				array(
					'item'=>'','action'=>'',array(1,0))
				),
				array('[',']')
			);
	 */
	public function encode($json_tabs,$glue=array('[',']')){
		if(is_array($json_tabs)){
			print $glue[0].implode(',',$json_tabs).$glue[1];
		}
	}
}
?>