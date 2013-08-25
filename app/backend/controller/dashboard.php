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
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2008 - 2013 Gerits Aurelien,
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name dashboard
 *
 */
class backend_controller_dashboard extends backend_db_dashboard{
	/**
	 * @static 
	 * @var readInstance
	 */
	static protected $SimpleXMLElement;
    /**
     * @var string
     */
    public $action;
	/**
	 * function construct
	 *
	 */
	function __construct(){
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
    }
	/**
	 * Charge le fichier version.xml courant
	 * @return string
	 */
	private function load_local_file(){
		return magixglobal_model_system::base_path().'version.xml';
	}
	/**
	 * Lit le fichier version.xml local et retourne le numéro de version
	 */
	private function read_local_version(){
		try {
			$xml = new SimpleXMLElement(self::load_local_file(),0, TRUE);
			$v = $xml->number;
		} catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
		return $v;
	}
	/**
	 * Lit le fichier version.xml local et retourne la phase en court (alpha,beta,RC,Stable)
	 */
	private function read_local_phase(){
		try {
			$xml = new SimpleXMLElement(self::load_local_file(),0, TRUE);
			$v = $xml->phase;
		} catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
		return $v;
	}

    /**
     * Affiche la version du CMS ainsi que le message attaché
     * @param $create
     */
    private function format_version($create){
        $version = '<strong>'.self::read_local_version().'</strong> ('.self::read_local_phase().')';
        $create->assign('version', $version, true);
        $create->display('dashboard/version.tpl');
	}

    /**
     * Retourne un tableau des statistiques des utilisateurs
     * @return array
     */
    private function load_stats_user(){
        $data = parent::c_users();
        foreach($data as $key){
            $role_user[]=$key['ROLE_USER'];
            $count_user[]=$key['COUNT_USER'];
        }
        return array_combine($role_user,$count_user);
    }

	/**
	 * Execute les scripts du dashboard
	 */
	public function run(){
        $create = new backend_controller_template();
        if(isset($this->action)){
            if($this->action == 'version'){
                $this->format_version($create);
            }
        }else{
            $create->addConfigFile(array(
                    'dashboard'
                ),array('dashboard_'),false
            );
            // Assigne un tableau des langues
            $create->assign('array_stats_user',self::load_stats_user());
            $create->display('dashboard/index.tpl');
        }
	}
}
?>