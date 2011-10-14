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
 * @package    magixglobal
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be> | <gerits.aurelien@gmail.com>
 * @name imagepath
 *
 */
class magixglobal_model_imagepath{
	/**
	 * 
	 * Définition du module à appliquer
	 * @var string
	 */
	public $settingFilter;
	/**
	 * 
	 * Constructeur
	 * @param string $type
	 */
	public function __construct($type=''){
		if(isset($type)){
			$this->settingFilter = $type;
		}else{
			$this->settingFilter = '';
		}
	}
	/**
	 * @access private
	 * Identification de la traduction des urls du module catalogue
	 * @param string $lang
	 */
	private function getTypeModule(){
		switch($this->settingFilter){
			case 'catalog':
				$rootPath = '/upload/catalogimg';
			break;
			case 'news':
				$rootPath = '/upload/news';
			break;
			default:
				$rootPath = $this->settingFilter;
			break;
		}
		return $rootPath;
	}
	/**
	 * 
	 * Chemin des images
	 * @param string $level
	 * @param string $img
	 */
	public function filter_path_img($level=false,$img){
		switch($this->settingFilter){
			case 'catalog':
				if($level == 'category'){
					return $this->getTypeModule($this->settingFilter).'/category/'.$img;
				}elseif($level == 'subcategory'){
					return $this->getTypeModule($this->settingFilter).'/subcategory/'.$img;
				}elseif($level == 'product'){
					return $this->getTypeModule($this->settingFilter).'/'.$img;
				}elseif($level == 'galery'){
					return $this->getTypeModule($this->settingFilter).'/galery/'.$img;
				}
			case 'news' :
				return $this->getTypeModule($this->settingFilter).'/'.$img;
			break;
			default :
				return $this->getTypeModule($this->settingFilter).$img;
		}
	}
}