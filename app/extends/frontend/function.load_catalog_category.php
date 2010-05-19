<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
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
function smarty_function_load_catalog_category($params, &$smarty){
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
	switch($lang){
			case 'fr':
			$langsession = 'catalogue';
				break;
			case 'en':
			$langsession = 'catalog';
				break;	
			case 'de':
			$langsession = 'katalog';
				break;
			case 'nl':
			$langsession = 'catalog';
				break;	
			default:
			$langsession = 'catalogue';	
	}
	if(isset($ui)){
		$wcontent = ' ui-widget-content ui-corner-all';
		$wheader = ' ui-widget-header ui-corner-all';
	}
	if(class_exists('frontend_plugins_immoSoldState')){
		$immostate = new frontend_plugins_immoSoldState();
	}
	if($lang){
			$product = null;
			if(frontend_db_catalog::publicDbCatalog()->s_category_page_with_language($idclc,$lang) != null){
				$product .= '<div id="catalog-list-category">';
				foreach(frontend_db_catalog::publicDbCatalog()->s_category_page_with_language($idclc,$lang) as $cat){
					$product .= '<div class="list-img-category'.$wcontent.'">';
					if($tposition == 'top'){
						$product .= '<div class="title-product'.$wheader.'"><a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$this->getlang.magixcjquery_html_helpersHtml::unixSeparator().self::session_language().magixcjquery_html_helpersHtml::unixSeparator().$cat['pathclibelle'].'-'.$cat['idclc'].magixcjquery_html_helpersHtml::unixSeparator().$cat['urlcatalog'].'-'.$cat['idcatalog'].'.html'.'">'.magixcjquery_string_convert::ucFirst($cat['titlecatalog']).'</a></div>';
					}
					if($cat['imgcatalog'] != null){
						$product .= '<div class="img-product">';
						$product .= '<a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$this->getlang.magixcjquery_html_helpersHtml::unixSeparator().$langsession.magixcjquery_html_helpersHtml::unixSeparator().$cat['pathclibelle'].'-'.$cat['idclc'].magixcjquery_html_helpersHtml::unixSeparator().$cat['urlcatalog'].'-'.$cat['idcatalog'].'.html'.'"><img src="'.magixcjquery_html_helpersHtml::getUrl().'/upload/catalogimg/'.$sizecapture.'/'.$cat['imgcatalog'].'" alt="'.$cat['titlecatalog'].'" /></a>';
						$product .= '</div>';
					}else{
						$product .= '<div class="img-product">';
						$product .= '<a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$this->getlang.magixcjquery_html_helpersHtml::unixSeparator().$langsession.magixcjquery_html_helpersHtml::unixSeparator().$cat['pathclibelle'].'-'.$cat['idclc'].magixcjquery_html_helpersHtml::unixSeparator().$cat['urlcatalog'].'-'.$cat['idcatalog'].'.html'.'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog'.magixcjquery_html_helpersHtml::unixSeparator().'no-picture.png'.'" alt="'.$cat['titlecatalog'].'" /></a>';
						$product .= '</div>';
					}
					if($tposition == 'bottom'){
						$product .= '<div class="title-product'.$wheader.'"><a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$this->getlang.magixcjquery_html_helpersHtml::unixSeparator().self::session_language().magixcjquery_html_helpersHtml::unixSeparator().$cat['pathclibelle'].'-'.$cat['idclc'].magixcjquery_html_helpersHtml::unixSeparator().$cat['urlcatalog'].'-'.$cat['idcatalog'].'.html'.'">'.magixcjquery_string_convert::ucFirst($cat['titlecatalog']).'</a></div>';
					}
					if($description != false){
						$product .= '<p>'.magixcjquery_form_helpersforms::inputTagClean(magixcjquery_string_convert::cleanTruncate($cat['desccatalog'],$length,$delimiter)).'</p>';
					}
					if($price != false){
						$product .= '<div class="bg-price">€ '.number_format($cat['price'], 2, '.', ',').'</div>';
					}
					$product .= '</div>';
				}
				$product .= '</div><div style="clear:left;"></div>';
			}
		}else{
			$product = null;
			if(frontend_db_catalog::publicDbCatalog()->s_category_page_no_language($idclc) != null){
				$product .= '<div id="catalog-list-category">';
				foreach(frontend_db_catalog::publicDbCatalog()->s_category_page_no_language($idclc) as $cat){
					$product .= '<div class="list-img-category'.$wcontent.'">';
					if($tposition == 'top'){
						$product .= '<div class="title-product'.$wheader.'"><a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$langsession.magixcjquery_html_helpersHtml::unixSeparator().$cat['pathclibelle'].'-'.$cat['idclc'].magixcjquery_html_helpersHtml::unixSeparator().$cat['urlcatalog'].'-'.$cat['idcatalog'].'.html'.'">'.magixcjquery_string_convert::ucFirst($cat['titlecatalog']).'</a></div>';
					}
					if($cat['imgcatalog'] != null){
						$product .= '<div class="img-product">';
						$product .= '<a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$langsession.magixcjquery_html_helpersHtml::unixSeparator().$cat['pathclibelle'].'-'.$cat['idclc'].magixcjquery_html_helpersHtml::unixSeparator().$cat['urlcatalog'].'-'.$cat['idcatalog'].'.html'.'"><img src="'.magixcjquery_html_helpersHtml::getUrl().'/upload/catalogimg/'.$sizecapture.'/'.$cat['imgcatalog'].'" alt="'.$cat['titlecatalog'].'" /></a>';
						$product .= '</div>';
					}else{
						$product .= '<div class="img-product">';
						$product .= '<a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$langsession.magixcjquery_html_helpersHtml::unixSeparator().$cat['pathclibelle'].'-'.$cat['idclc'].magixcjquery_html_helpersHtml::unixSeparator().$cat['urlcatalog'].'-'.$cat['idcatalog'].'.html'.'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog/no-picture.png'.'" alt="'.$cat['titlecatalog'].'" /></a>';
						$product .= '</div>';
					}
					if($tposition == 'bottom'){
						$product .= '<div class="title-product'.$wheader.'"><a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$langsession.magixcjquery_html_helpersHtml::unixSeparator().$cat['pathclibelle'].'-'.$cat['idclc'].magixcjquery_html_helpersHtml::unixSeparator().$cat['urlcatalog'].'-'.$cat['idcatalog'].'.html'.'">'.magixcjquery_string_convert::ucFirst($cat['titlecatalog']).'</a></div>';
					}
					if($immostate instanceof frontend_plugins_immoSoldState){
						if($immostate->select_immo_sold($cat['idcatalog']) != null){
							$product .= '<div class="'.$soldout.'"></div>';
						}
					}
					if($description != false){
						$product .= '<p>'.magixcjquery_form_helpersforms::inputTagClean(magixcjquery_string_convert::cleanTruncate($cat['desccatalog'],$length,$delimiter)).'</p>';
					}
					if($price != false){
						$product .= '<div class="bg-price">€ '.number_format($cat['price'], 2, '.', ',').'</div>';
					}
					$product .= '</div>';
				}
				$product .= '</div><div style="clear:left;"></div>';
			}
		}
	return $product;
}