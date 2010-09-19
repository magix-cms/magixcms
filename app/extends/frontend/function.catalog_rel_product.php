<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
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
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_catalog_rel_product($params, &$smarty){
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
	//$rel = '';
	/*foreach(frontend_db_catalog::publicDbCatalog()->s_catalog_rel_product($idcatalog) as $prod){
		$info = frontend_db_catalog::publicDbCatalog()->s_catalog_product_info($prod['idproduct']);
		$rel .= '<a href="';
		$rel .= magixglobal_model_rewrite::filter_catalog_product_url($lang,$info['pathclibelle'],$info['idclc'],$info['urlcatalog'],$info['idproduct'],true);
		$rel .= '">';
		$rel .= $info['titlecatalog'];
		$rel .= '</a>';
	}*/
	$product = null;
	if(frontend_db_catalog::publicDbCatalog()->s_catalog_rel_product($idcatalog) != null){
		$product .= '<div id="catalog-list-category">';
		foreach(frontend_db_catalog::publicDbCatalog()->s_catalog_rel_product($idcatalog) as $prod){
			$cat = frontend_db_catalog::publicDbCatalog()->s_catalog_product_info($prod['idproduct']);
			$product .= '<div class="list-img-category'.$wcontent.'">';
			if($tposition == 'top'){
				$product .= '<div class="title-product'.$wheader.'"><a href="'.magixglobal_model_rewrite::filter_catalog_product_url($lang,$cat['pathclibelle'],$cat['idclc'],$cat['urlcatalog'],$cat['idproduct'],true).'">'.magixcjquery_string_convert::ucFirst($cat['titlecatalog']).'</a></div>';
			}
			if($cat['imgcatalog'] != null){
				$product .= '<div class="img-product">';
				$product .= '<a href="'.magixglobal_model_rewrite::filter_catalog_product_url($lang,$cat['pathclibelle'],$cat['idclc'],$cat['urlcatalog'],$cat['idproduct'],true).'"><img src="'.magixcjquery_html_helpersHtml::getUrl().'/upload/catalogimg/'.$sizecapture.'/'.$cat['imgcatalog'].'" alt="'.$cat['titlecatalog'].'" /></a>';
				$product .= '</div>';
			}else{
				$product .= '<div class="img-product">';
				$product .= '<a href="'.magixglobal_model_rewrite::filter_catalog_product_url($lang,$cat['pathclibelle'],$cat['idclc'],$cat['urlcatalog'],$cat['idproduct'],true).'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog'.magixcjquery_html_helpersHtml::unixSeparator().'no-picture.png'.'" alt="'.$cat['titlecatalog'].'" /></a>';
				$product .= '</div>';
			}
			if($tposition == 'bottom'){
				$product .= '<div class="title-product'.$wheader.'"><a href="'.magixglobal_model_rewrite::filter_catalog_product_url($lang,$cat['pathclibelle'],$cat['idclc'],$cat['urlcatalog'],$cat['idproduct'],true).'">'.magixcjquery_string_convert::ucFirst($cat['titlecatalog']).'</a></div>';
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
	return $product;
}