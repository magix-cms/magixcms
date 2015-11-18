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
 * @package Video
 *
 */
class magixcjquery_url_video{
	/**
	 * Constante root youtube thumbnail
	 * @var IMG_YOUTUBE
	 */
	const IMG_YOUTUBE = 'http://img.youtube.com/vi/';
	/**
	 * Constante thumbnail small 1
	 * @var YOU_TUBE_SMALL_ONE
	 */
	const YOU_TUBE_SMALL_ONE = '/1.jpg';
	/**
	 * Constante thumbnail small 2
	 * @var YOU_TUBE_SMALL_TWO
	 */
	const YOU_TUBE_SMALL_TWO = '/2.jpg';
	/**
	 * Constante thumbnail big
	 * @var YOU_TUBE_BIG
	 */
	const YOU_TUBE_BIG = '/0.jpg';
	/**
	 * Constante root dailymotion
	 * @var IMG_DAILYMOTION
	 */
	const IMG_DAILYMOTION = 'http://www.dailymotion.com/thumbnail/160x120/video/';
	protected static $ytoptions = array('rel'=> true,
								'border' => false);
	/**
	 * Verify URL video
	 * @param $url
	 * @return string
	 */
	public static function checkout_url($url){
		if(magixcjquery_filter_isVar::isURL($url)){
			return $url;
		}else{
			throw new Exception('is not a valid URL');
		}
	}
	/**
	 * Analyse URL
	 * @param $str
	 * @return string
	 */
	private function analyse_uri($url){
		//extract HOST
		$parse = parse_url(self::checkout_url($url),PHP_URL_HOST);
		//substr = www.youtube.com (www. = 4) AND (.com == -4)
		if(substr($parse,4,-4) == "youtube"){
			$check =  'youtube';
		}
		//substr = www.dailymotion.com (www. = 4) AND (.com == -4)
		elseif(substr($parse,4,-4) == "dailymotion"){
			$check = 'dailymotion';
		}
		//return exception
		else{
			throw new Exception('is not a valid youtube params');
		}
		return $check;
	}
	/**
	 * Extract params in URL video
	 * @param $url
	 * @return string
	 */
	public static function extract_params($url){
		// 	After analysis, it extracts the URL specified for the type of video
		// We apply a method for each URL
		if(self::analyse_uri($url) == "youtube"){
			// example url = http://www.youtube.com/watch?v=4UB9fd4654
			$parse = parse_url($url, PHP_URL_QUERY);
			$params = substr($parse,2);
		}elseif(self::analyse_uri($url) == "dailymotion"){
			// example url = http://www.dailymotion.com/video/xav8yw_my-url-video
			$parse = parse_url($url, PHP_URL_PATH);
			$explode_uri = (explode('/', $parse));
			$extract_params = (explode('_', $explode_uri[2]));
			$params = $extract_params[0];
		}
		return $params;
	}
	/**
	 * @return direct url format for youtube
	 * @param string $url
	 * @return string
	 */
	public static function convert_video_url($url){
		if(self::analyse_uri($url) == "youtube"){
			return 'http://www.youtube.com/v/'.magixcjquery_url_video::extract_params($url);
		}elseif(self::analyse_uri($url) == "dailymotion"){
			return $url;
		}
	}
	/**
	 * Extract thumbnail url
	 * @param $url
	 * @param $size
	 * @return string thumbnail
	 */
	public static function extract_thumbnail($url,$size='small1'){
		$thumbnail = null;
		// IF youtube
		if(self::analyse_uri($url) == "youtube"){
			switch($size){
				case 'small1':
					$thumbnail .= self::IMG_YOUTUBE.self::extract_params($url).self::YOU_TUBE_SMALL_ONE;
				break;
				case 'small2':
					$thumbnail .= self::IMG_YOUTUBE.self::extract_params($url).self::YOU_TUBE_SMALL_TWO;
				break;
				case 'big':
					$thumbnail .= self::IMG_YOUTUBE.self::extract_params($url).self::YOU_TUBE_BIG;
				break;
			}
		}//IF DAILYMOTION
		elseif(self::analyse_uri($url) == "dailymotion"){
			$thumbnail .= self::IMG_DAILYMOTION.self::extract_params($url).'.jpg';
		}else{
			return false;
		}
		return $thumbnail;
	}
	/**
	 * @access public
	 * @static
	 * Options for Youtube params
	 * @param array $arrayopt
	 * @throws Exception
	 */
	public static function youTube_options($arrayopt=""){
		if($arrayopt == ""){
			$array = self::$ytoptions;
		}else{
			if(is_array($arrayopt))
				$array = $arrayopt;
			else throw new Exception('Error: arrayopt params is not array');
		}
		$para = "";
		if($array['rel'] == true){
			$para .= '&amp;rel=0';
		} 
		if($array['border'] == true){
			$para .= '&amp;border=1';
		} 
		return $para;
	}
	/**
	 * Classic galery video valid w3c
	 * @param void $array
	 * @param void $records
	 * @param integer $width
	 * @param integer $height
	 */
	private function youTube_Video($array,$records,$width=560,$height=340,$options=''){
		$video = null;
		if($options != ''){
			$opt = $options;
		}else{
			$opt = self::youTube_options();
		}
		if($array != null){
			foreach($array as $link){
				$video .= <<<EOT
				<div class="m-object-video">
				<object type="application/x-shockwave-flash" width="$width" height="$height" data="$link[$records]$opt">
				<param name="movie" value="$link[$records]" />
				<param name="wmode" value="transparent" />
				<param name="allowFullScreen" value="true" /><param name="allowScriptAccess" value="always" />
				</object>
				</div>
EOT;
			}
		}
		return $video;
	}
	/**
	 * @access public
	 * Contruct script object gallery
	 * @param array $array
	 * @param string $records
	 * @param integer $width
	 * @param integer $height
	 * @param array $options
	 * @throws Exception
	 */
	public static function v_construct_object_gallery($array,$records,$width,$height,$options=''){
		$url='';
		if(is_array($array)){
			if($array != null){
				foreach($array as $link){
					$url .= $link[$records];
				}
			}
			if(self::analyse_uri($url) == "youtube"){
				return self::youTube_Video($array,$records,$width,$height,$options);
			}elseif(self::analyse_uri($url) == "dailymotion"){
				
			}else{
				throw new Exception('Invalid format video');
			}
		}else{
			throw new Exception('Error: array params is not array');
		}
	}
	/**
	 * Activate animation in galery (lightbox,colorbox,fancyzoom,facebox,fancybox,pyrobox,...)
	 * @param $activate
	 * @param $nclass
	 * @return string
	 */
	public static function animated($activate=false,$nclass=null){
		 return $activate ? ' class="'.$nclass.'"':'';
	}
	/**
	 * create dynamic galery
	 * @param $array
	 * @param $path
	 * @param $records
	 * @return string
	 */
	public static function dynamic_galery($array,$path,$records,$thumb=null){
		$thumb = null;
		foreach($array as $link){
			$thumb .= '<a'.self::animated().' href="'.magixcjquery_html_helpersHtml::getUrl().$path.$link[$records].'.jpg">';
			$thumb .= '<img src="'.magixcjquery_html_helpersHtml::getUrl().$path.$thumb.$link[$records].'.jpg" />';
			$thumb .= '</a>';
		}
		return $thumb;
	}
}