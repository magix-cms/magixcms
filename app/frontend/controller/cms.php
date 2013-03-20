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
     * getidpage_p catch on GET
     * @var integer
     */
	public $getidpage_p;
    /**
     * geturi_page_p catch on GET
     * @var integer
     */
	public $geturi_page_p;
    /**
     * getidpage catch on GET
     * @var integer
     */
	public $getidpage;
    /**
     * geturi_page catch on GET
     * @var integer
     */
	public $geturi_page;
	/**
	 * function construct
	 *
	 */
	function __construct()
    {
		if (magixcjquery_filter_request::isGet('getidpage_p')) {
			$this->getidpage_p = magixcjquery_filter_isVar::isPostAlphaNumeric($_GET['getidpage_p']);
		}
		if (magixcjquery_filter_request::isGet('geturi_page')) {
			$this->geturi_page = magixcjquery_filter_isVar::isPostAlphaNumeric($_GET['geturi_page']);
		}
		if (magixcjquery_filter_request::isGet('getidpage_p')) {
			$this->getidpage_p = magixcjquery_filter_isVar::isPostNumeric($_GET['getidpage_p']);
		}
		if (magixcjquery_filter_request::isGet('getidpage')) {
			$this->getidpage = magixcjquery_filter_isVar::isPostNumeric($_GET['getidpage']);
		}
	}
    /**
     * Assign page's data to smarty
     * @access private
     */
	private function load_page_data()
    {
        // *** Load Sql data
		$data = parent::s_page_data($this->getidpage);
        // ** Set url
        $data['url']['page'] = magixglobal_model_rewrite::filter_cms_url(
            $data['iso'],
            $data['idpage_p'],
            $data['uri_page_p'],
            $data['idpage'],
            $data['uri_page'],
            true
        );
        // *** Assign data to Smarty var
        $template = new frontend_model_template();
        /** @noinspection PhpParamsInspection */

        $template->assign('name_page',          $data['title_page'],    true);
        $template->assign('content_page',       $data['content_page'],  true);
        $template->assign('url_page',           $data['url']['page'],   true);
        $template->assign('dateUpdate_page',    $data['last_update'],   true);
        $template->assign('dateRegister_page',  $data['date_register'], true);
        $template->assign('seoTitle_page',      $data['seo_title_page'],true);
        $template->assign('seoDescr_page',      $data['seo_desc_page'], true);

        // ** Assign parent page data
        if ($data['idpage_p'] != null){
            $data['url']['page_p'] = magixglobal_model_rewrite::filter_cms_url(
                $data['iso'],
                null,
                null,
                $data['idpage_p'],
                $data['uri_page_p'],
                true
            );
            /** @noinspection PhpParamsInspection */
            $template->assign('name_page_p',$data['title_page_p'],true);
            $template->assign('url_page_p',$data['url']['page_p'],true);
        }
    }
    /**
     * Control, loading and display
     * @access public
     */
	public function run()
    {
		if(isset($this->getidpage)){
			$this->load_page_data();
			frontend_model_template::display('cms/index.phtml');
		}
	}
}