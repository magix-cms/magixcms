<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {microgalery type="galleriffic"} function plugin
 *
 * Type:     function
 * Name:     microgalery
 * Date:     January 27 2010
 * Purpose:  
 * Examples: {microgalery}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 *
 */
function smarty_function_microgalery($params, &$smarty){
	$type = $params['type'];
	$ui = $params['ui']?true:false;
	if(isset($_GET['idcatalog'])){
		$idcatalog = magixcjquery_filter_isVar::isPostNumeric($_GET['idcatalog']);
	}
	switch ($type){
		case 'imagebox':
			$count = frontend_db_catalog::publicDbCatalog()->count_image_in_galery_product($idcatalog);
			$galery = null;
			if($count['cimage'] != 0){
			$galery .= '<div id="list-image-galery">';
			foreach(frontend_db_catalog::publicDbCatalog()->s_microgalery_product($idcatalog) as $img){
				if($ui){
					$galery .= '<div class="list-img ui-widget-content ui-corner-all">';
					$galery .= '<div class="title-galery-image ui-widget-header ui-corner-all"></div>';
					$galery .= '<div class="img-galery"><a class="imagebox" rel="microgalery" href='.'"'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/galery/maxi/'.$img['imgcatalog'].'">'.'<img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/galery/mini/'.$img['imgcatalog'].'" alt="'.$img['imgcatalog'].'" /></a>'.'</div>';
					$galery .= '</div>';
				}else{
					$galery .= '<div class="list-img">';
					$galery .= '<div class="title-galery-image"></div>';
					$galery .= '<div class="img-galery"><a class="imagebox" rel="microgalery" href='.'"'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/galery/maxi/'.$img['imgcatalog'].'">'.'<img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/galery/mini/'.$img['imgcatalog'].'" alt="'.$img['imgcatalog'].'" /></a>'.'</div>';
					$galery .= '</div>';
				}
			}
			$galery .= '<div style="clear:both;"></div></div>';
			}
		break;
	}
	return $galery;
}