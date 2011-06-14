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
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.1
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name plugins
 *
 */
class backend_db_plugins{
    /**
     * Requête pour la construction du menu des plugins disponible
     */
	public function s_plugins_navigation_construct(){
    	$sql = 'SELECT p.idplugin,p.pname FROM mc_plugins_module AS p WHERE p.pageadmin = 1';
		return magixglobal_model_db::layerDB()->select($sql);
    } 
    /**
     * 
     * @param $getplugin
     */
    /*public function s_plugins_page_index($getplugin){
    	$sql = 'SELECT p.idplugin,p.pname FROM mc_plugins_module AS p WHERE pname = :getplugin';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':getplugin'=>$getplugin
		));
    } */
}