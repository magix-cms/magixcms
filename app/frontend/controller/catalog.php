<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 magix-cms.com <support@magix-cms.com>
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
 * @category   Controller 
 * @package    frontend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.14
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name catalog
 *
 */
class frontend_controller_catalog extends frontend_db_catalog{
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
	 * function construct
	 *
	 */
	function __construct(){
		if(magixcjquery_filter_request::isGet('idclc')){
			$this->idclc = magixcjquery_filter_isVar::isPostNumeric($_GET['idclc']);
		}
		if(magixcjquery_filter_request::isGet('idcls')){
			$this->idcls = magixcjquery_filter_isVar::isPostNumeric($_GET['idcls']);
		}
		if(magixcjquery_filter_request::isGet('idproduct')){
			$this->idproduct = magixcjquery_filter_isVar::isPostNumeric($_GET['idproduct']);
		}
	}
	/**
	 * Charge le titre d'une fiche catalogue
	 */
	private function load_product_page(){
		$products = parent::s_product_page($this->idclc,$this->idproduct,frontend_model_template::current_Language());
		/**
		 * Charge L'image d'une fiche catalogue si elle existe sinon retourne une image fictive
		 */
		$imgc = '<div class="img-product">';
		if($products['imgcatalog'] != null){
			$imgc .= '<a class="imagebox" href="/upload/catalogimg/product/'.$products['imgcatalog'].'" title="'.$products['titlecatalog'].'"><img src="/upload/catalogimg/medium/'.$products['imgcatalog'].'" alt="'.$products['titlecatalog'].'" /></a>';
		}else{
			$imgc .= '<img src="/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog'.magixcjquery_html_helpersHtml::unixSeparator().'no-picture.png'.'" alt="'.$products['titlecatalog'].'" />';
		}
		$imgc .= '</div>';
		$uri = magixglobal_model_rewrite::filter_catalog_product_url($products['iso'], $products['pathclibelle'], $products['idclc'],$products['pathslibelle'], $products['idcls'], $products['urlcatalog'], $products['idproduct'],true);
		frontend_model_template::assign('idcatalog',$products['idcatalog']);
		frontend_model_template::assign('idproduct',$products['idproduct']);
		frontend_model_template::assign('date_catalog',$products['date_catalog']);
		frontend_model_template::assign('titlecatalog',$products['titlecatalog']);
		frontend_model_template::assign('category',$products['clibelle']);
		frontend_model_template::assign('subcategory',$products['slibelle']);
		frontend_model_template::assign('price',$products['price']);
		frontend_model_template::assign('imgcatalog',$imgc);
		frontend_model_template::assign('desccatalog',$products['desccatalog']);
		frontend_model_template::assign('urlcatalog',$uri);
		$uri_cat = magixglobal_model_rewrite::filter_catalog_category_url($products['iso'], $products['pathclibelle'],$products['idclc'],true);			
		$uri_subcat = magixglobal_model_rewrite::filter_catalog_subcategory_url($products['iso'], $products['pathclibelle'],$products['idclc'],$products['pathslibelle'],$products['idcls'],true);	
		frontend_model_template::assign('uri_cat',$uri_cat);
		frontend_model_template::assign('uri_subcat',$uri_subcat);
	}
	/**
	 * Affiche la page des categories du catalogue
	 * @access public
	 */
	private function load_data_category(){
		$catname = parent::s_current_name_category($this->idclc);
		frontend_model_template::assign('clibelle',magixcjquery_string_convert::ucFirst($catname['clibelle']));
		frontend_model_template::assign('c_content',$catname['c_content']);
	}
	/**
	 * Affiche la page des sous categories du catalogue
	 * @access public
	 */
	private function load_data_subcategory(){
		$subcatname = parent::s_current_name_subcategory($this->idcls);
		frontend_model_template::assign('clibelle',magixcjquery_string_convert::ucFirst($subcatname['clibelle']));
		frontend_model_template::assign('slibelle',magixcjquery_string_convert::ucFirst($subcatname['slibelle']));
		frontend_model_template::assign('s_content',$subcatname['s_content']);
		$uri_cat = magixglobal_model_rewrite::filter_catalog_category_url(frontend_model_template::current_Language(), $subcatname['pathclibelle'],$subcatname['idclc'],true);			
		frontend_model_template::assign('uri_cat',$uri_cat);
	}
	/**
	 * 
	 * Execution du catalogue
	 */
	public function run(){
		if(isset($this->idclc)){
			if(isset($this->idcls)){
				if(isset($this->idproduct)){
					$this->load_product_page();
					frontend_model_template::display('catalog/product.phtml');
				}else{
					$this->load_data_subcategory();
					frontend_model_template::display('catalog/subcategory.phtml');
				}
			}elseif(isset($this->idproduct)){
				$this->load_product_page();
				frontend_model_template::display('catalog/product.phtml');
			}else{
				$this->load_data_category();
				frontend_model_template::display('catalog/category.phtml');
			}
		}else{
			frontend_model_template::display('catalog/index.phtml');
		}
	}
}