<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Magix CMS.
# Magix CMS, a CMS optimized for SEO
# Copyright (C) 2010 - 2011  Gerits Aurelien <aurelien@magix-cms.com>
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
/**
 * MAGIX CMS
 * @category   extends
 * @package    Smarty
 * @subpackage function
 * @copyright  MAGIX CMS Copyright (c) 2011 - 2012 Gerits Aurelien,
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 *
 */
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {widget_social_network} function plugin
 *
 * Type:     function
 * Name:     widget_get_social
 * Date:     18-07-2011
 * Update:   01-08-2011
 * Purpose:  Display social bookmark
 * Examples:
     {widget_social_network 
  		config_param=[
  		'news'=>[{#topmenu_news_t#},$n_title],
  		'cms'=>[$title_page],
  		'catalog'=>[{#topmenu_catalog_t#},$clibelle,$slibelle,$titlecatalog],
  		'plugins'=>['contact'=>{#pn_contact_forms#}]
  		] size="medium" default=$subject}
 * Output:   
 * @link 	http://www.magix-dev.be
 * @author   Gerits Aurélien
 * @version  1.2
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_social_network($params, $template){
	$parsed = $_SERVER["REQUEST_URI"];
	//strrpos récupère la dernière occurence de / et de .
    $slashpos = strrpos($parsed,'/');
	/**
	 * Si size n'est pas défini on retourne une erreur
	 * @return string
	 */
	if (!isset($params['size'])) {
	 	trigger_error("Missing parameter :size");
	 	return;
	}
	$filename = substr($_SERVER['SCRIPT_NAME'],1);
	$position = strpos($filename, '.');
	$attribute = substr($filename, 0, $position);
	if(isset($_GET['magixmod'])){
		$magixmod = magixcjquery_filter_var::clean($_GET['magixmod']);
	}
	if (!isset($params['config_param'])) {
	 	trigger_error("config_param: missing 'config_param' parameter");
		return;
	}
	if(is_array($params['config_param'])){
		$tabs = $params['config_param'];
	}
	if($attribute == 'plugins'){
		$module = $attribute.':'.$magixmod;
	}else{
		$module = $attribute;
	}
	switch($attribute){
		case 'news':
			if(isset($_GET['getnews'])){
				$getitle = $tabs['news'][1];
			}else{
				$getitle = $tabs['news'][0];
			}
		break;
		case 'cms':
			if(isset($_GET['getidpage'])){
				$getitle = $tabs['cms'][0];
			}
		break;
		case 'catalog':
			if(isset($_GET['idclc'])){
				if(isset($_GET['idcls'])){
					$getitle = $tabs['catalog'][2];
				}elseif(isset($_GET['idproduct'])){
					$getitle = $tabs['catalog'][3];
				}else{
					$getitle = $tabs['catalog'][1];
				}
			}else{
				$getitle = $tabs['catalog'][0];
			}
		break;
		case 'plugins':
			if($tabs['plugins'][$magixmod]){
				$getitle = $tabs['plugins'][$magixmod];
			}else{
				$getitle = $magixmod;
			}
		break;
		default:
			$getitle = $params['default'];
		break;
	}
	/**
	 * Si le paramètre size est vide on retourne medium
	 * @var $paramSize string
	 */
	$paramSize = empty($params['size']) ? 'medium' : $params['size'];     
    $title = urlencode($getitle);
    $url = magixcjquery_html_helpersHtml::getUrl();
    $language = frontend_model_template::current_Language();
    $fbstr = 'http://www.facebook.com/share.php?u='.$url.$parsed;
    $twstr = 'http://twitthis.com/twit?url='.$url.$parsed.'&amp;title='.$title;
    $viastr = 'http://www.viadeo.com/shareit/share/?url='.$url.$parsed.'&amp;title='.$title.'&amp;overview='.$title;
        if(isset($paramSize)){ 
			if(isset($paramSize)){
				switch($paramSize){
					case 'small':
						$imgfb = '/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/socialnetwork/Facebook-16.png';
						$imgtw = '/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/socialnetwork/Twitter-1-16.png';
						$imgvia = '/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/socialnetwork/viadeo_16.png';
						break;
					case 'medium':
						$imgfb = '/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/socialnetwork/Facebook-32.png';
						$imgtw = '/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/socialnetwork/Twitter-1-32.png';;
						$imgvia = '/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/socialnetwork/viadeo_32.png';
						break;
					case 'large':
						$imgfb = '/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/socialnetwork/Facebook-48.png';
						$imgtw = '/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/socialnetwork/Twitter-1-48.png';;
						$imgvia = '/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/socialnetwork/viadeo_48.png';
						break;
					case 'special':
						$imgfb = '/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/socialnetwork/Facebook-16-special.png';
						$imgtw = '/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/socialnetwork/Twitter-1-16-special.png';
						$imgvia = '/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/socialnetwork/viadeo_16-special.png';
						break;
				}
			}
		    $arr = array($imgfb, $imgtw,$imgvia);
            $socialmenu = '<div id="getsocialize">';
            $socialmenu .= '<p>';
            $socialmenu .= "<a class='targetblank float-left' href='".$fbstr."'><img src='".$arr[0]."' alt='".$title."' title='Partager sur Facebook' /></a>";
            $socialmenu .= "<a class='targetblank float-left' href='".$twstr."'><img src='".$arr[1]."' alt='".$title."' title='Partager sur Twitter' /></a>";
            $socialmenu .= "<a class='targetblank float-left' href='".$viastr."'><img src='".$arr[2]."' alt='".$title."' title='Partager sur Viadeo' /></a>";
            $socialmenu .= "<a id='googlebtn' href='#'></a>";			
            $socialmenu .= "</p>";
            $socialmenu .= '</div>';
		}  
	return $socialmenu;
}