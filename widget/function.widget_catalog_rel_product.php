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
 * Smarty {catalog_rel_product} function plugin
 *
 * Type:     function
 * Name:     Produits liés avec le produit courant
 * Date:     September 20, 2010
 * Update:   8 Aout 2011
 * Purpose:  
 * Examples: 
 * 		### BASIC ###
 * 			{widget_catalog_rel_product 
				idcatalog=$idcatalog 
				css_param=[
					'id_container'=>'',
					'class_container'=>'list-div medium bg light',
					'class_elem'=>'list-div-elem',
					'class_name' => 'name',
					'class_img'=>'img',
					'class_desc'=>'descr',
					'class_price'=>'price'
				]
				col="1" 
				description=true 
				contentlength="124" 
				size="medium" 
				tposition="bottom"}
				
		### WITH EXCLUDE ####	
			{widget_catalog_rel_product 
				idcatalog=$idcatalog 
				css_param=[
					'id_container'=>'',
					'class_container'=>'list-div medium bg light',
					'class_elem'=>'list-div-elem',
					'class_name' => 'name',
					'class_img'=>'img',
					'class_desc'=>'descr',
					'class_price'=>'price'
				]
				idexclude=['fr'=>['1,3'],'en'=>['7']]
				col="1" 
				description=true 
				contentlength="124" 
				size="medium" 
				tposition="bottom"}
				
			### WITH SELECT ####	
				{widget_catalog_rel_product 
				idcatalog=$idcatalog 
				css_param=[
					'id_container'=>'',
					'class_container'=>'list-div medium bg light',
					'class_elem'=>'list-div-elem',
					'class_name' => 'name',
					'class_img'=>'img',
					'class_desc'=>'descr',
					'class_price'=>'price'
				]
				idselect=['fr'=>['1,3'],'en'=>['7']]
				col="1" 
				description=true 
				contentlength="124" 
				size="medium" 
				tposition="bottom"}
 * Output:   
 * @link http://www.magix-cms.com
 * @author   Gerits Aurelien
 * @version  1.5
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_catalog_rel_product($params, $template){
	if(isset($params['idcatalog'])){
		$idcatalog = $params['idcatalog'];
	}else{
		trigger_error("idcatalog is not defined");
	}
if (isset($params['idselect'])) {
		// Vérifie que les id sont bien placé en tableau (niv1 les langes)
		if(is_array($params['idselect'])){
			// Placement des entrées dans une variable
			$tabscat = $params['idselect'];	
			//Tri des entrées suivant la langue courante
			foreach(frontend_db_lang::s_fetch_lang() as $l){
			  if($l['iso'] == frontend_model_template::current_Language()){
			  	 $p_lang = $l['iso'];
			  	 $idselect = $tabscat[$p_lang];
				 // Vérifie que les id sont bien placés en tableau (niv2  id dans les langes)
				 if(is_array($idselect)){
				 	$idcat = implode (',', $idselect);
				 }else{
				 	//----------------- ERROR ---------------------------
					//Si mes id ne sont pas dans un tableau (niv2  id dans les langes)
					$error_return = 'idselect is not an array (id in isolang)<br />';
					$error_return .= '<strong>EXPECTED</strong> : idselect=[\'en\' => <strong>[\'1\',\'2\']</strong>, \'fr\' => <strong>[\'3\']</strong>] ]<br />';				
					trigger_error($error_return);
					return;
				 }
			  } 
		  	}
			// Placement de la requête avec attributs dans la variable (collection = WHERE catalog.idclc IN ($idcat)  
		    if($idcat != 0){
				$fct_sql = frontend_db_block_catalog::s_catalog_rel_product($idcatalog, $idcat,'collection');	
			}else{
				$fct_sql = frontend_db_block_catalog::s_catalog_rel_product($idcatalog);
			}			
		}else{
			//----------------- ERROR ---------------------------
			//Si mes id ne sont pas dans un tableau (niv1 les langes)
			$error_return = 'idselect is not an array (isolang)<br />';
			$error_return .= 'EXPECTED : idselect=<strong>[\'en\'</strong> => [\'1\',\'2\'], <strong>\'fr\'</strong> => [\'3\']<strong>]</strong> or idselect=<strong>[\'en\'</strong> => [\'1\',\'2\'] <strong>]</strong>';		
			trigger_error($error_return);
			return;			
		}
	// | EXCLUSION DES CATEGORIES A NE PAS AFFICHER (exclude)
	// -------------------------------------------------		
	}elseif (isset($params['idexclude'])) {
		// Vérifie que les id sont bien placé en tableau (niv1 les langes)
		if (is_array($params['idexclude'])) {
			 // Placement des entrées dans une variable
			$tabscat = $params['idexclude'];
			//Tri des entrées suivant la langue courante
			foreach(frontend_db_lang::s_fetch_lang() as $l){
			  if($l['iso'] == frontend_model_template::current_Language()){
			  	 $p_lang = $l['iso'];
			  	 $idexclude = $tabscat[$p_lang]; 
				 // Vérifie que les id sont bien placés en tableau (niv2  id dans les langues)
				 if(is_array($idexclude)){				 
				 	$idcat = implode (',', $idexclude);
				 }else{
				 	//----------------- ERROR ---------------------------
					//Si mes id ne sont pas dans un tableau (niv2  id dans les langues)
					$error_return = 'idexclude is not an array (id in isolang)<br />';
					$error_return .= '<strong>EXPECTED</strong> : idexclude=[\'en\' => <strong>[\'1\',\'2\']</strong>, \'fr\' => <strong>[\'3\']</strong>] ]<br />';				
					trigger_error($error_return);
					return;
				 }
			  } 
		  	}
			/* Placement de la requête avec attributs dans la variable (collection = WHERE catalog.idclc NOT IN ($idcat)*/   
			 if($idcat != 0){
				$fct_sql = frontend_db_block_catalog::s_catalog_rel_product($idcatalog, $idcat,'exclude');	
			}else{
				$fct_sql = frontend_db_block_catalog::s_catalog_rel_product($idcatalog);
			}	
		}else{
			//----------------- ERROR ---------------------------
			//Si mes id ne sont pas dans un tableau (niv1 les langes)
			$error_return = 'idexclude is not an array (isolang)<br />';
			$error_return .= 'EXPECTED : idexclude=<strong>[\'en\'</strong> => [\'1\',\'2\'], <strong>\'fr\'</strong> => [\'3\']<strong>]</strong> or idexclude=<strong>[\'en\'</strong> => [\'1\',\'2\'] <strong>]</strong>';		
			trigger_error($error_return);
			return;						
		}
	// | COMPORTEMENT DE BASE AFFICHAGE DE TOUTES LES CATEGORIES (null)
	// ---------------------------------------------------------------		
	}else {
		$fct_sql = frontend_db_block_catalog::s_catalog_rel_product($idcatalog);			
 	}
	//Variable de la langue
	$lang = frontend_model_template::current_Language();
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
			'id_container' => null,
			'class_container'=>'list-div medium bg light',
			'class_elem'=>'list-div-elem',
			'class_name' => 'name',
			'class_img'=>'img',
			'class_desc'=>'descr',
			'class_price'=>'price'
		);
	}
	// Variables pour les class des éléments
	$id_container =  ($tabs['id_container'] != null)? ' id="' . $tabs['id_container'] . '"' : '' ;
	$class_container = ($tabs['class_container'] != null)? ' class="' . $tabs['class_container'] . '"' : '' ;
	$class_elem = ($tabs['class_elem'] != null)?  $tabs['class_elem'] : null ;
	$class_name = ($tabs['class_name'] != null)? ' class="' . $tabs['class_name'] . '"' : '' ;
	$class_img = ($tabs['class_img'] != null)? ' class="' . $tabs['class_img'] . '"' : '' ;	
	$class_desc = ($tabs['class_desc'] != null)? ' class="' . $tabs['class_desc'] . '"' : '' ;	
	$class_price = ($tabs['class_price'] != null)? ' class="' . $tabs['class_price'] . '"' : '' ;	
	
	// La taille des miniatures (mini ou medium)
	$size = $params['size']?$params['size']:'mini';
	// Nombre de colonnes
	$last = $params['col']? $params['col'] : 0 ;
	// Position du titre
	$tposition = $params['tposition']? $params['tposition'] : 'top';
	//Affiche si le bien est vendu
	$soldout = $params['soldout'];
	// Affiche le prix de l'article
	$price = $params['price'] ? true : false;
	// Parametre pour la description du produit
	$length = magixcjquery_filter_isVar::isPostNumeric($params['contentlength'])? $params['contentlength']: 100 ;
	// Le délimiteur pour tronqué le texte
	$delimiter = $params['delimiter'] ? $params['delimiter'] : '';
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
	$imgPath = new magixglobal_model_imagepath('catalog');
	$product = null;
	$i = 1;
	if($fct_sql != null){
		$product .= '<div'. $id_container . $class_container .'>';
		foreach($fct_sql as $prod){
			if ($i == $last ) {
				$last_elem = ' last';
				$i = 1;
			} else {
				$last_elem = null;
				$i++;
			}
			//Formatage class pour enfant courant
			//------------------------------
			// Si on ne lui retire pas sa classe
			if ($class_elem != null) {
				$class_child = ' class="'. $class_elem . $last_elem .'"';
			//Si on lui retire sa class mais qu'il est le dernier élément de la ligne
			} elseif( $last_elem != null) {
				$class_child = ' class="'.$last_elem .'"';
			//Si pas de class et pas le dernier élément de la ligne
			} else {
				$class_child = null;
			}	
			$cat = frontend_db_block_catalog::s_catalog_product_info($prod['idproduct']);
			$uri_product = magixglobal_model_rewrite::filter_catalog_product_url($lang,$cat['pathclibelle'],$cat['idclc'],$cat['pathslibelle'],$cat['idcls'],$cat['urlcatalog'],$cat['idproduct'],true);
			$product .= '<div'.$class_child.'>';
			if($tposition == 'top'){
				$product .= '<p class="name"><a href="'.$uri_product.'">'.magixcjquery_string_convert::ucFirst($cat['titlecatalog']).'</a></p>';
			}
			if($cat['imgcatalog'] != null){
				$product .= '<a'.$class_img.' href="'.$uri_product.'"><img src="'.$imgPath->filter_path_img('product',$sizecapture.'/'.$cat['imgcatalog']).'" alt="'.$cat['titlecatalog'].'" /></a>';
			}else{
				$product .= '<a'.$class_img.' href="'.$uri_product.'"><img src="/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog/no-picture.png'.'" alt="'.$cat['titlecatalog'].'" /></a>';
			}
			if($tposition == 'bottom'){
				$product .= '<p'.$class_name.'><a href="'.$uri_product.'">'.magixcjquery_string_convert::ucFirst($cat['titlecatalog']).'</a></p>';
			}
			if($description != false){
				$product .= '<span'.$class_desc.'>'.magixcjquery_form_helpersforms::inputTagClean(magixcjquery_string_convert::cleanTruncate($cat['desccatalog'],$length,$delimiter)).'</span>';
			}
			if($price != false){
				$product .= '<span'.$class_price.'>€ '.number_format($cat['price'], 2, '.', ',').'</span>';
			}
			$product .= '</div>';
		}
		$product .= '<div class="clear"></div>';
		$product .= '</div>';
	}
	return $product;
}