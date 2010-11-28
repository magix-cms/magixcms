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
 * @category   extends 
 * @package    Smarty
 * @subpackage function
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 *
 */
/**
 * Smarty {rewrite_metas_news} function plugin
 *
 * Type:     function
 * Name:     rewritemetanews
 * Date:     September 06, 2010
 * Purpose:  
 * Examples: {rewrite_metas_news}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 *
 */
function smarty_function_rewrite_metas_news($params, $template){
	$type = $params['type'];
	$p = $params['param'];
	$level = $params['level'];
	$lang = $_GET['strLangue'] ? magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3):'';
	switch ($type){
		case 'title':
			if($lang == null){
				$db = frontend_db_config::frontendDCconfig()->s_plugin_rewrite_meta_emptylanguage(5,1,$level);
			}else{
				$db = frontend_db_config::frontendDCconfig()->s_plugin_rewrite_meta(5,1,$level,$lang);
			}
			if($db != null){
				switch ($level){
				case 0 :
					$content = $db['strrewrite'];
				break;
				case 1 :
					//Tableau des variables à rechercher
					$search = array('[[record]]');
					//Tableau des variables à remplacer 
					$replace = array(magixcjquery_string_convert::ucFirst($p));
					//texte générique à remplacer
					$content = str_replace($search ,$replace,$db['strrewrite']);
				break;
				}
			}else{
				$content = $p;
			}
			break;
		case 'description':
			if($lang == null){
				$db = frontend_db_config::frontendDCconfig()->s_plugin_rewrite_meta_emptylanguage(5,2,$level);
			}else{
				$db = frontend_db_config::frontendDCconfig()->s_plugin_rewrite_meta(5,2,$level,$lang);
			}
			if($db != null){
			switch ($level){
				case 0 :
					$content = $db['strrewrite'];
				break;
				case 1 :
					//Tableau des variables à rechercher
					$search = array('[[record]]');
					//Tableau des variables à remplacer 
					$replace = array(magixcjquery_string_convert::ucFirst($p));
					//texte générique à remplacer
					$content = str_replace($search ,$replace,$db['strrewrite']);
				break;
				}
			}else{
				$content = $p;
			}
			break;
	}
	return $content;
}