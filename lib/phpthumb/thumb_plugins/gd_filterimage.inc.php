<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of PHP Thumb Library (PhpThumb).
# PhpThumb : PHP Thumb Library <http://phpthumb.gxdlabs.com>
# Copyright (C) 2012  Gerits Aurelien <aurelien[at]magix-dev[dot]be>
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
*/
/**
 * GD FilterImage Lib Plugin Definition File
 * 
 * This file contains the plugin definition for the GD FilterImage Lib for PHP Thumb
 * 
 * PHP Version 5 with GD 2.0+
 * PhpThumb : PHP Thumb Library <http://phpthumb.gxdlabs.com>
 * @uses PhpThumb
 * @copyright  MAGIX DEV Copyright (c) 2012 Gerits Aurelien
 * @license    Dual licensed under the MIT or GPL Version 3 licenses. (http://www.opensource.org/licenses/mit-license.php The MIT License)
 * @link http://www.magix-dev.be|http://magix-cjquery.com
 * @version 0.2 (10/03/2012)
 * @author Gérits Aurélien <aurelien[at]magix-dev[dot]be>
 * @name GdFilterImageLib
 * @example:
 * Without argument
 * 
	$thumb = PhpThumbFactory::create('test.jpg');
	$thumb->adaptiveResize(250, 250)->createFilterImage('grayscale',false);
	$thumb->show();
	OR
	$thumb = PhpThumbFactory::create('test.jpg');
	$thumb->resize(250, 250)->createFilterImage('negate',false);
	$thumb->show();
 * OR using PHP constants
	$thumb = PhpThumbFactory::create('test.jpg');
	$thumb->resize(250, 250)->createFilterImage(IMG_FILTER_NEGATE,false);
	$thumb->show();
 * @example 2:
 * With argument
 * 
	$thumb = PhpThumbFactory::create('test.jpg');
	$thumb->adaptiveResize(250, 250)->createFilterImage('colorize',array(0, 255, 0));
	$thumb->show();
 * 
 */
