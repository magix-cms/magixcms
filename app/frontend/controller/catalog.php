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
 * @version    2.2
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @author Sire Sam <samuel.lesire@gmail.com>
 * @name catalog
 */
class frontend_controller_catalog extends frontend_db_catalog
{
	/**
	 * idclc catch on GET
	 * @var integer
	 */
	public $idclc;
	/**
     * idcls catch on GET
	 * @var integer
	 */
	public $idcls;
	/**
     * idproduct catch on GET
	 * @var integer
	 */
	public $idproduct;
	/**
	 * function construct
	 *
	 */
	function __construct()
    {
		if (magixcjquery_filter_request::isGet('idclc')) {
			$this->idclc = magixcjquery_filter_isVar::isPostNumeric($_GET['idclc']);
		}
		if (magixcjquery_filter_request::isGet('idcls')) {
			$this->idcls = magixcjquery_filter_isVar::isPostNumeric($_GET['idcls']);
		}
		if (magixcjquery_filter_request::isGet('idproduct')) {
			$this->idproduct = magixcjquery_filter_isVar::isPostNumeric($_GET['idproduct']);
		}
	}
    /**
     * Assign category's data to smarty
     * @access private
     */
	private function load_category_data()
    {
        // *** Load Sql data
		$data = parent::s_current_name_category($this->idclc);
            // ** Set image path
        $data['imgPath'] = null;
        if ($data['img_c'] != null) {
            $modelImagePath = new magixglobal_model_imagepath();
            $data['imgPath'] = $modelImagePath->filterPathImg(array(
                                    'filtermod' =>  'catalog',
                                    'img'       =>  $data['img_c'],
                                    'levelmod'  =>  'category'
                                ));
        }
        // *** Assign data to Smarty var
        $template = new frontend_model_template();
        /** @noinspection PhpParamsInspection */
        $template->assign(
            array(
                'name_cat'      =>  $data['clibelle'],
                'content_cat'   =>  $data['c_content'],
                'imgPath_cat'   =>  $data['imgPath']
            )
        );
	}
    /**
     * Assign subcategory's data to smarty
     * @access private
     */
	private function load_subcategory_data()
    {
        // *** Load Sql data
		$data = parent::s_current_name_subcategory($this->idcls);
            // ** Set image path
        $data['imgPath'] = null;
        if ($data['img_s'] != null) {
            $modelImagePath = new magixglobal_model_imagepath();
            $data['imgPath'] =  $modelImagePath->filterPathImg(
                                    array(
                                        'filtermod' =>  'catalog',
                                        'img'       =>  $data['img_s'],
                                        'levelmod'  =>  'subcategory'
                                    )
                                );
        }
            // ** Set url
        $data['url']['cat'] =   magixglobal_model_rewrite::filter_catalog_category_url(
                                    $data['iso'],
                                    $data['pathclibelle'],
                                    $data['idclc'],
                                    true
                                );
        // *** Assign data to Smarty var
        /** @noinspection PhpParamsInspection */
        frontend_model_template::assign(
            array(
                'name_subcat'       =>  $data['slibelle'],
                'content_subcat'    =>  $data['s_content'],
                'imgPath_subcat'    =>  $data['imgPath'],
                'name_cat'          =>  $data['clibelle'],
                'url_cat'           =>  $data['url']['cat']
            )
        );
	}
    /**
     * Assign product's data to smarty
     * @access private
     */
    private function load_product_data()
    {
        // *** Load Sql data
        $data = parent::s_product_page($this->idclc,$this->idproduct);
        // ** Set image path
        $data['imgPath'] = null;
        if ($data['imgcatalog'] != null) {
            $data['imgPath'] = '/upload/catalogimg/medium/'.$data['imgcatalog'];
        }
        // ** Set url
        $rewrite    = new magixglobal_model_rewrite();
        $data['url']['product'] = $rewrite->filter_catalog_product_url(
                                                $data['iso'],
                                                $data['pathclibelle'],
                                                $data['idclc'],
                                                $data['pathslibelle'],
                                                $data['idcls'],
                                                $data['urlcatalog'],
                                                $data['idproduct'],
                                                true
                                            );
        $data['url']['cat']     = $rewrite->filter_catalog_category_url(
                                                $data['iso'],
                                                $data['pathclibelle'],
                                                $data['idclc'],
                                                true
                                            );
        $data['url']['subcat']  = $rewrite->filter_catalog_subcategory_url(
                                                $data['iso'],
                                                $data['pathclibelle'],
                                                $data['idclc'],
                                                $data['pathslibelle'],
                                                $data['idcls'],
                                                true
                                            );
        // *** Assign data to Smarty var
        /** @noinspection PhpParamsInspection */
        frontend_model_template::assign(
            array(
                // ** Assign Product Data
                'id_catalog'        =>  $data['idcatalog'],
                'id_product'        =>  $data['idproduct'],
                'name_product'      =>  $data['titlecatalog'],
                'price_product'     =>  $data['price'],
                'imgPath_product'   =>  $data['imgPath'],
                'content_product'   =>  $data['desccatalog'],
                'date_product'      =>  $data['date_catalog'],
                'url_product'       =>  $data['url']['product'],
                // ** Assign parent cat data
                'name_cat'          =>  $data['clibelle'],
                'url_cat'           =>  $data['url']['cat'],
                'name_subcat'       =>  $data['slibelle'],
                'url_subcat'        =>  $data['url']['subcat']
            )
        );
    }
	/**
	 * Control, loading and display
     * @access public
	 */
	public function run()
    {
        $template = new frontend_model_template;
        if (isset($this->idproduct)) {
                // *** Display product
            $this->load_product_data();
            $template->display('catalog/product.phtml');
        } elseif (isset($this->idcls)) {
                // *** Display subcategory
            $this->load_subcategory_data();
            $template->display('catalog/subcategory.phtml');
        } elseif (isset($this->idclc)) {
                // *** Display category
            $this->load_category_data();
            $template->display('catalog/category.phtml');
        } else {
                // *** Display root
            $template->display('catalog/index.phtml');
        }
	}
}