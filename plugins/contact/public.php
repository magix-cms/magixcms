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
 * @category   contact
 * @package    plugins
 * @copyright  MAGIX CMS Copyright (c) 2008 - 2013 Gerits Aurelien,
 * http://www.magix-cms.com,  http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name contact
 * Le plugin contact
 *
 */
class plugins_contact_public extends database_plugins_contact{
    /**
     * @var frontend_controller_plugins
     */
    protected $template;
    /**
     *
     * @var string
     */
    public $moreinfo;
    public $lastname,$firstname,$email,$phone,$adress,$content;
    /**
     * Class constructor
     */
    public function __construct(){
        if(magixcjquery_filter_request::isPost('moreinfo')){
            $this->moreinfo = $_POST['moreinfo'];
        }
        if(magixcjquery_filter_request::isPost('title')){
            $this->title = magixcjquery_form_helpersforms::inputClean($_POST['title']);
        }
        if(magixcjquery_filter_request::isPost('lastname')){
            $this->lastname = magixcjquery_form_helpersforms::inputClean($_POST['lastname']);
        }
        if(magixcjquery_filter_request::isPost('firstname')){
            $this->firstname = magixcjquery_form_helpersforms::inputClean($_POST['firstname']);
        }
        if(magixcjquery_filter_request::isPost('email')){
            $this->email = magixcjquery_form_helpersforms::inputClean($_POST['email']);
        }
        if(magixcjquery_filter_request::isPost('phone')){
            $this->phone = magixcjquery_form_helpersforms::inputClean($_POST['phone']);
        }
        if(magixcjquery_filter_request::isPost('adress')){
            $this->adress = magixcjquery_form_helpersforms::inputClean($_POST['adress']);
        }
        if(magixcjquery_filter_request::isPost('postcode')){
            $this->postcode = magixcjquery_form_helpersforms::inputClean($_POST['postcode']);
        }
        if(magixcjquery_filter_request::isPost('city')){
            $this->city = magixcjquery_form_helpersforms::inputClean($_POST['city']);
        }
        if(magixcjquery_filter_request::isPost('content')){
            $this->content = magixcjquery_form_helpersforms::inputClean($_POST['content']);
        }
        $this->template = new frontend_controller_plugins();
    }

    /**
     * Retourne le message de notification
     * @param $type
     * @param null $subContent
     * @return string
     */
    private function setNotify($type,$subContent=null){
        $this->template->configLoad();
        switch($type){
            case 'warning':
                $warning = array(
                    'empty' =>  $this->template->getConfigVars('fields_empty'),
                    'mail'  =>  $this->template->getConfigVars('mail_format')
                );
                $message = $warning[$subContent];
                break;
            case 'success':
                $message = $this->template->getConfigVars('message_send_success');
                break;
            case 'error':
                $error = array(
                    'installed'   =>  $this->template->getConfigVars('installed'),
                    'configured'  =>  $this->template->getConfigVars('configured')
                );
                $message = sprintf('plugin_error','contact',$error[$subContent]);
                break;
        }

        return array(
            'type'      => $type,
            'content'   => $message
        );
    }

    /**
     * getNotify
     * @param $type
     * @param null $subContent
     */
    private function getNotify($type,$subContent=null){
        $this->template->assign('message',$this->setNotify($type,$subContent));
        $this->template->display('notify/message.tpl');
    }

    /**
     * @access private
     * setBodyMail
     */
    private function setBodyMail(){

        return array(
            'lastname'    =>  $this->lastname,
            'firstname'   =>  $this->firstname,
            'email'       =>  $this->email,
            'phone'       =>  $this->phone,
            'adress'      =>  $this->adress,
            'postcode'    =>  $this->postcode,
            'city'        =>  $this->city,
            'title'       =>  $this->title,
            'content'     =>  $this->content
        );

    }

    /**
     * @return string
     */
    private function setTitleMail(){
        $subject = $this->template->getConfigVars('subject_contact');
        /*if(isset($this->title)){
            $title   = $this->title;
        }else{*/
        $title   = 'Demande de contact';
        /*}*/
        $website = $this->template->getConfigVars('website');
        return sprintf($subject, $title,$website);
    }

    /**
     * @access private
     * @return string
     */
    private function getBodyMail(){
        $this->template->assign('data',$this->setBodyMail());
        return $this->template->fetch('mail/admin.tpl');
    }

    /**
     * @return array
     */
    public function getContact(){
        if(parent::s_contact($this->template->getLanguage()) != null){
            return parent::s_contact($this->template->getLanguage());
        }
    }

    /**
     * Envoi du mail
     * Si return true retourne success.tpl
     * sinon retourne empty.tpl
     */
    protected function send_email($create){
        if(isset($this->email)){
            $create->configLoad();
            if(empty($this->lastname)
                OR empty($this->firstname)
                OR empty($this->email)){
                $this->getNotify('warning','empty');
            }elseif(!magixcjquery_filter_isVar::isMail($this->email)){
                $this->getNotify('warning','mail');
            }elseif(!empty($this->moreinfo)){
				$this->getNotify('error','configured');
            }else{
                if($create->getLanguage()){
                    if(parent::c_show_table() != 0){
                        if(parent::s_contact($create->getLanguage()) != null){
                            //Instance la classe mail avec le paramètre de transport
                            $core_mail = new magixglobal_model_mail('mail');
                            //Charge dans un tableau les utilisateurs qui reçoivent les mails
                            $lotsOfRecipients = parent::s_contact($create->getLanguage());
                            //Initialisation du contenu du message
                            foreach ($lotsOfRecipients as $recipient){
                                $message = $core_mail->body_mail(
                                    self::setTitleMail(),
                                    array($this->email),
                                    array($recipient['mail_contact']),
                                    self::getBodyMail(),
                                    false
                                );
                                $core_mail->batch_send_mail($message);
                            }
                            $this->getNotify('success');
                        }else{
                            $this->getNotify('error','configured');
                        }
                    }else{
                        $this->getNotify('error','installed');
                    }
                }
            }
        }
    }
    /**
     * Execute le plugin dans la partie public
     */
    public function run(){
        $create = frontend_controller_plugins::create();
        $create->configLoad();
        if(isset($this->email)){
            $this->send_email($create);
        }else{
            $create->display('index.tpl');
        }
    }
}
class database_plugins_contact{
    /**
     * Vérifie si les tables du plugin sont installé
     * @access protected
     * return integer
     */
    protected function c_show_table(){
        $table = 'mc_plugins_contact';
        return frontend_db_plugins::layerPlugins()->showTable($table);
    }

    protected function s_contact($iso){
        $sql = 'SELECT c.*
        FROM mc_plugins_contact AS c
        JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
        WHERE lang.iso = :iso';
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':iso'=>$iso
        ));
    }

    /**
     * @access protected
     * Selectionne les contacts pour le formulaire
     */
    /*protected function s_register_contact($iso){
        $sql = 'SELECT c.idlang,lang.iso,m.email,m.pseudo FROM mc_plugins_contact c
        LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
        LEFT JOIN mc_admin_member as m ON ( c.idadmin = m.idadmin )
        WHERE lang.iso = :iso';
        return frontend_db_plugins::layerPlugins()->select($sql,array(':iso'=>$iso));
    }*/
}
?>