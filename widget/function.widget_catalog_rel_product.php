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
 * Smarty {catalog_rel_product} function plugin
 *
 * Type:     function
 * Name:     Produits liés avec le catalogue
 * Date:     September 20, 2010
 * Purpose:  
 * Examples: {catalog_rel_product idcatalog=""}
 * Output:   
 * @link http://www.magix-cms.com
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_catalog_rel_product($params, $template){
//Variable de la langue
	$lang = $_GET['strLangue'] ? magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3):'';
	//Test si lidentifiant de la catégorie existe
	if(isset($_GET['idclc'])){
		$idclc = magixcjquery_filter_isVar::isPostNumeric($_GET['idclc']);
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
	$idcatalog = $params['idcatalog'];
	$product = null;
	if(frontend_db_block_catalog::s_catalog_rel_product($idcatalog) != null){
		$product .= '<div class="list-div medium bg light">';
		foreach(frontend_db_block_catalog::s_catalog_rel_product($idcatalog) as $prod){
			$cat = frontend_db_block_catalog::s_catalog_product_info($prod['idproduct']);
			$uri_product = magixglobal_model_rewrite::filter_catalog_product_url($lang,$cat['pathclibelle'],$cat['idclc'],$cat['pathslibelle'],$cat['idcls'],$cat['urlcatalog'],$cat['idproduct'],true);
			$product .= '<div class="list-div-elem'.$wcontent.'">';
			if($tposition == 'top'){
				$product .= '<p class="name'.$wheader.'"><a href="'.$uri_product.'">'.magixcjquery_string_convert::ucFirst($cat['titlecatalog']).'</a></p>';
			}
			if($cat['imgcatalog'] != null){
				$product .= '<a class="img" href="'.$uri_product.'"><img src="'.magixcjquery_html_helpersHtml::getUrl().'/upload/catalogimg/'.$sizecapture.'/'.$cat['imgcatalog'].'" alt="'.$cat['titlecatalog'].'" /></a>';
			}else{
				$product .= '<a class="img" href="'.$uri_product.'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog'.magixcjquery_html_helpersHtml::unixSeparator().'no-picture.png'.'" alt="'.$cat['titlecatalog'].'" /></a>';
			}
			if($tposition == 'bottom'){
				$product .= '<p class="name'.$wheader.'"><a href="'.$uri_product.'">'.magixcjquery_string_convert::ucFirst($cat['titlecatalog']).'</a></p>';
			}
			if($description != false){
				$product .= '<span class="descr">'.magixcjquery_form_helpersforms::inputTagClean(magixcjquery_string_convert::cleanTruncate($cat['desccatalog'],$length,$delimiter)).'</span>';
			}
			if($price != false){
				$product .= '<span class="price">€ '.number_format($cat['price'], 2, '.', ',').'</span>';
			}
			$product .= '</div>';
		}
		$product .= '</div><div style="clear:left;"></div>';
	}
	return $product;
}