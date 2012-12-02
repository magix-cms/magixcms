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
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be> | <gerits.aurelien@gmail.com>
 * @name dateformat
 *
 */
class magixglobal_model_dateformat extends DateTime{
	/**
	 * création de l'objet datetime
	 * @param string $time
	 * @param DateTimeZone $timezone
	 */
	private function create($time = "now", DateTimeZone $timezone = NULL){
		if ($timezone != NULL)
			return new self($time, $timezone);
		else
			return new self($time);
	}
    /**
     * Instance la classe DateTime
     * @param  $time
     * @throws Exception
     */
    private function _datetime($time){
    	$datetime = self::create($time);
    	if($datetime instanceof DateTime){
    		return $datetime;
    	}else{
    		throw new Exception('not instantiate the class: DateTime');
    	}
    }
    /**
     * @access public
     * Test la validité de la date
     * @param integer $y
     * @param integer $m
     * @param integer $d
     * @static
     */
	static public function isValid( $y = null, $m = null, $d = null ){
		if ( $y === null || $m === null || $d === null ) return false ;
		return checkdate( $m, $d, $y ) ;
	}
	/**
	 * 
	 * @param string $format
	 * @param string $time
	 */
	public function dateDefine($format='Y-m-d',$time=null){
		return self::_datetime($time)->format($format) ;
	}
	/**
	 * @access public
	 * Retourne la date actuelle et l'heure formatée Y-m-d H:i:s
	 * @example 
	 * $datecreate = new magixglobal_model_dateformat();
	 * echo $datecreate->sitemap_lastmod_dateFormat();
	 */
	public function sitemap_lastmod_dateFormat($time=null){
		return $this->dateDefine('Y-m-d H:i:s',$time);
	}
	/**
	 * @access public
	 * Retourne la date au format européen avec slash (2000/01/01)
	 * @param timestamp $date
	 * @example 
	 * $datecreate = new magixglobal_model_dateformat();
	 * echo $datecreate->date_europeen_format('2000-01-01');
	 */
	public function date_europeen_format($time=null){
		return $this->dateDefine('Y/m/d',$time);
	}
	/**
	 * @access public
	 * Retourne la date au format W3C
	 * $datecreate = new magixglobal_model_dateformat();
	 * echo $datecreate->date_w3c('2005-08-15');
	 * 2005-08-15T15:52:01+00:00
	 */
	public function date_w3c($time=null){ 
		return $this->dateDefine(DATE_W3C,$time);
	}
	/**
	 * @access public
	 * Retourne le timestamp au format unix
	 */
	public function getTimestamp($time=null){
		return $this->dateDefine("U",$time);
	}
	/**
	 * @access public
	 * Retourne la date au format SQL
	 */
	public function SQLDate($time=null){
		return $this->dateDefine("Y-m-d",$time);
	}
	/**
	 * @access public
	 * Retourne la date et l'heure au format SQL
	 */
	public function SQLDateTime($time=null){
		return $this->dateDefine("Y-m-d H:i:s",$time);
	}
	/**
	 * @access public
	 * Retourne la différence entre deux dates
	 * @param string $dateTime
	 */
	public function dateDiff($time1,$time2){
		$datetime1 = $this->SQLDate($time1);
		$datetime2 = $this->SQLDate($time2);
		$interval = $datetime1->diff($datetime2);
		return $interval->format('%R%a days');
	}
}
?>