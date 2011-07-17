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
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 *
 */
/**
 * Smarty {microgalery type="galleriffic"} function plugin
 *
 * Type:     function
 * Name:     microgalery
 * Date:     January 27 2010
 * Purpose:  
 * Examples: {microgalery}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 *
 */
function smarty_function_widget_catalog_microgalery($params, $template){
	$type = $params['type'];
	$ui = $params['ui']?true:false;
	$last = $params['col']? $params['col'] : 0 ;
	if(isset($_GET['idproduct'])){
		$idproduct = magixcjquery_filter_isVar::isPostNumeric($_GET['idproduct']);
	}
	switch ($type){
		case 'imagebox':
			$identifier =  frontend_db_block_catalog::s_identifier_catalog($idproduct);
			$count = frontend_db_block_catalog::count_image_in_galery_product($identifier['idcatalog']);
			$galery = null;
			
			$i = 1;
			$class_b = ' class="';
			$class_e = '"';
			
			if($count['cimage'] != 0){
			$galery .= '<ul class="list-li img medium">';
			foreach(frontend_db_block_catalog::s_microgalery_product($identifier['idcatalog']) as $img){
/*					$galery .= '<ul class="list-li img medium">';
					$galery .= '<div class="title-galery-image ui-widget-header ui-corner-all"></div>';*/
					if ($i == $last ) {
						$class= $class_b . 'last' . $class_e;
						$i = 1;
					} else {
						$class= null;
						$i++;
					}
									
					$galery .= '<li'. $class .'><a class="imagebox img" rel="microgalery" href='.'"'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/galery/maxi/'.$img['imgcatalog'].'">'.'<img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/galery/mini/'.$img['imgcatalog'].'" alt="'.$img['imgcatalog'].'" /></a>'.'</li>';
			}
			$galery .= '</ul>';
			}
		break;
		case 'cloud-zoom':
			$identifier =  frontend_db_block_catalog::s_identifier_catalog($idproduct);
			$count = frontend_db_block_catalog::count_image_in_galery_product($identifier['idcatalog']);
			$galery = null;		
			if($count['cimage'] != 0){
			$galery .= '<div id="list-image-galery">';
			foreach(frontend_db_block_catalog::s_microgalery_product($identifier['idcatalog']) as $img){
				if($ui){
					$galery .= '<div class="list-img ui-widget-content ui-corner-all">';
					$galery .= '<div class="img-galery"><a class="cloud-zoom-gallery" rel="useZoom: \'zoom1\', smallImage: \' '. magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/galery/maxi/'.$img['imgcatalog']. ' \' " href='.'"'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/galery/maxi/'.$img['imgcatalog'].'">'.'<img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/galery/mini/'.$img['imgcatalog'].'" alt="'.$img['imgcatalog'].'" /></a>'.'</div>';
					$galery .= '</div>';			
				
				}else{
					$galery .= '<div class="list-img">';
					$galery .= '<div class="img-galery"><a class="cloud-zoom-gallery" rel="useZoom: \'zoom1\', smallImage: \' '. magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/galery/maxi/'.$img['imgcatalog']. ' \' " href='.'"'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/galery/maxi/'.$img['imgcatalog'].'">'.'<img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/galery/mini/'.$img['imgcatalog'].'" alt="'.$img['imgcatalog'].'" /></a>'.'</div>';
					$galery .= '</div>';
				}
			}
			$galery .= '</div>';					
			$galery .= 	'<a href="'. magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/galery/maxi/'.$img['imgcatalog'] . '" class = \'cloud-zoom\' id=\'zoom1\' rel="adjustX: 6, adjustY:0, zoomWidth:410">
    					<img src="'.  magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/galery/maxi/'.$img['imgcatalog'] .' " alt="'.$img['imgcatalog'].'" width="240" class="cible" />
    					</a>' ;
			}
		break;
	}
	return $galery;
}