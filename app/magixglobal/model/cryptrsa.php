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
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name cryptrsa
 *
 */
class magixglobal_model_cryptrsa{
	/**
	 * @static
	 * @access public 
	 * SHA1 HASH
	 */
	public static function hash_sha1($string){
		return sha1($string);
	}
	/**
	 * @static
	 * @access public 
	 * SHA1 HASH
	 */
	public static function hash_md5($string){
		return md5($string);
	}
	/**
	 * @static
	 * @access public 
	 * retourne un identifiant unique
	 */
	public static function uniq_id(){
		$id = uniqid(mt_rand(), true);
		return base_convert($id, 10, 36);
	}
	/**
	 * 
	 * Génération de token ou jeton
	 */
	public function tokenId(){
		return md5(session_id() . time() . $_SERVER['HTTP_USER_AGENT']);
	}
	/**
	 * Génération de micro id
	 * @return string
	 */
	public static function random_generic_ui() {
	    return sprintf('%04x%04x',
	      // 32 bits for "time_low"
	      mt_rand(0, 0xffff), mt_rand(0, 0xffff),
	      // 16 bits for "time_mid"
	      mt_rand(0, 0xffff),
	      // 48 bits for "node"
	      mt_rand(0, 0xffff)
	    );
	}
}