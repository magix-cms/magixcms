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
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <gerits.aurelien@gmail.com>
 * @name dateformat
 *
 */
class magixglobal_model_dateformat{
	/**
	 * @access public
	 * Retourne la date actuelle et l'heure formatée Y-m-d H:i:s
	 */
	public function sitemap_lastmod_dateFormat(){
		$datenow = new DateTime('now');
		return $datenow->format('Y-m-d H:i:s');
	}
	/**
	 * @access public
	 * Retourne la date au format européen avec slash
	 * @param timestamp $date
	 */
	public function date_europeen_format($date){
		$date_create = date_create($date);
		return date_format($date_create,'Y/m/d');
	}
}
?>