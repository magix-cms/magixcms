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
 * Examples: {load_catalog_category 
				css_param=[
					'class_container'=>'list-div w5-32 bg dark',
					'class_elem'=>'list-div-elem',
					'class_img'=>'img'
				] 
				category=["fr"=>"1"] 
				limit_products="4" size="medium" tposition="bottom" description=false}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.2
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_load_catalog_category_last_products($params, $template){
  //Définir la catégorie à afficher (defaut cat=0)
	if (!isset($params['category'])) {
	 	trigger_error("config_param: missing 'category' parameter");
		return;
	}
	if(is_array($params['category'])){
		$tabscat = $params['category'];
	}
  foreach(frontend_db_lang::s_fetch_lang() as $l){
	  if($l['iso'] == frontend_model_template::current_Language()){
	  	 $p_lang = $l['iso'];
	  	 $idcat = $tabscat[$p_lang]; 
	  } 
  }
  //Définir le nombre de produits à afficher (defaut limit_products=5)
  $limit_products = $params['limit_products']? $params['limit_products'] : 5 ;
  //Définir le titre à afficher
  $title = $params['title']? $params['title'] : null ;
    
  // si je recois la catégorie par url, la cat affichée = url
  if(isset($_GET['idclc'])){
    $idclc = magixcjquery_filter_isVar::isPostNumeric($_GET['idclc']);
  } else {
    $idclc = $idcat;
  }
  // La taille des miniatures (mini ou medium)
  $size = $params['size']?$params['size']:'mini';
  // Position du titre
  $tposition = $params['tposition']? $params['tposition'] : 'top';
  //Affiche si le bien est vendu
  $soldout = $params['soldout'];
  // Affiche le prix de l'article
  $price = $params['price'] ? true: false;
  // Nombre de colonnes
	$last = $params['col'] ? $params['col'] : 0 ;
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
	//Paramètres des classes CSS
	if (isset($params['css_param'])) {
		if(is_array($params['css_param'])){
			$tabs = $params['css_param'];
		}else{
			trigger_error("css_param is not array");
			return;
		}
	}else{
		$tabs= array('class_container'=>'ch1-2 ch-light',
				'class_elem'=>'child',
				'class_img'=>'img'
			);
	}
	$class_b = ' class="';
	$class_e = '"';
	$ilast = 1;
      $product = null; 
      $filter = new magixglobal_model_imagepath();
      if(frontend_db_block_catalog::s_product_category_by_date($idclc,frontend_model_template::current_Language()) != null){
        //Récupère la nombre de produits existants 
        $nb_products = count( frontend_db_block_catalog::s_product_category_by_date($idclc,frontend_model_template::current_Language()) );
        //si le nombre de produits éxistant est inférieur à la limite imposée alors la limite est le nombre de produits existant
        $end = ($nb_products > $limit_products) ? $limit_products : $nb_products ;     
        $product .= '<div class="'.$tabs['class_container'].'">';
        $product .= '<div class="catalog-list-products">';
          if($title != null){
            $product .= '<p class="title">' . $title . '</p>' ;          
          }  
          $i = 0;
          do {
			if ($ilast == $last ) {
				$class= $class_b . 'last' . $class_e;
				$last_elem = ' last ';
				$ilast = 1;
			} else {
				$class= null;
				$last_elem = null;
				$ilast++;
			}	          
          $cat =  frontend_db_block_catalog::s_product_category_by_date($idclc,frontend_model_template::current_Language());
          $cat = $cat[$i];
          if($cat['idcls'] != 0){
          	 $uri_product = magixglobal_model_rewrite::filter_catalog_product_url($cat['iso'], $cat['pathclibelle'], $cat['idclc'],$cat['pathslibelle'], $cat['idcls'], $cat['urlcatalog'], $cat['idproduct'],true);
          }else{
          	 $uri_product = magixglobal_model_rewrite::filter_catalog_product_url($cat['iso'], $cat['pathclibelle'], $cat['idclc'],null, null, $cat['urlcatalog'], $cat['idproduct'],true);
          }
          $product .= '<div class="'.$tabs['class_elem'].$last_elem.'">';
          if($tposition == 'top'){
            $product .= '<p class="name"><a href="'.$uri_product.'" title="'.$cat['titlecatalog'].'">'.magixcjquery_string_convert::ucFirst($cat['titlecatalog']).'</a></p>';
          }
          if($cat['imgcatalog'] != null){
            $product .= '<a class="'.$tabs['class_img'].'" href="'.$uri_product.'" title="'.$cat['titlecatalog'].'"><img src="'.$filter->filterPathImg(array('filtermod'=>'catalog','img'=>$sizecapture.'/'.$cat['imgcatalog'],'levelmod'=>'product')).'" alt="'.$cat['titlecatalog'].'" title="'.$cat['titlecatalog'].'" /></a>';
          }else{
            $product .= '<a class="'.$tabs['class_img'].'"  href="'.$uri_product.'"><img src="'.$filter->filterPathImg(array('img'=>'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog/no-picture.png')).'" alt="'.$cat['titlecatalog'].'" /></a>';
          }
          if($tposition == 'bottom'){
            $product .= '<p class="name"><a href="'.$uri_product.'" title="'.$cat['titlecatalog'].'">'.magixcjquery_string_convert::ucFirst($cat['titlecatalog']).'</a></p>';
          }
          if($description != false){
          	if($cat['desccatalog'] != null){
           		$product .= '<span class="descr">'.magixcjquery_form_helpersforms::inputTagClean(magixcjquery_string_convert::cleanTruncate($cat['desccatalog'],$length,$delimiter)).'</span>';
          	}
          }
          if($price != false){
            $product .= '<span class="price">€ '.number_format($cat['price'], 2, '.', ',').'</span>';
          }
          $product .= '</div>';
          $i++;
         } while($i < $end);          
        $product .= '</div>';
        $product .= '<div class="clear"></div>';
        $product .= '</div>';
      }
  return $product;
}