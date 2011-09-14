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
 * @category   Model 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name sidebarConstruct
 * Model sidebarConstruct
 */
class backend_model_sidebarConstruct{
	/**
	 * Construction de l'url pour l'affichage suivant la langue
	 * @param string $uri /admin/cms.php?
	 * @param string $params getlang
	 */
	public function getlangFilter($uri,$params){
		if(backend_db_block_lang::s_data_lang() != null){
			$list = '<ul>';
			foreach(backend_db_block_lang::s_data_lang() as $slang){
				$list .= '<li>';
				$list .= '<a href="'.$uri.$params.'='.$slang['idlang'].'">';
				$list .= '<img src="/upload/iso_lang/'.$slang['iso'].'.png" alt="'.$slang['iso'].'" /> ';
				$list .= '<span>'.magixcjquery_string_convert::ucFirst($slang['language']).'</span>';
				$list .= '</a>';
				$list .= '</li>';
			}
			$list .= '</ul>';
			return $list;
		}
	}
}
?>