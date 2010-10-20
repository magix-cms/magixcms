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
class frontend_db_home{
	/**
	 * include dblang 
	 * @var dblang
	 */
	private $dblang;
	/**
	 * singleton dbhome
	 * @access public
	 * @var void
	 */
	static public $dbhome;
	/**
	 * Function construct class
	 *
	 */
	function __construct(){
		$this->dblang = new frontend_db_lang();
	}
	/**
	 * instance frontend_db_home with singleton
	 */
	public static function getHome(){
        if (!isset(self::$dbhome)){
         	self::$dbhome = new frontend_db_home();
        }
    	return self::$dbhome;
    }
	/**
	 * selection du titre et du contenu de la page home ou index
	 * @param $codelang
	 */
	function s_home_page_construct($codelang){
		$idlang = $this->dblang->s_lang($codelang);
		if($codelang == null){
			$sql = 'SELECT subject,content,metatitle,metadescription FROM mc_page_home WHERE idlang = :idlang';
			return magixglobal_model_db::layerDB()->selectOne($sql,
				array(
					':idlang' => 0
				)
			);
		}else{
			$sql = 'SELECT subject,content,metatitle,metadescription FROM mc_page_home WHERE idlang = :idlang';
			return magixglobal_model_db::layerDB()->selectOne($sql,
				array(
					':idlang' => $idlang['idlang']
				)
			);
		}
	}
}