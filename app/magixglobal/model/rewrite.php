<?php
/**
 * @category   Model 
 * @package    Rewrite URL
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2010-09-06
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 * @name Rewrite
 * @version 1.0
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
	private function cms_public_uri($lang,$catid,$cat,$idpage,$pathpage){
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
	private function cms_admin_uri($lang,$catid,$cat,$idpage,$pathpage){
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
				return self::cms_public_uri($lang, $catid, $cat, $idpage,$pathpage);
			break;
			case false:
				return self::cms_admin_uri($lang, $catid, $cat, $idpage,$pathpage);
			break;
		}
		
	}
	/**
	 * La réécriture des urls pour les catégories dans le catalogue
	 * @param string  $lang
	 * @param integer $id
	 * @param string  $url
	 */
	public static function catalog_cat_uri($lang,$id,$url){
		return magixcjquery_html_helpersHtml::getUrl().'/'.$lang.'/'.self::mod_catalog_lang($lang).'/c/'.$id.'-'.$url.'.html';
	}
}