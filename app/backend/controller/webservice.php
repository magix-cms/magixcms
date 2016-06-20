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
 * @category   Controller
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2008 - 2016 Gerits Aurelien,
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name webservice
 *
 */

class backend_controller_webservice extends backend_db_webservice{
    /**
     * @var
     */
    protected $header, $template, $message;
    public static $notify = array('plugin' => 'false');
    public $ws_key,$status_key;
    /**
     * backend_controller_webservice constructor.
     */
    public function __construct()
    {
        if (class_exists('backend_model_message')) {
            $this->message = new backend_model_message();
        }
        $this->header = new magixglobal_model_header();
        $this->template = new backend_controller_template();
        if(magixcjquery_filter_request::isPost('ws_key')){
            $this->ws_key = magixcjquery_form_helpersforms::inputClean($_POST['ws_key']);
        }
        if (magixcjquery_filter_request::isPost('status_key')) {
            $this->status_key = 1;
        }
    }

    /**
     * @return array
     */
    private function setItemData(){
        return parent::fetch();
    }

    /**
     * @throws Exception
     */
    private function getItemData(){
        $data = $this->setItemData();
        $this->template->assign('getItemData',$data);
    }

    /**
     * save
     */
    private function save(){
        $data = parent::fetch();
        if(!isset($this->status_key)){
            $status_key = '0';
        }else{
            $status_key = $this->status_key;
        }
        if($data['idwskey'] != null){
            parent::update(array('id'=>$data['idwskey'],'key'=>$this->ws_key,'status'=>$status_key));
            $this->message->json_post_response(true,'update',self::$notify);
        }else{
            parent::insert(array('key'=>$this->ws_key,'status'=>$status_key));
            $this->message->json_post_response(true,'add',self::$notify);
        }
    }
    /**
     * @throws Exception
     */
    public function run(){
        if(isset($this->ws_key)){
            $header= new magixglobal_model_header();
            $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
            $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
            $header->pragma();
            $header->cache_control("nocache");
            $header->getStatus('200');
            $header->json_header("UTF-8");
            $this->save();
        }else{
            $this->getItemData();
            $this->template->display('webservice/index.tpl');
        }
    }
}
?>