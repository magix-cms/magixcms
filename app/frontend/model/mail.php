<?php
/**
 * MAGIX CMS
 * @category   MODEL 
 * @package    frontend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name MAIL
 *
 */
/**
 * Class mail simple processing
 * @author Aurelien
 *
 */
class frontend_model_mail extends PHPMailer{
	/**
	 * instance global phpmailer
	 * @var mail
	 */
	public $mail;
	public $From     = '';
    public $FromName = '';
	public $WordWrap = 100;
	/**
	 * construct class
	 * @return void
	 */
	function __construct(){
		/*
		* Instance phpmailer
		*/
		$this->mail = new PHPMailer();
		/**
		 * 
		 */
	}
	/**
	 * config language for phpmailer message
	 * @return void
	 */
	private function mail_config_language(){
		if(isset($_SESSION['strLangue'])){
			$lang = $_SESSION['strLangue'];
		}else{
			$lang = 'fr';
		}
		$this->mail->SetLanguage($lang, $_SERVER['DOCUMENT_ROOT']."/lib/phpmailler/language/");
	}
	/**
	 * extract domain
	 * exemple: http//www.mydomain.com => mydomain.com
	 */
	protected function extract_domain(){
		$parse = parse_url(magixcjquery_html_helpersHtml::getUrl(), PHP_URL_HOST);
		return substr($parse,4);
	}
	/**
	 * config header for phpmailer (text brut)
	 * @return void
	 */
	public function simple_mail_head($from=false,$reply=false){
		$this->mail->IsMail();
		$this->mail->isHTML(false);
		$this->mail->Priority = 3;
		$this->mail->Encoding = "8bit";
		$this->mail->CharSet = "utf-8";
		if($reply){
			$this->mail->AddReplyTo = $reply;
		}
		if($from){
			$this->mail->From = $from;
		}
		$this->mail->FromName = self::extract_domain();//substr($_SERVER['HTTP_HOST'],0,-4);
		self::mail_config_language();
	}
	/**
	 * config header for phpmailer (html)
	 * @return void
	 */
	public function simple_mail_html_head($from=false,$reply=false){
		$this->mail->IsMail();
		$this->mail->isHTML(true);
		$this->mail->Priority = 3;
		$this->mail->Encoding = "8bit";
		$this->mail->CharSet = "utf-8";
		if($reply){
			$this->mail->AddReplyTo = $reply;
		}
		if($from){
			$this->mail->From = $from;
		}
		$this->mail->FromName = self::extract_domain();//substr($_SERVER['HTTP_HOST'],0,-4);
		self::mail_config_language();
	}
	/**
	 * title for mail send with phpmailer
	 * @param $subject
	 * @return void
	 */
	public function mail_subject($subject){
		$this->mail->Subject = $subject;
	}
	/**
	 * body for mail send with phpmailer
	 * @param $body
	 * @return void
	 */
	public function mail_body($body){
		$this->mail->Body = $body."\n";
	}
	/**
	 * add address for mail send with phpmailer
	 * @param $email
	 * @param $destinataire
	 * @return void
	 */
	public function mail_add_Address($email,$destinataire=false){
		$this->mail->AddAddress($email,$destinataire=false);
	}
	/**
	 * function submit mail
	 * @return void
	 */
	public function mail_submit(){
		if(!$this->mail->Send()) {
			$this->mail->ErrorInfo;
		}
	}
	/**
	 * clean submission
	 * @return void
	 */
	public function clean_Submit(){
		$this->mail->ClearAddresses();
		unset($this->mail);
	}
	/**
     * Récupération des mails utilisateurs et administrateurs
     */
    public function select_mail_user(){
    	if(frontend_db_member::dbMember()->s_members_user_states() != null){
	    	$mail = null;
	    	foreach(frontend_db_member::dbMember()->s_members_user_states() as $members){
	    		$mail .= self::mail_add_Address($members['email']);
	    	}
    	}
    	return $mail;
    }
}
?>