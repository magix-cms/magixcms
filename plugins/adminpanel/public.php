<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 magix-cms.com <support@magix-cms.com>
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
 * @category   adminpanel
 * @package    plugins
 * @copyright  MAGIX CMS Copyright (c) 2008 - 2015 Gerits Aurelien,
 * http://www.magix-cms.com,  http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.0
 * Author: Salvatore Di Salvo
 * Date: 12-02-16
 * Time: 10:24
 * @name adminpanel
 * Le plugin adminpanel
 */
class plugins_adminpanel_public extends database_plugins_adminpanel{
    /**
     * @var frontend_controller_plugins
     */
    protected $template;
    /**
     * Class constructor
     */
    public function __construct(){
        $this->template = new frontend_controller_plugins();
    }

	public function checkAdminSession()
	{
		if (isset($_COOKIE['adminlang'])) {
			$valid = parent::g_session($_COOKIE['adminlang']);
			if( $valid != null ){
				return $valid;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
class database_plugins_adminpanel{
    /**
     * Vérifie si les tables du plugin sont installé
     * @access protected
     * return integer
     */
    protected function c_show_table(){
        $table = 'mc_plugins_adminpanel';
        return frontend_db_plugins::layerPlugins()->showTable($table);
    }

	/**
	 * @param $key
	 * @return array
	 */
	protected function g_session($key)
	{
		$sql = 'SELECT id_admin_session,s.id_admin,pseudo_admin
				FROM mc_admin_session as s
				JOIN mc_admin_employee USING (keyuniqid_admin)
				WHERE id_admin_session = :id_admin_session';

		return magixglobal_model_db::layerDB()->selectOne($sql,array(':id_admin_session'=>$key));
	}
}
?>