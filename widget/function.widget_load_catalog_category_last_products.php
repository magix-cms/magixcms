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
 * Smarty {load_catalog_category} function plugin
 *
 * Type:     function
 * Name:     load_catalog_category
 * Date:     
 * Purpose:  
 * Examples: {load_catalog_category size="medium" tposition="bottom" description=false}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_load_catalog_category_last_products($params, $template){
  //Définir la catégorie à afficher (defaut cat=0)
  $idcat = $params['idcat'] ? $params['idcat'] : 0 ;
  foreach (frontend_db_lang::s_fetch_lang() as $l ) {      
     if (frontend_model_template::current_Language() == $l['iso']){
       $p_lang = 'idcat_'. $l['iso'];
       $idcat = $params[$p_lang];        
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
  // Utilise jquery UI (true/false)
  $ui = $params['ui'];
  // La taille des miniatures (mini ou medium)
  $size = $params['size']?$params['size']:'mini';
  // Position du titre
  $tposition = $params['tposition']? $params['tposition'] : 'top';
  //Affiche si le bien est vendu
  $soldout = $params['soldout'];
  // Affiche le prix de l'article
  $price = $params['price']?true:false;
  // Nombre de colonnes
	$last = $params['col']? $params['col'] : 0 ;
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
  
  if(isset($ui)){
    switch($ui){
      case "true":
        $wcontent = ' ui-widget-content ui-corner-all';
        $wheader = ' ui-widget-header ui-corner-all';
      break;
      case "false":
        $wcontent = '';
        $wheader = '';
      break;
    }
  }else{
    $wcontent = '';
    $wheader = '';
  }
	$class_b = ' class="';
	$class_e = '"';
	$ilast = 1;
      $product = null; 
      if(frontend_db_block_catalog::s_product_category_by_date($idclc,frontend_model_template::current_Language()) != null){
        //Récupère la nombre de produits existants 
        $nb_products = count( frontend_db_block_catalog::s_product_category_by_date($idclc,frontend_model_template::current_Language()) );
        //si le nombre de produits éxistant est inférieur à la limite imposée alors la limite est le nombre de produits existant
        $end = ($nb_products > $limit_products) ? $limit_products : $nb_products ;     
        $product .= '<div class="list-div w5-32 bg dark"><div class="catalog-list-products">';
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
          $product .= '<div class="list-div-elem'.$last_elem.$wcontent.'">';
          if($tposition == 'top'){
            $product .= '<p class="name"><a href="'.$uri_product.'" title="'.$cat['titlecatalog'].'">'.magixcjquery_string_convert::ucFirst($cat['titlecatalog']).'</a></p>';
          }
          if($cat['imgcatalog'] != null){
            $product .= '<a  class="img" href="'.$uri_product.'" title="'.$cat['titlecatalog'].'"><img src="'.magixcjquery_html_helpersHtml::getUrl().'/upload/catalogimg/'.$sizecapture.'/'.$cat['imgcatalog'].'" alt="'.$cat['titlecatalog'].'" title="'.$cat['titlecatalog'].'" /></a>';
          }else{
            $product .= '<a  class="img"  href="'.$uri_product.'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog'.magixcjquery_html_helpersHtml::unixSeparator().'no-picture.png'.'" alt="'.$cat['titlecatalog'].'" /></a>';
          }
          if($tposition == 'bottom'){
            $product .= '<p class="name"><a href="'.$uri_product.'" title="'.$cat['titlecatalog'].'">'.magixcjquery_string_convert::ucFirst($cat['titlecatalog']).'</a></p>';
          }
          if($description != false){
            $product .= '<span class="descr">'.magixcjquery_form_helpersforms::inputTagClean(magixcjquery_string_convert::cleanTruncate($cat['desccatalog'],$length,$delimiter)).'</span>';
          }
          if($price != false){
            $product .= '<span class="price">€ '.number_format($cat['price'], 2, '.', ',').'</span>';
          }
          $product .= '</div>';
          $i++;
         } while($i < $end);          
        $product .= '</div></div>';
      }
  return $product;
}