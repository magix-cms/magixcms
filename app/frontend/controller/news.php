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
     * @var string
     */
	public $idNews;
    /**
     * @var int
     */
    public $idPagination;
    /**
     * @var date
     */
	public $dateNews;
     /**
     * @var string
     */
     public $idTag;
	/**
	 * function construct
	 */
	function __construct()
    {
        $FilterRequest  =   new magixcjquery_filter_request();
        $CleanUrl       =   new magixcjquery_url_clean();

		if ($FilterRequest->isGet('getnews')) {
			$this->idNews = magixcjquery_filter_var::clean($_GET['getnews']);

		}
		if ($FilterRequest->isGet('getdate')) {
			$this->dateNews = ($_GET['getdate']);

		}
        $this->idPagination = 1;
		if ($FilterRequest->isGet('page') AND is_numeric($_GET['page'])) {
		          $this->idPagination = intval($_GET['page']);

        }
		if ($FilterRequest->isGet('tag')) {
			$this->idTag = $CleanUrl->make2tagString($_GET['tag']);

		}
	}
    /**
     * Assign news' data to smarty
     * @access private
     */
	private function load_news_data()
    {
        $template = new frontend_model_template();
        $News     = new frontend_model_news();

        $data       = parent::s_newsData($this->idNews,$this->dateNews);
        $dataClean  =   $News->setItemData($data,true);

        $template->assign('news',$dataClean);
	}
	/**
	 * 
	 * fonction run
	 */
	public function run()
    {
        $template = new frontend_model_template();
		if (isset($this->idNews)) {
			$this->load_news_data();
            $template->display('news/news.phtml');

		} elseif (isset($this->idTag)) {
            $template->assign('tag', array('name'=>urldecode($this->idTag)));
            $template->display('news/tag.phtml');

		} else {
            $template->display('news/index.phtml');
		}
	}
}
?>