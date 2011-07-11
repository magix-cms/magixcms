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
	 * @access private
	 * Identification de la traduction des urls du module news
	 * @param string $lang
	 */
	private function mod_cms_lang($lang){
		switch($lang){
			default:
			$langsession = '/pages/';	
		}
		return $langsession;
	}
	/**
	 * @access private
	 * Identification de la traduction des urls du module news
	 * @param string $lang
	 */
	public function mod_news_lang($lang){
		switch($lang){
				case 'fr':
				$langsession = '/actualites/';
					break;
				case 'en':
				$langsession = '/news/';
					break;	
				case 'de':
				$langsession = '/news/';
					break;
				case 'nl':
				$langsession = '/nieuws/';
					break;	
				default:
				$langsession = '/actualites/';	
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
	private function cms_rewrite_uri($lang,$getidpage_p,$geturi_page_p,$getidpage,$geturi_page){
		if($lang != null){
			if($getidpage_p != null){
				$category = $getidpage_p.'-'.$geturi_page_p.'/';
			}else{
				$category = '';
			}
			return '/'.$lang.self::mod_cms_lang($lang).$category.$getidpage.'-'.$geturi_page.'/';
		}
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
	private function cms_uri($lang,$getidpage_p,$geturi_page_p,$getidpage,$geturi_page){
		if($lang != null){
			if($getidpage_p != null){
				$category = 'getidpage_p='.$getidpage_p.'&amp;geturi_page_p='.$geturi_page_p.'&amp;';
			}else{
				$category = '';
			}
			$language = 'strLangue='.$lang.'&amp;';
			return '/cms.php?'.$language.$category.'getidpage='.$getidpage.'&amp;geturi_page='.$geturi_page;
		}
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
	public static function filter_cms_url($lang,$getidpage_p,$geturi_page_p,$getidpage,$geturi_page,$rewrite=false){
		switch ($rewrite){
			case true:
				return self::cms_rewrite_uri($lang,$getidpage_p,$geturi_page_p,$getidpage,$geturi_page);
			break;
			case false:
				return self::cms_uri($lang,$getidpage_p,$geturi_page_p,$getidpage,$geturi_page);
			break;
		}
		
	}
	/**
	 * @access private
	 * URL public du catalogue sans réécriture
	 * @param string $lang
	 */
	private function catalog_uri_root($lang){
		if($lang != null){
			$language = 'strLangue='.$lang.'&amp;';
		}else $language = '';
		return '/catalog.php?'.$language.'catalog';
	}
	/**
	 * @access private
	 * URL public du catalogue avec réécriture
	 * @param string $lang
	 */
	private function catalog_rewrite_uri_root($lang){
		if($lang != null){
			$language = $lang.'/';
		}else $language = '';
		return '/'.$language.self::mod_catalog_lang($lang).'/';
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
		return '/catalog.php?'.$language.'catalog&amp;pathclibelle='.$pathclibelle.'&amp;'.'idclc='.$idclc;
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
		return '/'.$language.self::mod_catalog_lang($lang).'/c/'.$pathclibelle.'-'.$idclc.'.html';
	}
	/**
	 * URL des sous catégories du catalogue sans réécriture
	 * @access private
	 * @param $lang
	 * @param $pathclibelle
	 * @param $idclc
	 * @param $pathslibelle
	 * @param $idcls
	 */
	private function catalog_uri_s($lang,$pathclibelle,$idclc,$pathslibelle,$idcls){
		if($lang != null){
			$language = 'strLangue='.$lang.'&amp;';
		}else $language = '';
		return '/catalog.php?'.$language.'catalog&amp;pathclibelle='.$pathclibelle.'&amp;'.'idclc='.$idclc.'&amp;s'.'&amp;pathslibelle='.$pathslibelle.'&amp;idcls='.$idcls;
	}
	/**
	 *  URL des sous catégories du catalogue avec réécriture
	 * @access private
	 * @param string $lang
	 * @param string $pathclibelle
	 * @param integer $idclc
	 * @param string $pathslibelle
	 * @param integer $idcls
	 */
	private function catalog_rewrite_uri_s($lang,$pathclibelle,$idclc,$pathslibelle,$idcls){
		if($lang != null){
			$language = $lang.'/';
		}else $language = '';
		return '/'.$language.self::mod_catalog_lang($lang).'/'.$pathclibelle.'-'.$idclc.'/s/'.$pathslibelle.'-'.$idcls.'.html';
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
		return '/catalog.php?'.$language.'catalog&amp;'.'idclc='.$idclc.'&amp;'.$pathclibelle.'&amp;idcatalog='.$idproduct.'&amp;'.$urlcatalog;
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
		return '/'.$language.self::mod_catalog_lang($lang).'/'.$pathclibelle.'-'.$idclc.'/'.$urlcatalog.'-'.$idproduct.'.html';
	}
	/**
	 * La réécriture des urls de la racine du catalogue
	 * @param string $lang
	 * @param bool $rewrite
	 */
	public static function filter_catalog_root_url($lang,$rewrite=false){
		switch ($rewrite){
			case true:
				return self::catalog_rewrite_uri_root($lang);
			break;
			case false:
				return self::catalog_uri_root($lang);
			break;
		}
		
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
	 * La réécriture des urls pour les sous catégories du catalogue
	 * @param string $lang
	 * @param string $pathclibelle
	 * @param integer $idclc
	 * @param string $pathslibelle
	 * @param integer $idcls
	 * @param Bool $rewrite
	 */
	public static function filter_catalog_subcategory_url($lang,$pathclibelle,$idclc,$pathslibelle,$idcls,$rewrite=false){
		switch ($rewrite){
			case true:
				return self::catalog_rewrite_uri_s($lang,$pathclibelle,$idclc,$pathslibelle,$idcls);
			break;
			case false:
				return self::catalog_uri_s($lang,$pathclibelle,$idclc,$pathslibelle,$idcls);
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
	 * @access private
	 * URL public des news sans réécriture
	 * @param string $lang
	 */
	private function news_uri_root($lang){
		if($lang != null){
			$language = 'strLangue='.$lang;
			return '/news.php?'.$language;
		}
	}
	/**
	 * @access private
	 * URL public des news avec réécriture
	 * @param string $lang
	 */
	private function news_rewrite_uri_root($lang){
		if($lang != null){
			return '/'.$lang.self::mod_news_lang($lang);
		}
	}
	/**
	 * La réécriture des urls pour afficher toutes les news
	 * @param string $lang
	 * @param bool $rewrite
	 */
	public static function filter_news_root_url($lang,$rewrite=false){
		switch ($rewrite){
			case true:
				return self::news_rewrite_uri_root($lang);
			break;
			case false:
				return self::news_uri_root($lang);
			break;
		}
		
	}
	/**
	 * URL public des news sans réécriture
	 * @param string $lang
	 * @param numeric $getdate
	 * @param string $getnews
	 */
	private function news_uri($lang,$getdate,$uri_get_news,$keynews){
		if($lang != null){
			$language = 'strLangue='.$lang.'&amp;';
			return '/news.php?'.$language.'getdate='.$getdate.'&amp;'.'uri_get_news='.$uri_get_news.'&amp;'.'getnews='.$keynews;
		}
	}
	/**
	 * URL public des news avec réécriture
	 * @param $lang
	 * @param $getdate
	 * @param $getnews
	 */
	private function news_rewrite_uri($lang,$getdate,$uri_get_news,$keynews){
		if($lang != null){
			return '/'.$lang.self::mod_news_lang($lang).$getdate.'/'.$uri_get_news.'/'.$keynews.'/';
		}
	}
	/**
	 * La réécriture des URL des news
	 * @param string $lang
	 * @param date $getdate
	 * @param string $getnews
	 * @param bool $rewrite
	 */
	public static function filter_news_url($lang,$getdate,$uri_get_news,$keynews,$rewrite=false){
		switch ($rewrite){
			case true:
				return self::news_rewrite_uri($lang,$getdate,$uri_get_news,$keynews);
			break;
			case false:
				return self::news_uri($lang,$getdate,$uri_get_news,$keynews);
			break;
		}
	}
	/**
	 * URL public d'un plugin sans réécriture
	 * @param string $lang
	 * @param string $magixmod
	 */
	private function plugins_uri_root($lang,$magixmod){
		if($lang != null){
			$language = 'strLangue='.$lang.'&amp;';
		}else $language = '';
		return '/plugins.php?'.$language.'magixmod='.$magixmod;
	}
	/**
	 * URL public d'un plugin avec réécriture
	 * @param string $lang
	 * @param string $magixmod
	 */
	private function plugins_rewrite_uri_root($lang,$magixmod){
		if($lang != null){
			$language = $lang.'/';
		}else $language = '';
		return '/'.$language.'magixmod/'.$magixmod.'/';
	}
	/**
	 * URL public d'un plugin sans réécriture avec le paramètre uniqp
	 * @param string $lang
	 * @param string $magixmod
	 */
	private function plugins_uri_uniqp($lang,$magixmod,$uniqp){
		if($lang != null){
			$language = 'strLangue='.$lang.'&amp;';
		}else $language = '';
		return '/plugins.php?'.$language.'magixmod='.$magixmod.'&uniqp='.$uniqp;
	}
	/**
	 * URL public d'un plugin avec réécriture avec le paramètre uniqp
	 * @param string $lang
	 * @param string $magixmod
	 * @param string uniqp
	 */
	private function plugins_rewrite_uri_uniqp($lang,$magixmod,$uniqp){
		if($lang != null){
			$language = $lang.'/';
		}else $language = '';
		return '/'.$language.'magixmod/'.$magixmod.'/'.$uniqp.'/';
	}
	/**
	 * URL public d'un plugin sans réécriture avec les paramètres supplémentaire
	 * @param string $lang
	 * @param string $magixmod
	 * @param integer $pnum1
	 * @param string $pstring2
	 */
	private function plugins_uri_mparams($lang,$magixmod,$pnum1,$pstring2){
		if($lang != null){
			$language = 'strLangue='.$lang.'&amp;';
		}else $language = '';
		return '/plugins.php?'.$language.'magixmod='.$magixmod.'&pnum1='.$pnum1.'&pstring2='.$pstring2;
	}
	/**
	 * URL public d'un plugin avec réécriture avec les paramètres supplémentaire
	 * @param string $lang
	 * @param string $magixmod
	 * @param integer $pnum1
	 * @param string $pstring2
	 */
	private function plugins_rewrite_uri_mparams($lang,$magixmod,$pnum1,$pstring2){
		if($lang != null){
			$language = $lang.'/';
		}else $language = '';
		return '/'.$language.'magixmod/'.$magixmod.'/'.$pnum1.'-'.$pstring2.'.html';
	}
	/**
	 * La réécriture des URL Root des plugins
	 * @param string $lang
	 * @param string $magixmod
	 * @param bool $rewrite
	 */
	public static function filter_plugins_root_url($lang,$magixmod,$rewrite=false){
		switch ($rewrite){
			case true:
				return self::plugins_rewrite_uri_root($lang,$magixmod);
			break;
			case false:
				return self::plugins_uri_root($lang,$magixmod);
			break;
		}
		
	}
	/**
	 * La réécriture des URL pour les plugins avec le paramètre uniqp
	 * @param string $lang
	 * @param string $magixmod
	 * @param string uniqp
	 * @param bool $rewrite
	 */
	public static function filter_plugins_uniqp_url($lang,$magixmod,$uniqp,$rewrite=false){
		switch ($rewrite){
			case true:
				return self::plugins_rewrite_uri_uniqp($lang,$magixmod,$uniqp);
			break;
			case false:
				return self::plugins_uri_uniqp($lang,$magixmod,$uniqp);
			break;
		}
		
	}
	/**
	 * La réécriture des URL pour les plugins avec le paramètre uniqp
	 * @param string $lang
	 * @param string $magixmod
	 * @param integer $pnum1
	 * @param string $pstring2
	 * @param bool $rewrite
	 */
	public static function filter_plugins_mparams_url($lang,$magixmod,$pnum1,$pstring2,$rewrite=false){
		switch ($rewrite){
			case true:
				return self::plugins_rewrite_uri_mparams($lang,$magixmod,$pnum1,$pstring2);
			break;
			case false:
				return self::plugins_uri_mparams($lang,$magixmod,$pnum1,$pstring2);
			break;
		}
		
	}
}