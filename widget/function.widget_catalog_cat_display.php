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
 * http://www.magix-cms.com,  http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 *
 */
/**
 * Smarty {widget_catalog_cat_display title="" tposition="bottom" col="2" size="medium"} function plugin
 *
 * Type:     function
 * Name:     widget_catalog_cat_display
 * Date:     
 * Update:   01-08-2011 
 * Purpose:  
 * Examples: 
 * 			### BASIC ###
 				{widget_catalog_cat_display 
				css_param=[
					'id_container' => 'choose-id', 
					'class_container'=>'ch1-4 ch-light',
					'class_elem'=>'child',
					'class_name' => 'name',
					'class_img'=>'img',
					'class_desc'=>'descr'
				]
 				title="catalog categories" 
				tposition="bottom" 
 				col="2" 
 				description=true
				delimiter='...'
				lengt='250'}
				
  			### WITH SELECT ####
  				{widget_catalog_cat_display 
				css_param=[
					'id_container' => 'choose-id', 
					'class_container'=>'ch1-3 ch-light',
					'class_elem'=>'child',
					'class_name' => 'name',
					'class_img'=>'img',
					'class_desc'=>'descr'
				]
				idselect=['fr'=>['1','2'],'en'=>[0]]
 				title="catalog categories" 
				tposition="bottom" 
 				col="2" 
 				description=true
				delimiter='...'
				lengt='250'}
				
				### WITH EXCLUDE ####
				{widget_catalog_cat_display 
				css_param=[
					'id_container' => 'choose-id', 
					'class_container'=>'ch1-2 ch-light',
					'class_elem'=>'child',
					'class_name' => 'name',
					'class_img'=>'img',
					'class_desc'=>'descr'
				]
				idexclude=['fr'=>['1','2'],'en'=>[0]]
 				title="catalog categories" 
				tposition="bottom" 
 				col="2" 
 				description=true
				delimiter='...'
				lengt='250'}
 * Output:   
 * @link 	http://www.magix-dev.be
 * @author   Gerits Aurelien
 * @version  1.4
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_catalog_cat_display($params, $template){
//------------------ START  ------------------------
// CONSTRUCTION DE LA REQUETE SQL SUIVANT ARGUMENTS |
//--------------------------------------------------

	// | SELECTION DES CATEGORIES A AFFICHER (collection)
	// -------------------------------------------------
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
				$fct_sql = frontend_db_block_catalog::s_category_widget($lang, $idcat,'collection');	
			}else{
				$fct_sql = frontend_db_block_catalog::s_category_widget($lang);
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
				$fct_sql = frontend_db_block_catalog::s_category_widget($lang, $idcat,'exclude');	
			}else{
				$fct_sql = frontend_db_block_catalog::s_category_widget($lang);
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
		    $fct_sql = frontend_db_block_catalog::s_category_widget($lang);			
 	} 
//--------------------------------------------------
// CONSTRUCTION DE LA REQUETE SQL SUIVANT ARGUMENTS |
//-------------------- END - -----------------------


//------------------------- START ---------------------------------------
// RECUPERATION DES DONNEES A INSEREE (positionment, texte, class et id) |
//-----------------------------------------------------------------------

	// | RECUP ET AFFICHAGE |
	// ------------------------

	// Titre précédent l'affchage catégories si null vide
	$title = !empty($params['title'])?$params['title']:'';
	//Position du nom de le catégorie (bottom ou top) si null placer au dessus
	$tposition = $params['tposition']? $params['tposition'] : 'top';
	// Nombre de colones (utilisé pour l"ajout d'une class last par ligne)
	$last = $params['col']? $params['col'] : 0 ;
	// Activer ou non une description
	$description = !empty($params['description'])? true: false;
		// Longeur description du produit
		$length = magixcjquery_filter_isVar::isPostNumeric($params['length'])? $params['length']: 100 ;
		// Le délimiteur pour tronqué le texte
		$delimiter = $params['delimiter'] ? $params['delimiter'] : '';
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
				'id_container' => null,
				'class_container'=>'ch1-4 ch-light',
				'class_elem'=>'child',
				'class_name' => 'name',
				'class_img'=>'img',
				'class_desc'=>'desc'
			);
	}	
	// Variables pour les class des éléments
	$id_container =  ($tabs['id_container'] != null)? ' id="' . $tabs['id_container'] . '"' : '' ;
	$class_container = ($tabs['class_container'] != null)? ' class="' . $tabs['class_container'] . '"' : '' ;
	$class_elem = ($tabs['class_elem'] != null)?  $tabs['class_elem'] : null ;
	$class_name = ($tabs['class_name'] != null)? ' class="' . $tabs['class_name'] . '"' : '' ;
	$class_img = ($tabs['class_img'] != null)? ' class="' . $tabs['class_img'] . '"' : '' ;	
	$class_desc = ($tabs['class_desc'] != null)? ' class="' . $tabs['class_desc'] . '"' : '' ;	

//---------------------------------------------------------------------
// RECUPERATION DES DONNEES A INSEREE (positionment, texte, class et id) |
//------------------------- END ---------------------------------------

//--------------- START --------------------
//          FORMATAGE DU CONTENU            |
//------------------------------------------

	$i = 1; //Définis pour l'ajout de la class 'last'

	$block = $title;
	$filter = new magixglobal_model_imagepath();
	if ($fct_sql != null){

		$block .= '<div'. $id_container . $class_container .'>'."\n";
		foreach ($fct_sql as $cat) {

			// | CONSTRUCTION DES CLASS
			// ----------------------------		
			
				//Application de la class last pour enfant courant
				//-----------------------------------------------
				//Test si l'élément courant besoin class last			
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

			// | CONSTRUCTION DES ELEMENTS
			// ----------------------------		

				// Construction NOM catégorie
				//-----------------------------------
				$name_cat = '<p '. $class_name .'>';
					$name_cat .= '<a href="'.magixglobal_model_rewrite::filter_catalog_category_url($cat['iso'], $cat['pathclibelle'], $cat['idclc'],true).'">';
						$name_cat .= magixcjquery_string_convert::ucFirst($cat['clibelle']);
					$name_cat .= '</a>';
				$name_cat .= '</p>';

				// Construction IMAGE catégorie
				//----------------------------------------
				$img_cat = '<a '. $class_img .'  href="'.magixglobal_model_rewrite::filter_catalog_category_url($cat['iso'], $cat['pathclibelle'], $cat['idclc'],true).'">';
					if ($cat['img_c'] != null){					
					$img_cat .=	'<img src="'.$filter->filterPathImg(array('filtermod'=>'catalog','img'=>$cat['img_c'],'levelmod'=>'category')).'" alt="'.$cat['clibelle'].'" />';
				} else {
					$img_cat .= '<img src="'.$filter->filterPathImg(array('img'=>'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog/no-picture.png')).'" alt="'.$cat['clibelle'].'" />';
				}
				$img_cat .=	'</a>';

				// Construction Description catégorie
				//----------------------------------------
				$desc_cat = '<span '. $class_desc .'>';
					$desc_cat .= magixcjquery_form_helpersforms::inputTagClean(magixcjquery_string_convert::cleanTruncate($cat['c_content'],$length,$delimiter));
				$desc_cat .= '</span>';


			// | CONSTRUCTION ENFANT (class + elements)
			// ------------START----------------------		
			$block .= '<div'. $class_child .'>'."\n";
			if($tposition == 'top'){
				$block .= $name_cat;
			}
			$block .= $img_cat;
			if($tposition == 'bottom'){
				$block .= $name_cat;
			}
			if ($description != false) {
				$block .= $desc_cat;
			}
			$block .= '</div>'."\n";
			// | CONSTRUCTION ENFANT
			// ------------END-------------------							
		}
		$block .= '</div>'."\n";
	}
//------------------------------------------
//          FORMATAGE DU CONTENU            |
//---------------- END ---------------------
//ENVOIS DES DONNEES
	return $block;
}