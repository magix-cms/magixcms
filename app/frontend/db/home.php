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
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.2
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 *
 */
class frontend_db_home{
	/**
	 * selection du titre et du contenu de la page home ou index
	 */
	protected function s_get_home_page_default(){
		$sql = 'SELECT h.subject,h.content,h.metatitle,h.metadescription,lang.iso,h.idlang
				FROM mc_page_home AS h
				JOIN mc_lang AS lang ON(h.idlang = lang.idlang) 
				WHERE lang.default_lang = 1';
		return magixglobal_model_db::layerDB()->selectOne($sql);
	}
	/**
	 * selection du titre et du contenu de la page home ou index
	 */
	protected function s_get_home_page($iso){
		$sql = 'SELECT h.subject,h.content,h.metatitle,h.metadescription,lang.iso,h.idlang
				FROM mc_page_home AS h
				JOIN mc_lang AS lang ON(h.idlang = lang.idlang) 
				WHERE lang.iso = :iso';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':iso'=>$iso
		));
	}
}