class GdFilterImageLib{
	/**
	 * Instance of GdThumb passed to this class
	 *
	 * @var GdThumb
	 */
	protected $parentInstance;
	protected $currentDimensions;
	protected $workingImage;
	protected $newImage;
	protected $options;
	private $filterType;
	private $filterArg;
	/**
	 * Initialisation des filtres (contante)
	 * @var $filter
	 */
	private static $filter = array(
		'negate'	=>	IMG_FILTER_NEGATE,
		'grayscale'	=>	IMG_FILTER_GRAYSCALE,
		'brightness'=>	IMG_FILTER_BRIGHTNESS,
		'contrast'	=>	IMG_FILTER_CONTRAST,
		'colorize'	=>	IMG_FILTER_COLORIZE,
		'border'	=>	IMG_FILTER_EDGEDETECT,
		'emboss'	=>	IMG_FILTER_EMBOSS,
		'gaussian'	=>	IMG_FILTER_GAUSSIAN_BLUR,
		'selective'	=>	IMG_FILTER_SELECTIVE_BLUR,
		'mean'		=>	IMG_FILTER_MEAN_REMOVAL,
		'smooth'	=>	IMG_FILTER_SMOOTH,
		'pixelat'	=>	IMG_FILTER_PIXELATE
	);
	/**
	 * Initialise la transformation de l'image suivant les paramètres
	 * @param string $workingImage
	 * @param void $filter
	 * @param array $filterArg
	 */
	private function workingFilter($workingImage,$filter,$filterArg = false){
		if($filterArg != false){
			if(is_array($filterArg)){
				$num_arg = count($filterArg);
				if($num_arg == 0){
					$f = imagefilter($workingImage, $filter);
				}else if($num_arg == 1){
					$f = imagefilter($workingImage, $filter, $filterArg[0]);
				}else if($num_arg == 2){
					$f = imagefilter($workingImage, $filter, $filterArg[0], $filterArg[1]);
				}else if($num_arg == 3){
					$f = imagefilter($workingImage, $filter, $filterArg[0], $filterArg[1], $filterArg[2]);
				}else if($num_arg == 4){
					$f = imagefilter($workingImage, $filter, $filterArg[0], $filterArg[1], $filterArg[2], $filterArg[3]);
				}
			}
		}else{
			$f = imagefilter($workingImage, $filter);
		}
		return $f;
	}
	/**
	 * Applique un filtre à une image
	 * @param string $filterType
	 * @param array $filterArg
	 * @param void $that
	 * @throws InvalidArgumentException
	 * @throws RuntimeException
	 */
	public function createFilterImage($filterType, $filterArg = false,  &$that){
		// bring stuff from the parent class into this class...
		$this->parentInstance 		= $that;
		$this->currentDimensions 	= $this->parentInstance->getCurrentDimensions();
		$this->workingImage			= $this->parentInstance->getWorkingImage();
		$width	= $this->currentDimensions['width'];
		$height	= $this->currentDimensions['height'];
		//Filter Type
		$this->filterType = $filterType;
		//Argument du filtre
		$this->filterArg = $filterArg;
		//Test la présence de imagefilter
		if (!function_exists('imagefilter')){
			throw new RuntimeException('Your version of GD does not support image filters.');
		}
		/**
		 * Vérifie si la clé existe dans le tableau pour retourner le filtre adéquate
		 */
		if(array_key_exists($filterType, self::$filter)){
			if (!is_numeric(self::$filter[$filterType])){
				throw new InvalidArgumentException('$filter must be numeric');
			}else{
				$filter = self::$filter[$filterType];
			}
		}
		/**
		 * Si le premier paramètre est une chaine
		 */
		if(is_string($this->filterType)){
			switch($this->filterType){
				case 'grayscale':
					$this->workingFilter($this->workingImage, $filter);
				break;
				case 'brightness':
					if(count($this->filterArg) != 1){
						throw new Exception('brightness arg1 is not define');
					}else{
						$this->workingFilter($this->workingImage, $filter, $this->filterArg);
					}
				break;
				case 'contrast':
					if(count($this->filterArg)  != 1){
						throw new Exception('contrast arg1 is not define');
					}else{
						$this->workingFilter($this->workingImage, $filter, $this->filterArg);
					}
				break;
				case 'colorize':
					if(count($this->filterArg)  != 3){
						throw new Exception('colorize arg1,arg2,arg3 is not define');
					}else{
						$this->workingFilter($this->workingImage, $filter, $this->filterArg);
					}
				break;
				case 'smooth':
					if(count($this->filterArg)  != 1){
						throw new Exception('smooth arg1 is not define');
					}else{
						$this->workingFilter($this->workingImage, $filter, $this->filterArg);
					}
				break;
				case 'pixelate':
					if(count($this->filterArg)  != 2){
						throw new Exception('pixelate arg1,arg2 is not define');
					}else{
						$this->workingFilter($this->workingImage, $filter, $this->filterArg);
					}
				break;
				case 'sepia':
					if(is_array($this->filterArg)){
						$arg = $this->filterArg;
					}else{
						$arg = array(90, 60, 30);
					}
					if(count($arg)  != 3){
						throw new Exception('sepia : colorize arg1,arg2,arg3 is not define');
					}else{
						$this->workingFilter($this->workingImage, self::$filter['grayscale']);
						//$this->workingFilter($this->workingImage, self::$filter['brightness'], array(-20));
						$this->workingFilter($this->workingImage, self::$filter['colorize'], $arg);
					}
				break;
			}
		}else{
			//Si le premier paramètre est de type numérique
			if (!is_numeric($this->filterType)){
				throw new InvalidArgumentException('$filter must be numeric');
			}else{
				$this->workingFilter($this->workingImage, $this->filterType, $this->filterArg);
			}
		}
		return $that;
	}
}
$pt = PhpThumb::getInstance();
$pt->registerPlugin('GdFilterImageLib', 'gd');