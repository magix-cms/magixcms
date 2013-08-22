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
	public $idCat;
	/**
     * idcls catch on GET
	 * @var integer
	 */
	public $idSubcat;
	/**
     * idproduct catch on GET
	 * @var integer
	 */
	public $idProduct;
	/**
	 * function construct
	 *
	 */
	function __construct()
    {
        $FilterRequest  =   new magixcjquery_filter_request;
        $FilterVar      =   new magixcjquery_filter_isVar;

		if ($FilterRequest->isGet('idclc')) {
			$this->idCat = $FilterVar->isPostNumeric($_GET['idclc']);

		}
		if ($FilterRequest->isGet('idcls')) {
			$this->idSubcat = $FilterVar->isPostNumeric($_GET['idcls']);

		}
		if ($FilterRequest->isGet('idproduct')) {
			$this->idProduct = $FilterVar->isPostNumeric($_GET['idproduct']);
		}
	}
    /**
     * Assign category's data to smarty
     * @access private
     */
	private function load_category_data()
    {
        $template = new frontend_model_template();
        $Catalog  = new frontend_model_catalog();

		$data = parent::s_category_data($this->idCat);
        $dataClean  =   $Catalog->setItemData($data,0);

        $template->assign('cat',     $dataClean,  true);
	}
    /**
     * Assign subcategory's data to smarty
     * @access private
     */
	private function load_subcategory_data()
    {

        $template = new frontend_model_template();
        $Catalog  = new frontend_model_catalog();

		$data = parent::s_subcategory_data($this->idSubcat);
        $dataClean  =   $Catalog->setItemData($data,0);

        $template->assign('subcat',     $dataClean,  true);
        $this->load_category_data();
	}
    /**
     * Assign product's data to smarty
     * @access private
     */
    private function load_product_data()
    {
        $template = new frontend_model_template();
        $Catalog  = new frontend_model_catalog();

        $data = parent::s_product_data($this->idProduct);
        $dataClean  =   $Catalog->setItemData($data,true);

        $template->assign('product',     $dataClean,  true);
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
        if (isset($this->idProduct)) {
            $this->load_product_data();
            $template->display('catalog/product.tpl');

        } elseif (isset($this->idSubcat)) {
            $this->load_subcategory_data();
            $template->display('catalog/subcategory.tpl');

        } elseif (isset($this->idCat)) {
            $this->load_category_data();
            $template->display('catalog/category.tpl');

        } else {
            $template->display('catalog/index.tpl');

        }
	}
}