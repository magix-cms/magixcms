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
 * @category   contact 
 * @package    plugins
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name contact
 * Le plugin contact
 *
 */
class plugins_contact_public extends database_plugins_contact{
	/**
	 * 
	 * @var mail
	 * @static
	 */
	static protected $mail;
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
	 * Instance la classe modele mail (singleton)
	 */
	protected function mail(){
        if (!isset(self::$mail)){
         	self::$mail = new frontend_model_mail();
        }
    	return self::$mail;
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
			'<td><strong>Message: </strong>'.$this->message.'</td>'.
		'</tr>'.
		'</table>'
		.'</body></html>';
	}
	/**
	 * Envoi du mail 
	 * Si return true retourne success.phtml
	 * sinon retourne empty.phtml
	 */
	protected function send_email(){
		if(isset($this->email)){
			if(empty($this->nom) OR empty($this->prenom) OR empty($this->email)){
				frontend_controller_plugins::configLoad();
				frontend_controller_plugins::getConfigVars("fields_empty");
				$fetch = frontend_controller_plugins::append_fetch('empty.phtml');
				frontend_controller_plugins::append_assign('msg',$fetch);
			}elseif(!magixcjquery_filter_isVar::isMail($this->email)){
				$fetch = frontend_controller_plugins::append_fetch('mail.phtml');
				frontend_controller_plugins::append_assign('msg',$fetch);
			}else{
				self::mail()->simple_mail_html_head($this->email);
				self::mail()->mail_subject(self::subject());
				self::mail()->mail_body(self::body_message());
				if(isset($_GET['strLangue'])){
					if(parent::c_show_table() != 0){
						if(parent::s_register_contact_with_lang($_GET['strLangue']) != null){
							$s = '';
							foreach (parent::s_register_contact_with_lang($_GET['strLangue']) as $list) {
								$s .= self::mail()->mail_add_Address($list['email'],$list['pseudo']);
							}
						}else{
							self::mail()->select_mail_user();
						}
					}else{
						self::mail()->select_mail_user();
					}
				}else{
					if(parent::c_show_table() != 0){
						if(parent::s_register_contact_no_lang() != null){
							$s = '';
							foreach (parent::s_register_contact_no_lang() as $list){
								$s .= self::mail()->mail_add_Address($list['email'],$list['pseudo']);
							}
						}else{
							self::mail()->select_mail_user();
						}
					}else{
						self::mail()->select_mail_user();
					}
				}
				self::mail()->mail_submit();
				self::mail()->clean_Submit();
				$fetch = frontend_controller_plugins::append_fetch('success.phtml');
				frontend_controller_plugins::append_assign('msg',$fetch);
			}
		}
	}
	/**
	 * Execute le plugin dans la partie public
	 */
	public function run(){
		self::send_email();
		frontend_controller_plugins::append_display('index.phtml');
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
	/**
	 * @access protected
	 * Selectionne les contacts pour le formulaire de base sans langue 
	 */
	protected function s_register_contact_no_lang(){
		$sql = 'SELECT c.idlang,lang.codelang,m.email,m.pseudo FROM mc_plugins_contact c
		LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
		LEFT JOIN mc_admin_member as m ON ( c.idadmin = m.idadmin )
		WHERE c.idlang = 0';
		return frontend_db_plugins::layerPlugins()->select($sql);
	}
	/**
	 * @access protected
	 * Selectionne les contacts pour le formulaire avec langue 
	 */
	protected function s_register_contact_with_lang($codelang){
		$sql = 'SELECT c.idlang,lang.codelang,m.email,m.pseudo FROM mc_plugins_contact c
		LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
		LEFT JOIN mc_admin_member as m ON ( c.idadmin = m.idadmin )
		WHERE lang.codelang = :codelang';
		return frontend_db_plugins::layerPlugins()->select($sql,array(':codelang'=>$codelang));
	}
}
?>