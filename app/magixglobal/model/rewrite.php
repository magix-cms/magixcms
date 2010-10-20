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
		return '/'.$language.$category.$idpage.'-'.$pathpage.'.html';
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
		return '/index.php?'.$language.$category.'getidpage='.$idpage.'&amp;getpurl='.$pathpage;
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
	 * URL public du catalogue sans réécriture
	 * @param string $lang
	 */
	private function catalog_uri_root($lang){
		if($lang != null){
			$language = 'strLangue='.$lang.'&amp;';
		}else $language = '';
		return '/index.php?'.$language.'catalog';
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
		return '/index.php?'.$language.'catalog&amp;pathclibelle='.$pathclibelle.'&amp;'.'idclc='.$idclc;
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
		return '/index.php?'.$language.'catalog&amp;pathclibelle='.$pathclibelle.'&amp;'.'idclc='.$idclc.'&amp;s'.'&amp;pathslibelle='.$pathslibelle.'&amp;idcls='.$idcls;
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
		return '/index.php?'.$language.'catalog&amp;'.'idclc='.$idclc.'&amp;'.$pathclibelle.'&amp;idcatalog='.$idproduct.'&amp;'.$urlcatalog;
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
	 * URL public d'un plugin sans réécriture
	 * @param string $lang
	 * @param string $magixmod
	 */
	private function plugins_uri_root($lang,$magixmod){
		if($lang != null){
			$language = 'strLangue='.$lang.'&amp;';
		}else $language = '';
		return '/index.php?'.$language.'magixmod='.$magixmod;
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
}