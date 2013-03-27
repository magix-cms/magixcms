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
 * @copyright  MAGIX CMS Copyright (c) 2011 -2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.0 $Id$
 * @id $Rev$
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @author Sire Sam <samuel.lesire@gmail.com>
 * @name cms
 *
 */
class frontend_controller_cms extends frontend_db_cms
{
    /**
     * idParent catch on GET
     * @var integer
     */
	public $idParent;
    /**
     * idPage catch on GET
     * @var integer
     */
	public $idPage;
	/**
	 * function construct
	 *
	 */
	function __construct()
    {
        $FilterRequest  =   new magixcjquery_filter_request;
        $FilterVar      =   new magixcjquery_filter_isVar;

		if ($FilterRequest->isGet('getidpage_p')) {
			$this->idParent = $FilterVar->isPostAlphaNumeric($_GET['getidpage_p']);

		}
		if ($FilterRequest->isGet('getidpage')) {
			$this->idPage = $FilterVar->isPostNumeric($_GET['getidpage']);

		}
	}
    /**
     * Assign page's data to smarty
     * @access private
     */
	private function load_page_data()
    {
        $ModelCms    =   new frontend_model_cms();
        $template = new frontend_model_template();

		$data = parent::s_page_data($this->idPage);
        $dataClean  =   $ModelCms->setItemData($data,0);
        $dataClean['seoTitle']  =   $data['seo_title_page'];
        $dataClean['seoDescr']  =   $data['seo_desc_page'];

        $template->assign('page',   $dataClean, true);

        // ** Assign parent page data
        if (isset($this->idParent)) {
            $parent = parent::s_page_data($this->idParent);
            $parentClean  =   $ModelCms->setItemData($parent,0);
            $template->assign('parent',$parentClean);
        }
    }
    /**
     * Control, loading and display
     * @access public
     */
	public function run()
    {
		if(isset($this->idPage)){
			$this->load_page_data();
			frontend_model_template::display('cms/index.phtml');
		}
	}
}