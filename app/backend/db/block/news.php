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
 * @author Gérits Aurélien <aurelien@magix-cms.com> $Author$
 * @name news
 *
 */
class backend_db_block_news{
	/**
     * selectionne les news avec un paramètre optionnelle du nombre
     * @param $limit
     * @param $max
     */
    public static function s_news_plugin($limit=false,$max=null,$offset=null){
    	$limit = $limit ? ' LIMIT '.$max : '';
    	$offset = !empty($offset) ? ' OFFSET '.$offset: '';
    	$sql = 'SELECT n.idnews,n.subject,n.content,lang.codelang,n.idlang,n.date_sent,n.rewritelink,m.pseudo,pub.date_publication,pub.publish
				FROM mc_news AS n
				LEFT JOIN mc_news_publication AS pub ON(pub.idnews = n.idnews)
				LEFT JOIN mc_lang AS lang ON(n.idlang = lang.idlang)
				LEFT JOIN mc_admin_member AS m ON(n.idadmin = m.idadmin) ORDER BY n.idnews DESC'.$limit.$offset;
		return magixglobal_model_db::layerDB()->select($sql);
    }
}