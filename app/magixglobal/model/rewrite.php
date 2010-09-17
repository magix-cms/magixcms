<?php
/**
 * MAGIX CMS
 * @category   Model 
 * @package    magixglobal
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name rewrite
 *
 */
class magixglobal_model_rewrite{
	/**
	 * @access private
	 * Reecriture des URLS
	 * @param $str
	 */
	private function MakeClUrl($str){
		return magixcjquery_url_clean::rplMagixString($str,true);
	}
	/**
	 * @access private
	 * Identification de la traduction des urls du module catalogue
	 * @param string $lang
	 */
	private function mod_catalog_lang($lang){
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
		return $langsession;
	}
	/**
	 * 
	 * URL public des pages CMS avec réécriture
	 * @param string $lang
	 * @param integer $catid
	 * @param string $cat
	 * @param integer $id
	 * @param string $url
	 */
	private function cms_rewrite_uri($lang,$catid,$cat,$idpage,$pathpage){
		if($lang != null){
			$language = $lang.'/';
		}else $language = '';
		if($cat != null){
			$category = $catid.'-'.$cat.'/';
		}else $category = '';
		return magixcjquery_html_helpersHtml::getUrl().'/'.$language.$category.$idpage.'-'.$pathpage.'.html';
	}
	/**
	 * 
	 * URL public des pages CMS sans réécriture
	 * @param string $lang
	 * @param integer $catid
	 * @param string $cat
	 * @param integer $id
	 * @param string $url
	 */
	private function cms_uri($lang,$catid,$cat,$idpage,$pathpage){
		if($lang != null){
			$language = 'strLangue='.$lang.'&amp;';
		}else $language = '';
		if($cat != null){
			$category = 'getidcategory='.$catid.'&amp;getcat='.$cat.'&amp;';
		}else $category = '';
		return magixcjquery_html_helpersHtml::getUrl().'/index.php?'.$language.$category.'getidpage='.$idpage.'&amp;getpurl='.$pathpage;
	}
	/**
	 * @access public
	 * @static
	 * La réécriture des urls pour le cms
	 * @param $lang
	 * @param $catid
	 * @param $cat
	 * @param $id
	 * @param $url
	 */
	public static function filter_cms_url($lang,$catid,$cat,$idpage,$pathpage,$rewrite=false){
		switch ($rewrite){
			case true:
				return self::cms_rewrite_uri($lang, $catid, $cat, $idpage,$pathpage);
			break;
			case false:
				return self::cms_uri($lang, $catid, $cat, $idpage,$pathpage);
			break;
		}
		
	}
	/**
	 * @access private
	 * URL public des catégories du catalogue sans réécriture
	 * @param string $lang
	 * @param string $pathclibelle
	 * @param integer $idclc
	 * @return string
	 */
	private function catalog_uri_c($lang,$pathclibelle,$idclc){
		if($lang != null){
			$language = 'strLangue='.$lang.'&amp;';
		}else $language = '';
		return magixcjquery_html_helpersHtml::getUrl().'/index.php?'.$language.'catalog&amp;pathclibelle='.$pathclibelle.'&amp;'.'idclc='.$idclc;
	}
	/**
	 * @access private
	 * URL public des catégories du catalogue avec réécriture
	 * @param string $lang
	 * @param string $pathclibelle
	 * @param integer $idclc
	 * @return string
	 */
	private function catalog_rewrite_uri_c($lang,$pathclibelle,$idclc){
		if($lang != null){
			$language = $lang.'/';
		}else $language = '';
		return magixcjquery_html_helpersHtml::getUrl().'/'.$language.self::mod_catalog_lang($lang).'/c/'.$pathclibelle.'-'.$idclc.'.html';
	}
	/**
	 * 
	 * URL public des produits du catalogue avec réécriture
	 * @param $lang
	 * @param $pathclibelle
	 * @param $idclc
	 * @param $urlcatalog
	 * @param $idproduct
	 * @return string
	 */
	private function catalog_uri_product($lang,$pathclibelle,$idclc,$urlcatalog,$idproduct){
		if($lang != null){
			$language = 'strLangue='.$lang.'&amp;';
		}else $language = '';
		return magixcjquery_html_helpersHtml::getUrl().'/index.php?'.$language.'catalog&amp;'.'idclc='.$idclc.'&amp;'.$pathclibelle.'&amp;idcatalog='.$idproduct.'&amp;'.$urlcatalog;
	}
	/**
	 * 
	 * URL public des produits du catalogue avec réécriture
	 * @param $lang
	 * @param $pathclibelle
	 * @param $idclc
	 * @param $urlcatalog
	 * @param $idproduct
	 */
	private function catalog_rewrite_uri_product($lang,$pathclibelle,$idclc,$urlcatalog,$idproduct){
		if($lang != null){
			$language = $lang.'/';
		}else $language = '';
		return magixcjquery_html_helpersHtml::getUrl().'/'.$language.self::mod_catalog_lang($lang).'/'.$pathclibelle.'-'.$idclc.'/'.$urlcatalog.'-'.$idproduct.'.html';
	}
	/**
	 * 
	 * La réécriture des urls pour les catégories du catalogue
	 * @param string $lang
	 * @param string $pathclibelle
	 * @param integer $idclc
	 * @param bool $rewrite
	 */
	public static function filter_catalog_category_url($lang,$pathclibelle,$idclc,$rewrite=false){
		switch ($rewrite){
			case true:
				return self::catalog_rewrite_uri_c($lang, $pathclibelle, $idclc);
			break;
			case false:
				return self::catalog_uri_c($lang, $pathclibelle, $idclc);
			break;
		}
		
	}
	/**
	 * 
	 * La réécriture des urls pour les produits du catalogue
	 * @param string $lang
	 * @param string $pathclibelle
	 * @param integer $idclc
	 * @param string $urlcatalog
	 * @param integer $idproduct
	 * @param bool $rewrite
	 */
	public static function filter_catalog_product_url($lang,$pathclibelle,$idclc,$urlcatalog,$idproduct,$rewrite=false){
		switch ($rewrite){
			case true:
				return self::catalog_rewrite_uri_product($lang,$pathclibelle,$idclc,$urlcatalog,$idproduct);
			break;
			case false:
				return self::catalog_uri_product($lang, $pathclibelle, $idclc, $urlcatalog, $idproduct);
			break;
		}
		
	}
	/**
	 * La réécriture des urls pour les catégories dans le catalogue
	 * @param string  $lang
	 * @param integer $id
	 * @param string  $url
	 */
	/*public static function catalog_cat_uri($lang,$id,$url){
		return magixcjquery_html_helpersHtml::getUrl().'/'.$lang.'/'.self::mod_catalog_lang($lang).'/c/'.$id.'-'.$url.'.html';
	}*/
}