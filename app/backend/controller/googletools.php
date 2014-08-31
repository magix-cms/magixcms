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
 * http://www.magix-cms.com,http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.5
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name googletools
 *
 */
class backend_controller_googletools extends backend_db_config{
    protected $message;
	/**
	 * @access public
	 * string
	 * @var webmaster
	 */
	public $webmaster,
	/**
	 * @access public
	 * string
	 * @var analytics
	 */
	$analytics,
    /**
     * @access public
     * string
     * @var googleplus
     */
    $googleplus,
    /**
     * @var webmaster
     */
    $robots;
    public $action;
	/**
	 * Function construct
	 */
	function __construct(){
        if(class_exists('backend_model_message')){
            $this->message = new backend_model_message();
        }
		if(magixcjquery_filter_request::isPost('webmaster')){
			$this->webmaster = magixcjquery_form_helpersforms::inputClean($_POST['webmaster']);
		}
		if(magixcjquery_filter_request::isPost('analytics')){
			$this->analytics = magixcjquery_form_helpersforms::inputClean($_POST['analytics']);
		}
        if(magixcjquery_filter_request::isPost('googleplus')){
            $this->googleplus = magixcjquery_form_helpersforms::inputClean($_POST['googleplus']);
        }
        if(magixcjquery_filter_request::isPost('robots')){
            $this->robots = magixcjquery_form_helpersforms::inputClean($_POST['robots']);
        }
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
	}

    /**
     * Chargement de la configuration des googletools
     * @param $create
     */
    private function load_assign_setting($create){
        $data = parent::s_data_setting();
        $assign_exclude = array(
            'theme','editor','magix_version','content_css','concat','cache','robots'
        );
        foreach($data as $key){
            if( !(array_search($key['setting_id'],$assign_exclude) ) ){
                $create->assign($key['setting_id'],$key['setting_value']);
            }
        }
    }

    /**
     * @return string
     * @TODO Traduire la valeur vide du select
     */
    private function load_robots_data(){
        $config = parent::s_setting_id('robots');
        switch($config['setting_value']){
            case 'noindex,nofollow':
                $default_value = 'noindex';
                break;
            case 'index,follow,all':
                $default_value = 'index';
                break;
        }
        $select = backend_model_forms::select_static_row(
            array(
                'noindex,nofollow'=>'noindex',
                'index,follow,all'=>'index'
            ),
            array(
                'attr_name'     =>  'robots',
                'attr_id'       =>  'robots',
                'default_value' =>  array($config['setting_value']=>$default_value),
                'empty_value'   =>  'Selectionner l\'indexation',
                'class'         =>  'form-control',
                'upper_case'    =>  false
            )
        );
        return $select;
    }
    /**
     * Enregistre la configuration des googletools
     * @param $create
     */
    private function save($create){
        if(isset($this->webmaster)){
            $tools = 'webmaster';
        }elseif(isset($this->analytics)){
            $tools = 'analytics';
        }elseif(isset($this->googleplus)){
            $tools = 'googleplus';
        }elseif(isset($this->robots)){
            $tools = 'robots';
        }
        switch($tools){
            case 'webmaster':
                parent::u_setting_value('webmaster',$this->webmaster);
                break;
            case 'analytics':
                parent::u_setting_value('analytics',$this->analytics);
                break;
            case 'googleplus':
                parent::u_setting_value('googleplus',$this->googleplus);
                break;
            case 'robots':
                parent::u_setting_value('robots',$this->robots);
                break;
        }
        $this->message->getNotify('update');
    }

	/**
	 * Execute le module dans l'administration
	 * @access public
	 */
	public function run(){
        $header= new magixglobal_model_header();
        $create = new backend_controller_template();
        $create->addConfigFile(array(
                'googletools'
            ),array('googletools_'),false
        );
        if(isset($this->action)){
            if($this->action === 'edit'){
                if(isset($this->webmaster)
                    OR isset($this->analytics)
                    OR isset($this->googleplus)
                    OR isset($this->robots)){
                    $this->save($create);
                }
            }
        }else{
            $this->load_assign_setting($create);
            $create->assign('select_robots',$this->load_robots_data());
            $create->display('googletools/index.tpl');
        }
	}
}