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
	public $id_size_img,$config_size_attr,$width,$height;
	public function __construct(){
		if(magixcjquery_filter_request::isPost('width') AND magixcjquery_filter_request::isPost('height')){
			$this->width = magixcjquery_filter_isVar::isPostNumeric($_POST['width']);
			$this->height = magixcjquery_filter_isVar::isPostNumeric($_POST['height']);
		}
		if(magixcjquery_filter_request::isPost('id_size_img')){
			$this->id_size_img = magixcjquery_filter_isVar::isPostNumeric($_POST['id_size_img']); 
		}
	}
	/**
	 * @access private
	 * Assign les variables pour les paramètres des tailles images
	 */
	private function catalog_assign_img_size($attr_name){
		$setting = new backend_model_setting();
		$setting->assign_img_size($attr_name);
	}
	private function load_img_forms(){
		$setting = new backend_model_setting();
		$input = '';
		foreach($setting->allSizeImg() as $row){
			$input .= '<h4>'.$row['config_size_attr'].'&nbsp;'.$row['type'].'</h4>';
			$input .= '<div style="margin-bottom:5px;">';
			$input .= '<form class="forms-config" method="post" action="" id="'.$row['config_size_attr'].'">';
			$input .= '<input type="hidden" name="id_size_img" value="'.$row['id_size_img'].'" />';
			$input .= '<label>Largeur :</label>';
			$input .= '<input type="text" name="width" class="spincount" value="'.$row['width'].'" size="5" />';
			$input .= '<label>Hauteur :</label>';
			$input .= '<input type="text" name="height" class="spincount" value="'.$row['height'].'" size="5" />&nbsp;';
			$input .= '<input type="submit" value="Save" />';
			$input .= '</div>';
			$input .= '</form>';
		}
		return $input;
	}
	/**
	 * @access private
	 * Mise à jour des tailles images des catégories catalogue 
	 */
	private function update_img(){
		if(isset($this->id_size_img)){
			parent::u_size_img_config($this->width, $this->height, $this->id_size_img);	
		}
	}
	/**
	 * @access public 
	 * Execute la classe
	 */
	public function run(){
		//$this->catalog_assign_img_size('catalog');
		backend_controller_template::assign('img_size_forms', $this->load_img_forms());
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
	protected function u_size_img_config($width,$height,$id_size_img){
		$sql = 'UPDATE mc_config_size_img 
		SET width = :width,height = :height WHERE id_size_img = :id_size_img';
		magixglobal_model_db::layerDB()->update($sql,
		array(
			':width'  =>	$width,
			':height'  =>	$height,
			':id_size_img' =>	$id_size_img
		));
	}
}