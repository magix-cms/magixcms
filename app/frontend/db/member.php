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
 * @category   DB CLass 
 * @package    Magix CMS
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.2
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 *
 */
class frontend_db_member{
	/**
	 * singleton dbnews
	 * @access public
	 * @var void
	 */
	static public $dbmember;
	/**
	 * instance frontend_db_news with singleton
	 */
	public static function dbMember(){
        if (!isset(self::$dbmember)){
         	self::$dbmember = new frontend_db_member();
        }
    	return self::$dbmember;
    }
	/**
	 * Selectionne les membres avec un statut plus grand que 3 (user admin et user)
	 */
	function s_members_user_states(){
		$sql = 'SELECT m.pseudo,m.email,p.perms from mc_admin_member m
			LEFT JOIN mc_admin_perms p ON(m.idadmin = p.idadmin)
			WHERE p.perms >= 3';
		return magixglobal_model_db::layerDB()->select($sql);
	}
}