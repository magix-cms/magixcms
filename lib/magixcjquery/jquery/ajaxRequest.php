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
 * @package jQuery AJAX JQUERY Request
 *
 */
require('interfaces/interface.iAjaxRequest.php');
class magixcjquery_jquery_ajaxRequest extends magixcjquery_jquery_params implements iAjaxRequest {
	/**
	 * class jQuery Ajax Request and ajaxForm
	 *
	 * @return jQuery Request
	 */
	public static function ajax($type ,$url ,$data='' ,$async=false , $before=false ,$success=false, $bParam=false, $param=false){
		$ajax = magixcjquery_jquery_magixcjQuery::getjQueryHandling().'.ajax({';
		$ajax .= $type ? 'type: "'.$type.'",' : '';
		$ajax .= $url ? 'url: "'.$url.'",' : '';
		$ajax .= $data ? 'data: '.$data.',' : '';
		$ajax .= $async ? 'async :true '.',' : '';
		$ajax .= $before ? 'beforeSend: function('.$bParam.'){'.$before.'},' : 'beforeSend: function(){},';
		$ajax .= $success ? 'success: function('.$param.'){ '.$success.'}' : 'success: function(){}';
		$ajax .= '});'."\n";
		return $ajax;
	}
	/**
	 * function simple get ajax
	 *
	 * @param string $url
	 * @param string $data
	 * @return string
	 */
	public static function ajaxGet($url ,$data=false,$callback=false,$param=false){
		$ajax = magixcjquery_jquery_magixcjQuery::getjQueryHandling().'.get(';
		$ajax .= $url ? '"'. $url . '"': '';
		$ajax .= $data ? ',{'.parent::forSpecialOptions($data).'}' : '';
		$ajax .= $callback ? ',function('.$param.'){ '.$callback.'}' : '';
		$ajax .= ');'."\n";
		return $ajax;
	}
	/**
	 * function simple POST ajax
	 *
	 * @param string $url
	 * @param string $data
	 * @return string
	 */
	public static function ajaxPost($url ,$data=false,$callback=false,$param=false){
		$ajax = magixcjquery_jquery_magixcjQuery::getjQueryHandling().'.post(';
		$ajax .= $url ? '"'. $url . '"': '';
		$ajax .= $data ? ',{'.parent::forSpecialOptions($data).'}' : '';
		$ajax .= $callback ? ',function('.$param.'){ '.$callback.'}' : '';
		$ajax .= ');'."\n";
		return $ajax;
	}
	/**
	 * function load Ajax
	 *
	 * @param string $nid (id)
	 * @param string $url (target)
	 * @param string $limit (option) exemple limit: 25
	 * @param string $success (return optionnel)
	 * @return string
	 */
	public static function ajaxLoad($nid ,$url ,$limit=false ,$paramsuccess=false ,$success=false){
		$ajax = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$ajax .= '.load(';
		$ajax .= $url ? '"'. $url . '"': '';
		$ajax .= $limit ? ',{'. $limit . '}': '';
		$ajax .= $success ? ',function('.$paramsuccess.'){ '.$success.'}' : '';
		$ajax .= ');'."\n";
		return $ajax;
	}
	/**
	 * function Global ajax with Form plugin
	 *
	 * @param string $nid
	 * @param string $type
	 * @param string $url
	 * @param string $before
	 * @param string $success
	 */
	public static function ajaxForm($nid, $type ,$url ,$clearForm=false , $bParam=false ,$beforeSubmit ,$sParam=false ,$success,$urlplus=false){
		$ajax = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$ajax .= '.ajaxForm({';
		$ajax .= $type ? 'type: "'.$type.'",' : '';
		$ajax .= $url ? 'url: "'.$url.'",' : '';
		$ajax .= $clearForm ? 'clearForm:true '.$clearForm.',' : '';
		$ajax .= $beforeSubmit ? 'beforeSubmit: function('.$bParam.'){'.$beforeSubmit.'},' : '';
		//$ajax .= $async ? 'async:"true" '.',' : 'async:"false"'.',';
		$ajax .= $success ? 'success: function('.$sParam.'){'.$success.'}' : 'success: function(){}';
		$ajax .= '});'."\n";
		return $ajax;
	}
	/**
	 * function getJson ajax
	 *
	 * @param string $url
	 * @param string $data
	 * @return string
	 */
	public static function getJson($url ,$data=false,$callback=false,$param=false,$encode='noencode'){
		$ajax = magixcjquery_jquery_magixcjQuery::getjQueryHandling().'.getJSON(';
		$ajax .= $url ? '"'. $url . '"': '';
		switch ($encode) {
			case 'noencode':
				$ajax .= $data ? ',{'.parent::forSpecialOptions($data).'}' : '';
				break;
			case 'encode':
				$ajax .= $data ? ','.json_encode($data) : '';
				break;
		}
		$ajax .= $callback ? ',function('.$param.'){ '.$callback.'}' : '';
		$ajax .= ');';
		return $ajax;
	}
	/**
	 * function serialize Forms
	 *
	 * @param string $nid (ID)
	 * @return string
	 */
	public static function ajaxSerialize($nid, $end=true){
		$ajax = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$ajax .= '.serialize()';
		$ajax .= $end ? ';' : '';
		return $ajax;
	}
	/**
	 * function serializeArray Forms
	 *
	 * @param string $nid (ID)
	 * @return string
	 */
	public static function ajaxSerializeArray($nid, $end=true){
		$ajax = $nid ? magixcjquery_jquery_magixcjQuery::getjQueryHandling().'('.$nid.')' : '';
		$ajax .= '.serializeArray()';
		$ajax .= $end ? ';' : '';
		return $ajax;
	}
}
/*class eachParamsRequest extends magixAjaxRequest {
	/**
	 * function each properties separate by commat
	 *
	 * @param array $properties
	 * @param string $val
	 * @return array
	 */
	/*public function eachProperties($properties = array()){
    	
    	foreach ($properties as $key=>$val){
    		$tabs[] = '"'.$key.'"'.':'.'"'.$val.'"';
    	}
    return implode(',',$tabs);
    }
}*/
?>