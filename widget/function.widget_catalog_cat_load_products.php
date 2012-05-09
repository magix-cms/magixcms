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
 * @copyright  MAGIX CMS Copyright (c) 2010 - 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 *
 */
/**
 * Smarty {load_catalog_category} function plugin
 *
 * Type:     function
 * Name:     load_catalog_category
 * Date:     
 * Update:   01-08-2011
 * Purpose:  
 * Examples: 
{widget_catalog_cat_load_products 
	css_param=[
		'class_container' => 'ch1-4 ch-light',
		'class_elem' => 'child',
		'class_box' => 'box',
  		'class_name' => 'name',
		'class_img' => 'img',
		'class_desc' => 'descr'
	]
	tposition="bottom" 
	price=false 
	description=false 
	size="mini" 
	col="4"
}
	
 * Output:   
 * @link 	http://www.magix-dev.be
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_catalog_cat_load_products($params, $template){
	//Variable de la langue
	$lang = $_GET['strLangue'] ? magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3):'';
	//Paramètres des classes CSS
	if (isset($params['css_param'])) {
		if(is_array($params['css_param'])){
			$tabs = $params['css_param'];
		}else{
			trigger_error("css_param is not array");
			return;
		}
	}else{
		$tabs= array(
			'class_container'=>'ch1-4 ch-light',
			'class_elem' => 'child',
			'class_box' => 'box',
	  		'class_name' => 'name',
			'class_img' => 'img',
			'class_desc' => 'descr'
		);
	}
	// Variables pour les class des éléments
	$class_container = ($tabs['class_container'] != null)? ' class="' . $tabs['class_container'] . '"' : '' ;
	$class_elem = ($tabs['class_elem'] != null)?  $tabs['class_elem'] : null ;
	$class_box = ($tabs['class_box'] != null)?  ' class="' . $tabs['class_box'] . '"' : '' ;
	$class_name = ($tabs['class_name'] != null)? ' class="' . $tabs['class_name'] . '"' : '' ;
	$class_img = ($tabs['class_img'] != null)? ' class="' . $tabs['class_img'] . '"' : '' ;
	$class_desc = ($tabs['class_desc'] != null)? ' class="' . $tabs['class_desc'] . '"' : '' ;
	//Test si lidentifiant de la catégorie existe
	if(isset($_GET['idclc'])){
		$idclc = magixcjquery_filter_isVar::isPostNumeric($_GET['idclc']);
	}
	//Test si lidentifiant de la sous catégorie existe
	if(isset($_GET['idcls'])){
		$idcls = magixcjquery_filter_isVar::isPostNumeric($_GET['idcls']);
	}
	// La taille des miniatures (mini ou medium)
	$size = $params['size'] ? $params['size'] :'mini';
	// Nombre de colonnes
	$last = $params['col']? $params['col'] : 0 ;
	// Position du titre
	$tposition = $params['tposition']? $params['tposition'] : 'top';
	//Affiche si le bien est vendu
	//$soldout = $params['soldout'];
	// Affiche le prix de l'article
	$price = $params['price'] ? true: false;
	// Parametre pour la description du produit
	$length = magixcjquery_filter_isVar::isPostNumeric($params['contentlength'])? $params['contentlength']: 100 ;
	// Le délimiteur pour tronqué le texte
	$delimiter = '...';
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
	/*$class_b = ' class="';
	$class_e = '"';*/
	$i = 1;
	$filter = new magixglobal_model_imagepath();
	if($lang){
		$product = null;
		if(frontend_db_block_catalog::s_product_in_category($idclc,$lang) != null){
			$product .= '<div'.$class_container.'>'."\n";
			foreach(frontend_db_block_catalog::s_product_in_category($idclc,$lang) as $cat){
				if ($i == $last ) {
					//$class= $class_b . 'last' . $class_e;
					$last_elem = ' last';
					$i = 1;
				} else {
					//$class= null;
					$last_elem = null;
					$i++;
				}
				$uri_product = magixglobal_model_rewrite::filter_catalog_product_url($lang,$cat['pathclibelle'],$cat['idclc'],null,null,$cat['urlcatalog'],$cat['idproduct'],true);
				$product .= '<div class="'. $class_elem . $last_elem .'">'."\n";
					$product .= '<div'. $class_box .'>'."\n";
					if($tposition == 'top'){
						$product .= '<p'.$class_name.'><a href="'.$uri_product.'">'.magixcjquery_string_convert::ucFirst($cat['titlecatalog']).'</a></p>';
					}
					if($cat['imgcatalog'] != null){
						$product .= '<a'.$class_img.' href="'.$uri_product.'"><img src="'.$filter->filterPathImg(array('filtermod'=>'catalog','img'=>$sizecapture.'/'.$cat['imgcatalog'],'levelmod'=>'product')).'" alt="'.$cat['titlecatalog'].'" /></a>';
					}else{
						$product .= '<a'.$class_img.' href="'.$uri_product.'"><img src="'.$filter->filterPathImg(array('img'=>'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog/no-picture.png')).'" alt="'.$cat['titlecatalog'].'" /></a>';
					}
					if($tposition == 'bottom'){
						$product .= '<p'.$class_name.'><a href="'.$uri_product.'">'.magixcjquery_string_convert::ucFirst($cat['titlecatalog']).'</a></p>';
					}
					if($description != false){
						if($cat['desccatalog'] != null){
							$product .= '<span'.$class_desc.'>'.magixcjquery_form_helpersforms::inputTagClean(magixcjquery_string_convert::cleanTruncate($cat['desccatalog'],$length,$delimiter)).'</span>';
						}
					}
					if($price != false){
						$product .= '<span class="price">€ '.number_format($cat['price'], 2, '.', ',').'</p>';
					}
					$product .= '</div>'."\n";
				$product .= '</div>'."\n";
			}
			$product .= '</div>'."\n";
		}
	}
	return $product;
}
 ?>
