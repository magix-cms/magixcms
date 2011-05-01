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
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <gerits.aurelien@gmail.com>
 * @name dateformat
 *
 */
class magixglobal_model_dateformat extends DateTime{
	/**
	 * 
	 * Constructor
	 * @param $time
	 */
	public function __construct($time='now') {
        parent::__construct($time);
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
	 * @access public
	 * Retourne la date actuelle et l'heure formatée Y-m-d H:i:s
	 * @example 
	 * $datecreate = new magixglobal_model_dateformat();
	 * echo $datecreate->sitemap_lastmod_dateFormat();
	 */
	public function sitemap_lastmod_dateFormat(){
		return $this->format('Y-m-d H:i:s');
	}
	/**
	 * @access public
	 * Retourne la date au format européen avec slash (2000/01/01)
	 * @param timestamp $date
	 * * @example 
	 * $datecreate = new magixglobal_model_dateformat('2000-01-01');
	 * echo $datecreate->date_europeen_format();
	 */
	public function date_europeen_format(){
		return $this->format('Y/m/d');
	}
	/**
	 * @access public
	 * Retourne la date au format W3C
	 * $datecreate = new magixglobal_model_dateformat('2005-08-15');
	 * echo $datecreate->date_w3c();
	 * 2005-08-15T15:52:01+00:00
	 */
	public function date_w3c(){ 
		return $this->format(DATE_W3C);
	}
	/**
	 * @access public
	 * Retourne le timestamp au format unix
	 */
	public function getTimestamp(){
	    return $this->format("U");
	}
	/**
	 * @access public
	 * Retourne la date au format SQL
	 */
	public function SQLDate(){
		return $this->format("Y-m-d");
	}
	/**
	 * @access public
	 * Retourne la date et l'heure au format SQL
	 */
	public function SQLDateTime(){
		return $this->format( 'Y-m-d H:i:s' ) ;
	}
}
?>