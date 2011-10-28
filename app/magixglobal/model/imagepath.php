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
	 * Constructeur
	 * @param string $type
	 */
	public function __construct(){}
	/**
	 * 
	 * Enter description here ...
	 * @param string $filtermod
	 * @param string $levelmod
	 * @param bolean $rootPath
	 */
	private function setPath($filtermod,$levelmod='',$rootPath=false){
		if($rootPath != false){
			$rootPath = magixglobal_model_system::base_path();
		}else{
			$rootPath = '/';
		}
		if(!isset($filtermod)){
			throw new Exception('Error filterPathImg :filtermod is not defined');
		}
		switch($filtermod){
			case 'catalog':
				if($levelmod == 'category'){
					return $rootPath.'upload/catalogimg/category/';
				}elseif($levelmod == 'subcategory'){
					return $rootPath.'upload/catalogimg/subcategory/';
				}elseif($levelmod == 'galery'){
					return $rootPath.'upload/catalogimg/galery/';
				}else{
					return $rootPath.'upload/catalogimg/';
				}
			break;
			case 'news':
				return $rootPath.'upload/news/';
			break;
			default:
				return $rootPath.$filtermod;
			break;
		}
	}
	/**
	 * 
	 * Retourne le chemin vers le dossier img ou vers l'image
	 * @param array $filt_option
	 * @example 
	 	$filter = new magixglobal_model_imagepath();
		print $filter->filterPathImg(array('filtermod'=>'catalog','img'=>'test.png'));
	 */
	public function filterPathImg($filt_option = array('filtermod'=>'','img'=>'','levelmod'=>'','rootPath'=>false)){
		if(is_array($filt_option)){
			if(isset($filt_option['filtermod'])){
				$filtermod = $filt_option['filtermod'];
			}else{
				throw new Exception('Error filterPathImg :filtermod is not defined');
			}
			if(isset($filt_option['img'])){
				$img = $filt_option['img'];
			}else{
				$img = '';
				//throw new Exception('Error filterPathImg :img is not defined');
			}
			if(isset($filt_option['levelmod'])){
				$levelmod = $filt_option['levelmod'];
			}else{
				$levelmod = '';
			}
			if(isset($filt_option['rootPath'])){
				$rootPath = $filt_option['rootPath'];
			}else{
				$rootPath = false;
			}
			return $this->setPath($filtermod,$levelmod,$rootPath).$img;
		}else{
			throw new Exception('Error filterPathImg :filt_option is not array');
		}
	}
}