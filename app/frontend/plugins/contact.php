<?php
/**
 * @category   Plugins 
 * @package    Contact
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com - http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-12-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
class frontend_plugins_contact{
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
	public function mail(){
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
	function body_message(){
		return
		'<html><body>'.
		'<table><tr>'.
		'<td>'.$this->nom.'</td>'.
		'<td>'.$this->prenom.'</td>'.
		'<td>'.$this->email.'</td>'.
		'<td>'.$this->tel.'</td>'.
		'<td>'.$this->adresse.'</td>'.
		'<td>'.$this->programme.'</td>'.
		'<td>'.$this->message.'</td>'.
		'</tr></table>'
		.'</body></html>';
	}
	/**
	 * Envoi du mail bien formé
	 */
	function send_email(){
		if(isset($this->email)){
			if(empty($this->nom) OR empty($this->prenom) OR empty($this->email)){
				$fetch = frontend_config_smarty::getInstance()->fetch('plugins/contact/empty.phtml');
				frontend_config_smarty::getInstance()->assign('msg',$fetch);
			}else{
				self::mail()->simple_mail_html_head();
				self::mail()->mail_subject(self::subject());
				self::mail()->mail_body(self::body_message());
				self::mail()->select_mail_user();
				self::mail()->mail_submit();
				self::mail()->clean_Submit();
				$fetch = frontend_config_smarty::getInstance()->fetch('plugins/contact/success.phtml');
				frontend_config_smarty::getInstance()->assign('msg',$fetch);
			}
		}
	}
	/**
	 * Affiche la page du plugin promotions
	 */
	function display(){
		self::send_email();
		frontend_config_smarty::getInstance()->display('plugins/contact/index.phtml');
	}
}
?>