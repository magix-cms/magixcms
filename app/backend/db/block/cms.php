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
 * @category   DB block
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @id $Id$
 * @version  $Rev$
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be> $Author$
 * @name cms
 *
 */
class backend_db_block_cms{
	/**
     * selectionne les pages cms avec un paramètre optionnelle du nombre
     * @param $limit
     * @param $max
     */
    public static function s_page_plugin($limit=false,$max=null,$offset=null){
    	$limit = $limit ? ' LIMIT '.$max : '';
    	$offset = !empty($offset) ? ' OFFSET '.$offset: '';
		$sql = 'SELECT p.idpage, p.title_page, p.content_page,p.idlang,p.idcat_p, p.uri_page,p.seo_title_page,p.seo_desc_page, lang.iso, m.pseudo,subp.uri_page as uri_category
		FROM mc_cms_pages AS p
		LEFT JOIN mc_cms_pages AS subp ON ( subp.idpage = p.idcat_p )
		JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		JOIN mc_admin_member AS m ON ( p.idadmin = m.idadmin )
    	ORDER BY p.idpage DESC'.$limit.$offset;
		return magixglobal_model_db::layerDB()->select($sql);
    }
}