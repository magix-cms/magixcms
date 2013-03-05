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
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name news
 *
 */
class frontend_controller_news extends frontend_db_news
{
    /**
     * strLangue catch on GET
     * @var integer
     */
	public $getlang;
	/**
	 * variable de sessions deslangues
	 * @var string
	 */
	public $slang;
    /**
     * getnews catch on GET
     * @var string
     */
	public $getnews;
    /**
     * getdate catch on GET
     * @var date
     */
	public $getdate;
    /**
     * uri_get_news catch on GET
     * @var string
     */
	public $uri_get_news,
     /**
     * tag catch on GET
     * @var string
     */
     $tag;
	/**
	 * function construct
	 *
	 */
	function __construct()
    {
		if (magixcjquery_filter_request::isGet('strLangue')) {
			$this->getlang = magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3);
		}
		if (magixcjquery_filter_request::isGet('getnews')) {
			$this->getnews = magixcjquery_filter_var::clean($_GET['getnews']);
		}
		if (magixcjquery_filter_request::isGet('getdate')) {
			$this->getdate = ($_GET['getdate']);
		}
		if (magixcjquery_filter_request::isGet('uri_get_news')) {
			$this->uri_get_news = magixcjquery_url_clean::rplMagixString($_GET['uri_get_news']);
		}
		if (magixcjquery_filter_request::isGet('page')) {
				// si numéric
		      if (is_numeric($_GET['page'])) {
		          $this->getpage = intval($_GET['page']);
		      } else {
		      	// Sinon retourne la première page
		          $this->getpage = 1;        
               }
		 } else {
		    $this->getpage = 1;
		}
		if (magixcjquery_filter_request::isGet('tag')) {
			$this->tag = magixcjquery_url_clean::make2tagString($_GET['tag']);
		}
	}
    /**
     * Assign news' data to smarty
     * @access private
     */
	private function load_news_data()
    {
        $data = parent::s_newsData($this->getnews,$this->getdate);
        $data['imgPath'] = null;
        if ($data['n_image'] != null) {
            $data['imgPath'] = '/upload/news/'.$data['n_image'];
        }
        // *** Assign data to Smarty var
        $template = new frontend_model_template();
        /** @noinspection PhpParamsInspection */
        $template->assign(
            array(
                'name_news'         =>  $data['n_title'],
                'content_news'      =>  $data['n_content'],
                'dateRegister_news' =>  $data['date_register'],
                'dateUpdate_news'   =>  $data['date_publish'],
                'imgPath_news'      =>  $data['imgPath']
            )
        );
	}
	/**
	 * 
	 * fonction run
	 */
	public function run(){
        $template = new frontend_model_template();
		if (isset($this->getnews)) {
			$this->load_news_data();
            $template->display('news/record.phtml');
		} elseif (magixcjquery_filter_request::isGet('tag')) {
            $template->assign('name_tag', urldecode($this->tag));
            $template->display('news/tag.phtml');
		} else {
            $template->display('news/index.phtml');
		}
	}
}
?>