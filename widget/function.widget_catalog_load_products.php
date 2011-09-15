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
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 *
 */
/**
 * Smarty {widget_catalog_load_products 
				css_param=[
					'class_container'=>'',
					'class_elem'=>'',
					'class_img'=>''
				] tposition="bottom" description=true price=false size=medium col="4"} 
 * function plugin
 *
 * Type:     function
 * Name:     widget_catalog_load_products
 * Date:
 * Update:   01-08-2011      
 * Purpose:  
 * Examples: {widget_catalog_load_products 
				css_param=[
					'class_container'=>'list-div border w11-64 bg medium',
					'class_elem'=>'list-div-elem',
					'class_img'=>'img'
				] tposition="bottom" description=true size=medium col="4"}
 * Output:   
 * @link http://www.magix-dev.be
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_catalog_load_products($params, $template){
	//Variable de la langue
	$lang = $_GET['strLangue'] ? magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3):'';
	//Test si lidentifiant de la catégorie existe
	if(isset($_GET['idclc'])){
		$idclc = magixcjquery_filter_isVar::isPostNumeric($_GET['idclc']);
	}
	//Test si lidentifiant de la sous catégorie existe
	if(isset($_GET['idcls'])){
		$idcls = magixcjquery_filter_isVar::isPostNumeric($_GET['idcls']);
	}
	//Paramètres des classes CSS
	if (isset($params['css_param'])) {
		if(is_array($params['css_param'])){
			$tabs = $params['css_param'];
		}else{
			trigger_error("css_param is not array");
			return;
		}
	}else{
		$tabs= array('class_container'=>'list-div border w11-64 bg medium'
				,'class_elem'=>'list-div-elem'
				,'class_img'=>'img'
			);
	}
	// La taille des miniatures (mini ou medium)
	$size = $params['size']?$params['size']:'mini';
	// Nombre de colonnes
	$last = $params['col']? $params['col'] : 0 ;
	// Position du titre
	$tposition = $params['tposition']? $params['tposition'] : 'top';
	//Affiche si le bien est vendu
	//$soldout = $params['soldout'];
	// Affiche le prix de l'article
	$price = $params['price'] ? true : false;
	// Parametre pour la description du produit
	$length = magixcjquery_filter_isVar::isPostNumeric($params['contentlength'])? $params['contentlength']: 100 ;
	// Le délimiteur pour tronqué le texte
	$delimiter = $params['delimiter'] ? $params['delimiter'] : '...';
	// Activer ou non une description
	$description = !empty($params['description'])? true: false;
	switch($size){
		case 'medium':
			$sizecapture = 'medium';
		break;
		case 'mini':
			$sizecapture = 'mini';
		break;
	}
	$class_b = ' class="';
	$class_e = '"';
	$i = 1;
	$imgPath = new magixglobal_model_imagepath('catalog');
	if($lang){
		$product = null;
		if(frontend_db_block_catalog::s_sub_category_page($idclc,$idcls,$lang) != null){
			$product .= '<div class="'.$tabs['class_container'].'">';
			foreach(frontend_db_block_catalog::s_sub_category_page($idclc,$idcls,$lang) as $cat){
				if ($i == $last ) {
					$class= $class_b . 'last' . $class_e;
					$last_elem = ' last';
					$i = 1;
				} else {
					$class= null;
					$last_elem = null;
					$i++;
				}
				$uri_product = magixglobal_model_rewrite::filter_catalog_product_url($lang,$cat['pathclibelle'],$cat['idclc'],$cat['pathslibelle'],$cat['idcls'],$cat['urlcatalog'],$cat['idproduct'],true);
				$product .= '<div class="'.$tabs['class_elem'].$last_elem.'">';
				if($tposition == 'top'){
					$product .= '<p class="name"><a href="'.$uri_product.'">'.magixcjquery_string_convert::ucFirst($cat['titlecatalog']).'</a></p>';
				}
				if($cat['imgcatalog'] != null){
					$product .= '<a class="'.$tabs['class_img'].'" href="'.$uri_product.'"><img src="'.$imgPath->filter_path_img('product',$sizecapture.'/'.$cat['imgcatalog']).'" alt="'.$cat['titlecatalog'].'" /></a>';
				}else{
					$product .= '<a class="'.$tabs['class_img'].'" href="'.$uri_product.'"><img src="/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog/no-picture.png'.'" alt="'.$cat['titlecatalog'].'" /></a>';
				}
				if($tposition == 'bottom'){
					$product .= '<p class="name"><a href="'.$uri_product.'">'.magixcjquery_string_convert::ucFirst($cat['titlecatalog']).'</a></p>';
				}
				if($description != false){
					if($cat['desccatalog'] != null){
						$product .= '<span class="descr">'.magixcjquery_form_helpersforms::inputTagClean(magixcjquery_string_convert::cleanTruncate($cat['desccatalog'],$length,$delimiter)).'</span>';
					}
				}
				if($price != false){
					$product .= '<p class="price">€ '.number_format($cat['price'], 2, '.', ',').'</p>';
				}
				$product .= '</div>';
			}
			$product .= '</div>';
		}
	}
	return $product;
}
 ?>