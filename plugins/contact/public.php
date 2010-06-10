<?php
/**
 * @category   Plugins 
 * @package    Contact
 * @copyright  Copyright (c) 2009 - 2010 (http://www.cms-site.com - http://www.cms-site.com)
 * @license    Proprietary software
 * @version    1.0 2009-12-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
class plugins_contact_public{
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
				$fetch = frontend_controller_plugins::append_fetch('empty.phtml');
				frontend_controller_plugins::append_assign('msg',$fetch);
			}else{
				self::mail()->simple_mail_html_head($this->email);
				self::mail()->mail_subject(self::subject());
				self::mail()->mail_body(self::body_message());
				self::mail()->select_mail_user();
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
?>