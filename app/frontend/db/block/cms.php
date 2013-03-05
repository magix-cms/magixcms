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
 * @category   DB CLass 
 * @package    Magix CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 -2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> | <gerits.aurelien@gmail.com>
 *
 */
class frontend_db_block_cms
{
	/**
	 * @access protected
	 * Sélectionne les pages parentes dans la langue
	 * @param integer $getlang
     * @todo replace usages and remove
	 */
	public static function s_parent_p($getlang)
    {
    	$sql = 'SELECT p.idpage,p.idcat_p,p.title_page,p.uri_page,lang.iso
    	FROM mc_cms_pages AS p 
    	JOIN mc_lang AS lang ON(p.idlang = lang.idlang)
    	WHERE lang.iso = :getlang AND p.idcat_p = 0 AND sidebar_page = 1
    	ORDER BY p.order_page';

		return magixglobal_model_db::layerDB()->select($sql,array(
			':getlang' => $getlang
		));
	}
	/**
	 * @access protected
	 * Sélectionne les pages enfants du parent
	 * @param integer $get_page_p
     * @todo replace usages and remove
	 */
	public static function s_child_page($get_page_p)
    {
		$sql = 'SELECT p.idpage,p.idcat_p,p.title_page,p.uri_page,lang.iso
    	FROM mc_cms_pages AS p 
    	JOIN mc_lang AS lang ON(p.idlang = lang.idlang)
    	WHERE p.idcat_p = :get_page_p AND sidebar_page = 1
    	ORDER BY p.order_page';

		return magixglobal_model_db::layerDB()->select($sql,array(
			':get_page_p' => $get_page_p
		));
	}
}