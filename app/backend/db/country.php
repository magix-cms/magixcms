<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2016 magix-cms.com <support@magix-cms.com>
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
 * @category   DB 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2008 Gerits Aurelien,
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name country
 *
 */
class backend_db_country{
	/**
	 * @return array
	 */
	protected function select($data){
		if(is_array($data)){
			if($data['context'] === 'all'){
				if(($data['type'] === 'list')){
					$sql = 'SELECT co.*
					FROM mc_country AS co';
					return magixglobal_model_db::layerDB()->select($sql);
				}
				elseif($data['type'] === 'last'){
					$sql = 'SELECT co.*
					FROM mc_country AS co ORDER BY `idcountry` DESC LIMIT 0,1';
					return magixglobal_model_db::layerDB()->select($sql);
				}

			}elseif($data['context'] === 'one'){
				if($data['type'] === 'iso'){
					$sql = 'SELECT co.*
					FROM mc_country AS co 
					WHERE co.iso = :iso';
					return magixglobal_model_db::layerDB()->selectOne($sql,array(
						':iso'	=>	$data['iso']
					));
				}elseif($data['type'] === 'count'){
					$sql = 'SELECT count(co.idcountry) AS datacount
                	FROM mc_country AS co';
					return magixglobal_model_db::layerDB()->selectOne($sql);
				}
			}
		}
	}

	/**
	 * @param $data
	 */
	protected function insert($data)
	{
		if (is_array($data)) {
			$sql = 'INSERT INTO mc_country (iso,country,order_c)
		        VALUE(:iso,:country,:order_c)';
			magixglobal_model_db::layerDB()->insert($sql,
				array(
					':iso' 		=> $data['iso'],
					':country' 	=> $data['country'],
					':order_c' 	=> $data['order_c']
				));
		}
	}
	/**
	 * @param $id
	 */
	protected function delete($id)
	{
		$query = "DELETE FROM mc_country WHERE idcountry = :id";
		magixglobal_model_db::layerDB()->delete($query,array(':id'=>$id));
	}
}