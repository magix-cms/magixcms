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
	 * 
	 * @var string
	 */
	public $moreinfo;
	/**
	 * 
	 * @var string
	 */
	public $programme;
	/**
	 * 
	 * @var string
	 */
	public $nom;
	/**
	 * 
	 * @var string
	 */
	public $prenom;
	/**
	 * 
	 * @var string
	 */
	public $email;
	/**
	 * 
	 * @var string
	 */
	public $tel;
	/**
	 * 
	 * @var string
	 */
	public $adresse;
	/**
	 * 
	 * @var string
	 */
	public $message;
	/**
	 * Class constructor
	 */
	function __construct(){
		if(isset($_POST['moreinfo'])){
			$this->moreinfo = $_POST['moreinfo'];
		}
		if(isset($_POST['programme'])){
			$this->programme = magixcjquery_form_helpersforms::inputClean($_POST['programme']);
		}
		if(isset($_POST['nom'])){
			$this->nom = magixcjquery_form_helpersforms::inputClean($_POST['nom']);
		}
		if(isset($_POST['prenom'])){
			$this->prenom = magixcjquery_form_helpersforms::inputClean($_POST['prenom']);
		}
		if(isset($_POST['email'])){
			$this->email = magixcjquery_form_helpersforms::inputClean($_POST['email']);
		}
		if(isset($_POST['tel'])){
			$this->tel = magixcjquery_form_helpersforms::inputClean($_POST['tel']);
		}
		if(isset($_POST['adresse'])){
			$this->adresse = magixcjquery_form_helpersforms::inputClean($_POST['adresse']);
		}
		if(isset($_POST['message'])){
			$this->message = magixcjquery_form_helpersforms::inputClean($_POST['message']);
		}
	}
	/**
	 * Construction du titre pour la récupération des mails
	 */
	protected function subject(){
		if(isset($this->moreinfo)){
			$subject = 'demande sur '.$this->programme;
		}else{
			$subject = 'demande d\'informations';
		}
		return $subject;
	}
	/**
	 * Construction du corps du message
	 */
	protected function body_message(){
		return
		'<html><body>'.
		'<table>'.
		'<tr>'.
			'<td><strong>Nom: </strong>'.$this->nom.'</td>'.
		'</tr>'.
		'<tr>'.
			'<td><strong>Prénom: </strong>'.$this->prenom.'</td>'.
		'</tr>'.
		'<tr>'.
			'<td><strong>Email: </strong>'.$this->email.'</td>'.
		'</tr>'.
		'<tr>'.
			'<td><strong>Tel: </strong>'.$this->tel.'</td>'.
		'</tr>'.
		'<tr>'.
			'<td><strong>Adresse: </strong>'.$this->adresse.'</td>'.
		'</tr>'.
		'<tr>'.
			'<td><strong>Demande: </strong>'.$this->programme.'</td>'.
		'</tr>'.
		'<tr>'.
			'<td><strong>Message: </strong>'.str_replace(array("\n"), array('<br />'), $this->message).'</td>'.
		'</tr>'.
		'</table>'
		.'</body></html>';
	}

	/**
	 * Envoi du mail 
	 * Si return true retourne success.tpl
	 * sinon retourne empty.tpl
	 */
	protected function send_email($create){
		if(isset($this->email)){
            $create->configLoad();
			if(empty($this->nom) OR empty($this->prenom) OR empty($this->email)){
				$create->display('empty.tpl');
			}elseif(!magixcjquery_filter_isVar::isMail($this->email)){
				$create->display('mail.tpl');
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
									self::subject(),
									array($this->email),
									array($recipient['mail_contact']),
									self::body_message(),
									false
								);
								$core_mail->batch_send_mail($message);
							}
							$create->display('success.tpl');
						}else{
							$create->display('error_email_config.tpl');
						}
					}else{
						$create->display('error_install.tpl');
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