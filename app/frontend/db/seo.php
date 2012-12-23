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
 * @category   DB 
 * @package    frontend
 * @copyright  MAGIX CMS Copyright (c) 2011 - 2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @id  $Id$  
 * @rev $Rev$ 
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be> $Author$
 * @name SEO
 *
 */
class frontend_db_seo{
	/**
	 * 
	 * Sélectionne la métas suivant l'attribut et le niveau
	 * @param string $attribute
	 * @param integer $level
	 * @param integer $idmetas
	 * @param string $codelang
	 */
	protected function s_public_rewrite($attribute,$level,$idmetas,$iso){
		$sql = 'SELECT m.*,lang.iso
		FROM mc_metas_rewrite AS m
		LEFT JOIN mc_lang AS lang USING(idlang)
		WHERE m.attribute = :attribute AND m.level = :level
		AND m.idmetas = :idmetas AND lang.iso = :iso';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':attribute'=>$attribute,
			':level'	=>$level,
			':idmetas'	=>$idmetas,
			':iso' =>$iso
		));
	}
}
?>