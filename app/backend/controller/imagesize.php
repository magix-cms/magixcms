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
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2011 - 2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name imagesize
 *
 */
class backend_controller_imagesize extends database_imagesize{
	/**
	 * @access private
	 * Assign les variables pour les paramètres des tailles images
	 */
	private function catalog_assign_img_size($attr_name){
		$setting = new backend_model_setting();
		$setting->assign_img_size($attr_name);
	}
	/**
	 * @access public 
	 * Execute la classe
	 */
	public function run(){
		$this->catalog_assign_img_size('catalog');
		backend_controller_template::display('config/imagesize.phtml');
	}
}
class database_imagesize{
	/**
	 * @access protected
	 * Mise à jour des tailles d'image 
	 * @param integer $num_size
	 * @param string $name_size
	 */
	protected function update_size_img_config($num_size,$name_size){
		$sql = 'UPDATE mc_config_size_img 
		SET num_size = :num_size WHERE name_size = :name_size';
		magixglobal_model_db::layerDB()->update($sql,
		array(
			':num_size'  =>	$num_size,
			':name_size' =>	$name_size
		));
	}
}