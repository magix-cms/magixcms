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
		$data = parent::s_category_data($this->idclc);
            // ** Set image path
        $data['imgPath'] = null;
        if ($data['img_c'] != null) {
            $modelImagePath = new magixglobal_model_imagepath();
            $data['imgPath'] =  $modelImagePath->filterPathImg(
                                    array(
                                        'filtermod' =>  'catalog',
                                        'img'       =>  $data['img_c'],
                                        'levelmod'  =>  'category'
                                    )
                                );
        }
        // *** Assign data to Smarty var
        $template = new frontend_model_template();
        $Catalog  = new frontend_model_catalog();

        $dataClean  =   $Catalog->setItemData($data,0);
        /** @noinspection PhpParamsInspection */
        $template->assign('cat',     $dataClean,  true);
	}
    /**
     * Assign subcategory's data to smarty
     * @access private
     */
	private function load_subcategory_data()
    {
        // *** Load Sql data
		$data = parent::s_subcategory_data($this->idcls);
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
        $template = new frontend_model_template();
        $Catalog  = new frontend_model_catalog();

        $dataClean  =   $Catalog->setItemData($data,0);
        /** @noinspection PhpParamsInspection */
        $template->assign('subcat',     $dataClean,  true);
        $this->load_category_data();
	}
    /**
     * Assign product's data to smarty
     * @access private
     */
    private function load_product_data()
    {
        // *** Load Sql data
        $data = parent::s_product_data($this->idproduct);
        // ** Set image path
        $data['imgPath'] = null;
        if ($data['imgcatalog'] != null) {
            $data['imgPath'] = '/upload/catalogimg/medium/'.$data['imgcatalog'];
        }
        // ** Set url
        $rewrite    = new magixglobal_model_rewrite();
        $data['url']['product'] =   $rewrite->filter_catalog_product_url(
                                        $data['iso'],
                                        $data['pathclibelle'],
                                        $data['idclc'],
                                        $data['pathslibelle'],
                                        $data['idcls'],
                                        $data['urlcatalog'],
                                        $data['idproduct'],
                                        true
                                    );

        // *** Assign data to Smarty var
        $template = new frontend_model_template();
        $Catalog  = new frontend_model_catalog();

        $dataClean  =   $Catalog->setItemData($data,0);
        /** @noinspection PhpParamsInspection */
        $template->assign('product',     $dataClean,  true);


/*
        // ** Assign Product Data
        $template->assign('id_catalog',     $data['idcatalog'],     true);
        $template->assign('id_product',     $data['id_product'],    true);
        $template->assign('name_product',   $data['titlecatalog'],  true);
        $template->assign('price_product',  $data['price'],         true);
        $template->assign('imgPath_product',$data['imgPath'],       true);
        $template->assign('content_product',$data['desccatalog'],   true);
        $template->assign('date_product',   $data['date_catalog'],  true);
        $template->assign('url_product',    $data['url']['product'],true);
*/
        $this->load_category_data();
        $this->load_subcategory_data();
    }
	/**
	 * Control, loading and display
     * @access public
	 */
	public function run()
    {
        $template = new frontend_model_template;
        if (isset($this->idproduct)) {
            $this->load_product_data();
            $template->display('catalog/product.phtml');

        } elseif (isset($this->idcls)) {
            $this->load_subcategory_data();
            $template->display('catalog/subcategory.phtml');

        } elseif (isset($this->idclc)) {
            $this->load_category_data();
            $template->display('catalog/category.phtml');

        } else {
            $template->display('catalog/index.phtml');

        }
	}
}