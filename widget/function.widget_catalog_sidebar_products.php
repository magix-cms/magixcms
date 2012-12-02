<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2012 sc-box.com <support@magix-cms.com>
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com> <contact@aurelien-gerits.be>
 #
 # Redistributions of files must retain the above copyright notice.
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

 # DISCLAIMER

 # Do not edit or add to this file if you wish to upgrade MAGIX CMS to newer
 # versions in the future. If you wish to customize MAGIX CMS for your
 # needs please refer to http://www.magix-cms.com for more information.
 */
/**
 * MAGIX CMS
 * @category   extends 
 * @package    Smarty
 * @subpackage function
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com,  http://www.magix-cjquery.com
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
 * Smarty {widget_catalog_sidebar_products} function plugin
 *
 * Type:     function
 * Name:     widget_catalog_sidebar_products
 * Date:     18 juillet 2011
 * Update:   8 Aout 2011
 * Purpose:  
 * Examples: {widget_catalog_sidebar_products
			css_param=[
				'id_container' => 'catalog-hierarchy',
				'class_container'=>'treeview',
				'class_active'=>'active-page',
				'class_close' => 'closed'
			] idexclude=['fr'=>['1,3'],'en'=>['7']]}
			OR
			{widget_catalog_sidebar_products
			css_param=[
				'id_container' => 'catalog-hierarchy',
				'class_container'=>'treeview',
				'class_active'=>'active-page',
				'class_close' => 'closed'
			] idselect=['fr'=>['1','2'],'en'=>[0]]}
 * Output:   
 * @link 	http://www.magix-dev.be
 * @author   Gerits Aurelien
 * @version  1.5
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_catalog_sidebar_products($params, $template){
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
			// Récupération de la langue courante
			$lang =  frontend_model_template::current_Language();
			// Placement de la requête avec attributs dans la variable (collection = WHERE catalog.idclc IN ($idcat)  
		    if($idcat != 0){
				$fct_sql = frontend_db_block_catalog::s_category_menu($lang, $idcat,'collection');	
			}else{
				$fct_sql = frontend_db_block_catalog::s_category_menu($lang);
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
			/* Récupération de la langue courante */
			$lang =  frontend_model_template::current_Language();
			/* Placement de la requête avec attributs dans la variable (collection = WHERE catalog.idclc NOT IN ($idcat)*/   
		    if($idcat != 0){
				$fct_sql = frontend_db_block_catalog::s_category_menu($lang, $idcat,'exclude');	
			}else{
				$fct_sql = frontend_db_block_catalog::s_category_menu($lang);
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
			$lang =  frontend_model_template::current_Language();
		    $fct_sql = frontend_db_block_catalog::s_category_menu($lang);			
 	}
	// | PARAMETRAGE DES CLASS ET ID CSS |
	// ----------------------------------
	// Récupération des paramètres de class  et id
	//---------------------------------------

	if (isset($params['css_param'])) {
		if(is_array($params['css_param'])){
			$tabs = $params['css_param'];
		}else{
			trigger_error("css_param is not array");
			return;
		}
	}else{
		$tabs= array(
				'id_container' => 'catalog-hierarchy',
				'class_container'=>'treeview',
				'class_active'=>'active-page',
				'class_close' => 'closed'
			);
	}	
	// Variables pour les class des éléments
	$id_container =  ($tabs['id_container'] != null)? ' id="' . $tabs['id_container'] . '"' : '' ;
	$class_container = ($tabs['class_container'] != null)? ' class="' . $tabs['class_container'] . '"' : '' ;
	$class_active = ($tabs['class_active'] != null)?  ' class="' . $tabs['class_active']  . '"' : '' ;
	$class_close = ($tabs['class_close'] != null)? ' class="' . $tabs['class_close'] . '"' : '' ;
	$getidclc = magixcjquery_filter_isVar::isPostNumeric($_GET['idclc']);
	$getproduct = magixcjquery_filter_isVar::isPostNumeric($_GET['idproduct']);
	if(!isset($getidclc)){
			$display = " style='display:none;'";
	}else{
			$display= '';
	}
	$wmenu = '';
	if($fct_sql != null){
 		$wmenu .='<ul'. $id_container . $class_container .'>'."\n";
		foreach($fct_sql as $cat){
			if(isset($getidclc)){
				if($getidclc === $cat['idclc']){
					$active = '';
					$active_link = $class_active;
					
				}else{
					$active = $class_close;
					$active_link = '';
				} 
			}
			$wmenu .= '<li'.$active.'><a href="'.magixglobal_model_rewrite::filter_catalog_category_url(frontend_model_template::current_Language(),$cat['pathclibelle'],$cat['idclc'],true).'" ' . $active_link . '><span>'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</span></a>'."\n";
			if(frontend_db_block_catalog::s_category_product_menu(frontend_model_template::current_Language(),$cat['idclc']) != null){
				$wmenu .= '<ul' . $display . '>';
				foreach(frontend_db_block_catalog::s_category_product_menu(frontend_model_template::current_Language(),$cat['idclc']) as $prod){	
					if(isset($getproduct)){
						if($getproduct === $prod['idproduct']){
							$currentpage = $class_active;
						}else{
							$currentpage = '';
						}  
					}
					$wmenu .= '<li><a'.$currentpage.' href="'.magixglobal_model_rewrite::filter_catalog_product_url(
							frontend_model_template::current_Language(),
							$prod['pathclibelle'],
							$prod['idclc'],
							null,
							null,
							$prod['urlcatalog'],
							$prod['idproduct'],
							true
						).'"><span>'.magixcjquery_string_convert::ucFirst($prod['titlecatalog']);
					$wmenu .= '</span></a></li>'."\n";	
				}
				$wmenu .= '</ul>';
			}
			$wmenu .= "</li>\n"; 
		}
		$wmenu .='</ul>'."\n";
	}
	return $wmenu;
}