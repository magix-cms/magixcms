<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2012 sc-box.com <support@magix-cms.com>
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
					$setPath = $rootPath.'upload/catalogimg/category/';
				}elseif($levelmod == 'subcategory'){
					$setPath =  $rootPath.'upload/catalogimg/subcategory/';
				}elseif($levelmod == 'galery'){
					$setPath =  $rootPath.'upload/catalogimg/galery/';
				}else{
					$setPath =  $rootPath.'upload/catalogimg/';
				}
			break;
			case 'news':
				$setPath =  $rootPath.'upload/news/';
			break;
			default:
				$setPath = $rootPath.$filtermod;
			break;
		}
		return $setPath;
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
				//throw new Exception('Error filterPathImg :filtermod is not defined');
				$filtermod = '';
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
	/**
	 * @access public
	 * Retourne un tableau avec les images sélectionné
	 * @param string $directory
	 * @param string $exclude
	 * @param array $option
	 * @throws Exception
	 */
	public function scanImage($directory,$exclude,array $option=array('imgsize'=>'mini','reverse'=>false)){
		$makeFiles = new magixcjquery_files_makefiles();
		if(file_exists($directory)){
			$array_dir = $makeFiles->scanDir($directory,$exclude);
			if(is_array($option)){
				switch($option['imgsize']){
					case 'mini':
						$imgsize = '/s_/';
					break;
					case 'medium':
						$imgsize = '/m_/';
					break;
					default:
						$imgsize = '/s_/';
					break;
				}
				if($array_dir != null){
					if(is_array($array_dir)){
						if($option['reverse']){
							$tabs_files = preg_grep($imgsize,$array_dir,PREG_GREP_INVERT);
						}else{
							$tabs_files = preg_grep($imgsize,$array_dir);
						}
						return $tabs_files;
					}else{
						throw new Exception('Error scanImage :array_dir is not array');
					}
				}
			}else{
				throw new Exception('Error scanImage :option is not array');
			}
		}else{
			return null;
		}
	}
}