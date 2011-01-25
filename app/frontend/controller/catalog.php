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
 * @category   Controller 
 * @package    frontend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.14
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name catalog
 *
 */
class frontend_controller_catalog{
	/**
	 * variable des langues
	 * @var string
	 */
	public $slang;
	/**
	 * identifiant Categorie
	 * @var integer
	 */
	public $idclc;
	/**
	 * identifiant sous Categorie
	 * @var integer
	 */
	public $idcls;
	/**
	 * identifiant produit
	 * @var integer
	 */
	public $idproduct;
	/**
	 * Variable get pour la langue
	 * @var string
	 */
	public $getlang;
	/**
	 * function construct
	 *
	 */
	function __construct(){
		if(isset($_SESSION['strLangue'])){
			$this->slang = magixcjquery_filter_join::getCleanAlpha($_SESSION['strLangue'],3);
		}
		if(isset($_GET['idclc'])){
			$this->idclc = magixcjquery_filter_isVar::isPostNumeric($_GET['idclc']);
		}
		if(isset($_GET['idcls'])){
			$this->idcls = magixcjquery_filter_isVar::isPostNumeric($_GET['idcls']);
		}
		if(isset($_GET['idproduct'])){
			$this->idproduct = magixcjquery_filter_isVar::isPostNumeric($_GET['idproduct']);
		}
		if(isset($_GET['strLangue'])){
			$this->getlang = magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3);
			$this->slang = magixcjquery_filter_join::getCleanAlpha($_SESSION['strLangue'],3);
		}
	}
	/**
	 * Charge le titre d'une fiche catalogue
	 */
	private function load_product_page(){
		if(isset($this->getlang)){
			$products = frontend_db_catalog::publicDbCatalog()->s_product_page_with_language($this->idclc,$this->idproduct,$this->getlang);
			/**
			 * Charge L'image d'une fiche catalogue si elle existe sinon retourne une image fictive
			 */
			$imgc = '<div class="img-product">';
			if($products['imgcatalog'] != null){
				$imgc .= '<a class="imagebox" href="'.magixcjquery_html_helpersHtml::getUrl().'/upload/catalogimg/product/'.$products['imgcatalog'].'" alt="'.$products['titlecatalog'].'"><img src="'.magixcjquery_html_helpersHtml::getUrl().'/upload/catalogimg/medium/'.$products['imgcatalog'].'" alt="'.$products['titlecatalog'].'" /></a>';
			}else{
				$imgc .= '<a href="'.magixglobal_model_rewrite::filter_catalog_product_url($this->getlang,$products['pathclibelle'],$products['idclc'],$products['urlcatalog'],$products['idproduct'],true).'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog'.magixcjquery_html_helpersHtml::unixSeparator().'no-picture.png'.'" alt="'.$products['titlecatalog'].'" /></a>';
			}
			$imgc .= '</div>';
			$page = frontend_config_smarty::getInstance()->assign('idcatalog',$products['idcatalog']);
			$page .= frontend_config_smarty::getInstance()->assign('date_catalog',$products['date_catalog']);
			$page .= frontend_config_smarty::getInstance()->assign('titlecatalog',$products['titlecatalog']);
			$page .= frontend_config_smarty::getInstance()->assign('category',$products['clibelle']);
			$page .= frontend_config_smarty::getInstance()->assign('subcategory',$products['slibelle']);
			$page .= frontend_config_smarty::getInstance()->assign('imgcatalog',$imgc);
			$page .= frontend_config_smarty::getInstance()->assign('desccatalog',$products['desccatalog']);
		}else{
			$products = frontend_db_catalog::publicDbCatalog()->s_product_page_no_language($this->idclc,$this->idproduct);
			/**
			 * Charge L'image d'une fiche catalogue si elle existe sinon retourne une image fictive
			 */
			$imgc = '<div class="img-product">';
			if($products['imgcatalog'] != null){
				$imgc .= '<a class="imagebox" href="'.magixcjquery_html_helpersHtml::getUrl().'/upload/catalogimg/product/'.$products['imgcatalog'].'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/medium/'.$products['imgcatalog'].'" alt="'.$products['titlecatalog'].'" /></a>';
			}else{
				$imgc .= '<a href="'.magixglobal_model_rewrite::filter_catalog_product_url($this->getlang,$products['pathclibelle'],$products['idclc'],$products['urlcatalog'],$products['idproduct'],true).'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog'.magixcjquery_html_helpersHtml::unixSeparator().'no-picture.png'.'" alt="'.$products['titlecatalog'].'" /></a>';

			}
			$imgc .= '</div>';
			$page = frontend_config_smarty::getInstance()->assign('idcatalog',$products['idcatalog']);
			$page .= frontend_config_smarty::getInstance()->assign('date_catalog',$products['date_catalog']);
			$page .= frontend_config_smarty::getInstance()->assign('titlecatalog',$products['titlecatalog']);
			$page .= frontend_config_smarty::getInstance()->assign('category',$products['clibelle']);
			$page .= frontend_config_smarty::getInstance()->assign('subcategory',$products['slibelle']);
			$page .= frontend_config_smarty::getInstance()->assign('imgcatalog',$imgc);
			$page .= frontend_config_smarty::getInstance()->assign('desccatalog',$products['desccatalog']);
		}
		return $page;
	}
	/**
	 * Affiche la page des categories du catalogue
	 * @access public
	 */
	private function display_category(){
		$catname = frontend_db_catalog::publicDbCatalog()->s_current_name_category($this->idclc);
		frontend_config_smarty::getInstance()->assign('clibelle',magixcjquery_string_convert::ucFirst($catname['clibelle']));
		frontend_config_smarty::getInstance()->assign('c_content',$catname['c_content']);
		frontend_config_smarty::getInstance()->display('catalog/category.phtml');
	}
	/**
	 * Affiche la page des sous categories du catalogue
	 * @access public
	 */
	private function display_sub_category(){
		$subcatname = frontend_db_catalog::publicDbCatalog()->s_current_name_subcategory($this->idcls);
		frontend_config_smarty::getInstance()->assign('clibelle',magixcjquery_string_convert::ucFirst($subcatname['clibelle']));
		frontend_config_smarty::getInstance()->assign('slibelle',magixcjquery_string_convert::ucFirst($subcatname['slibelle']));
		frontend_config_smarty::getInstance()->assign('s_content',$subcatname['s_content']);
		frontend_config_smarty::getInstance()->display('catalog/subcategory.phtml');
	}
	/**
	 * Affiche la page du produit selectionner du catalogue
	 * @access public
	 */
	private function display_product(){
		self::load_product_page();
		frontend_config_smarty::getInstance()->display('catalog/product.phtml');
	}
	/**
	 * Affiche la page ROOT du catalogue
	 * @access public
	 */
	private function display_catalog(){
		frontend_config_smarty::getInstance()->display('catalog/index.phtml');
	}
	public function run(){
		if(isset($this->idclc)){
			if(isset($this->idproduct)){
				self::display_product();
			}elseif(isset($this->idcls)){
				self::display_sub_category();
			}else{
				self::display_category();
			}
		}else{
			self::display_catalog();
		}
	}
}