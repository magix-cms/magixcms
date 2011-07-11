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
 * @category   DB 
 * @package    frontend
 * @copyright  MAGIX CMS Copyright (c) 2011 -2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.0 $Id$
 * @id $Rev$
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name cms
 *
 */
class frontend_db_cms{
    /**
     * ################################ Pages ###############################
     */
	/**
	 * Affiche les données d'une page CMS
	 * @param $getidpage
	 */
	protected function s_data_current_page($iso,$getidpage){
		$sql = 'SELECT p.idpage,p.idcat_p,title_page,uri_page,content_page,seo_title_page,seo_desc_page,date_register,last_update,lang.iso
				FROM mc_cms_pages as p
				JOIN mc_lang AS lang ON(p.idlang = lang.idlang)
				WHERE lang.iso = :iso AND p.idpage = :getidpage';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':iso'=>$iso,
			':getidpage'=>$getidpage
		));
	}
	/**
	 * Affiche les données d'une page CMS
	 * @param $getidpage
	 */
	protected function s_data_parent_page($getidpage_p){
		$sql = 'SELECT p.idpage,title_page,uri_page,lang.iso
				FROM mc_cms_pages as p
				JOIN mc_lang AS lang ON(p.idlang = lang.idlang)
				WHERE p.idpage = :getidpage_p';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':getidpage_p'=>$getidpage_p
		));
	}
}